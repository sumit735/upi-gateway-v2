<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Page;
use App\Models\Action;
use App\Models\RolePermission;
use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use App\Enums\ScopeEnum;
use Illuminate\Support\Facades\DB;
use App\Models\UserSession;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }
    public function show(Role $role)
    {
        $role->load(['permissions.page', 'permissions.action', 'users']);
        
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'role' => $role
            ]);
        }
        
        return redirect()->route('admin.roles.index');
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $pages = Page::with('actions')->get();
        $scopeEnums = ScopeEnum::cases();
        
        return view('admin.roles.create', compact('pages', 'scopeEnums'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles',
                'description' => 'nullable|string|max:500',
                'permissions' => 'array',
                'permissions.*' => 'string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $role = DB::transaction(function () use ($request) {
            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description,
                'is_default' => $request->boolean('is_default', false),
            ]);

            // Process permissions
            if ($request->has('permissions')) {
                foreach ($request->permissions as $permissionString) {
                    [$pageValue, $actionValue, $scope] = explode(',', $permissionString);
                    
                    $page = Page::where('route_pattern', $pageValue)->first();
                    $action = Action::where('slug', $actionValue)->first();
                    
                    if ($page && $action) {
                        RolePermission::create([
                            'role_id' => $role->id,
                            'page_id' => $page->id,
                            'action_id' => $action->id,
                            'scope' => $scope,
                        ]);
                    }
                }
            }
            
            return $role;
        });

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Role created successfully.',
                'redirect' => route('admin.roles.index')
            ]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $pages = Page::with('actions')->get();
        $scopeEnums = ScopeEnum::cases();
        
        $role->load(['permissions.page', 'permissions.action']);
        
        return view('admin.roles.edit', compact('role', 'pages', 'scopeEnums'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
                'description' => 'nullable|string|max:500',
                'permissions' => 'array',
                'permissions.*' => 'string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        DB::transaction(function () use ($request, $role) {
            $role->update([
                'name' => $request->name,
                'description' => $request->description,
                'is_default' => $request->boolean('is_default', false),
            ]);

            // Delete existing permissions
            $role->permissions()->delete();

            // Process new permissions
            if ($request->has('permissions')) {
                foreach ($request->permissions as $permissionString) {
                    [$pageValue, $actionValue, $scope] = explode(',', $permissionString);
                    
                    $page = Page::where('route_pattern', $pageValue)->first();
                    $action = Action::where('slug', $actionValue)->first();
                    
                    if ($page && $action) {
                        RolePermission::create([
                            'role_id' => $role->id,
                            'page_id' => $page->id,
                            'action_id' => $action->id,
                            'scope' => $scope,
                        ]);
                    }
                }
            }
        });

        // Refresh permissions for current user if they belong to this role
        if (auth()->check() && auth()->user()->role_id === $role->id) {
            auth()->user()->refreshPermissions();
        }

        // Invalidate sessions for other users of this role (they'll need to re-login)
        try {
            $userIds = $role->users()->pluck('id')->toArray();
            $currentUserId = auth()->id();
            $userIds = array_filter($userIds, fn($id) => $id !== $currentUserId);

            if (count($userIds) > 0) {
                $sessionIds = UserSession::whereIn('user_id', $userIds)->pluck('session_id')->toArray();

                if (!empty($sessionIds)) {
                    DB::table('sessions')->whereIn('id', $sessionIds)->delete();
                    UserSession::whereIn('session_id', $sessionIds)->delete();
                }
            }
        } catch (\Exception $e) {
            // ignore failures to avoid blocking role update
        }
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully.',
                'redirect' => route('admin.roles.index')
            ]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Request $request, Role $role)
    {
        if ($role->is_default) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete default role.'
                ], 422);
            }
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete default role.');
        }

        if ($role->users()->count() > 0) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete role with assigned users.'
                ], 422);
            }
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role with assigned users.');
        }

        $role->permissions()->delete();
        $role->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully.'
            ]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
