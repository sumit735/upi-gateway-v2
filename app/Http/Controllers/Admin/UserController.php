<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.users.index', compact('roles'));
    }

    /**
     * Get paginated users list for DataTable (API).
     */
    public function list(Request $request)
    {
        // Get DataTable parameters
        $draw = $request->input('draw', 1);
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $searchValue = $request->input('search.value', '');
        $orderColumn = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        
        // Additional filters
        $roleFilter = $request->input('role_filter');
        $statusFilter = $request->input('status_filter');
        
        // Column mapping for sorting
        $columns = ['id', 'name', 'email', 'role_id', 'created_at', 'is_active'];
        $orderColumnName = $columns[$orderColumn] ?? 'id';
        
        // Build query
        $query = User::with('role');
        
        // Apply search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                  ->orWhere('email', 'like', "%{$searchValue}%")
                  ->orWhere('phone', 'like', "%{$searchValue}%")
                  ->orWhereHas('role', function ($roleQuery) use ($searchValue) {
                      $roleQuery->where('name', 'like', "%{$searchValue}%");
                  });
            });
        }
        
        // Apply role filter
        if (!empty($roleFilter)) {
            $query->where('role_id', $roleFilter);
        }
        
        // Apply status filter
        if ($statusFilter !== null && $statusFilter !== '') {
            $query->where('is_active', $statusFilter);
        }
        
        // Get total records before pagination
        $totalRecords = User::count();
        $filteredRecords = $query->count();
        
        // Apply sorting and pagination
        $users = $query->orderBy($orderColumnName, $orderDir)
                      ->skip($start)
                      ->take($length)
                      ->get();
        
        // Format data for DataTable
        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? 'N/A',
                'role_badge' => $user->role ? '<span class="badge bg-primary">' . $user->role . '</span>' : '<span class="badge bg-secondary">No Role</span>',
                'is_active' => $user->is_active,
                'status_badge' => $user->is_active 
                    ? '<span class="badge bg-success"><i class="ti ti-check me-1"></i>Active</span>' 
                    : '<span class="badge bg-danger"><i class="ti ti-x me-1"></i>Inactive</span>',
                'created_at' => $user->created_at->format('d M Y'),
                'created_at_full' => $user->created_at->format('d M Y, h:i A'),
                'actions' => $this->generateActionButtons($user)
            ];
        });
        
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
    
    /**
     * Generate action buttons for each user.
     */
    private function generateActionButtons($user)
    {
        $buttons = '<div class="d-flex gap-2">';
        
        // View button
        $buttons .= '<button type="button" class="btn btn-sm btn-icon btn-light" onclick="viewUser(' . $user->id . ')" title="View Details">
                        <i class="ti ti-eye"></i>
                    </button>';
        
        // Edit button
        $buttons .= '<a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-sm btn-icon btn-primary" title="Edit User">
                        <i class="ti ti-edit"></i>
                    </a>';
        
        // Toggle status button
        if ($user->is_active) {
            $buttons .= '<button type="button" class="btn btn-sm btn-icon btn-warning" onclick="toggleUserStatus(' . $user->id . ', 0)" title="Deactivate">
                            <i class="ti ti-user-off"></i>
                        </button>';
        } else {
            $buttons .= '<button type="button" class="btn btn-sm btn-icon btn-success" onclick="toggleUserStatus(' . $user->id . ', 1)" title="Activate">
                            <i class="ti ti-user-check"></i>
                        </button>';
        }
        
        // Delete button (only if not current user)
        if (auth()->id() !== $user->id) {
            $buttons .= '<button type="button" class="btn btn-sm btn-icon btn-danger" onclick="deleteUser(' . $user->id . ', \'' . addslashes($user->name) . '\')" title="Delete User">
                            <i class="ti ti-trash"></i>
                        </button>';
        }
        
        $buttons .= '</div>';
        
        return $buttons;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['role', 'userDetail']);
        
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }
        
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => $user->is_active ? 'User activated successfully.' : 'User deactivated successfully.',
            'is_active' => $user->is_active
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.'
            ], 422);
        }
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }
}
