<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\PermissionHelper;

class PortalController extends Controller
{
    /**
     * Display the dashboard page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $permissions = [];
        $permissionSummary = [
            'total_permissions' => 0,
            'pages_accessible' => 0,
            'global_actions' => [],
            'page_specific_actions' => [],
        ];
        
        if ($user->role) {
            $permissions = getUserPermissionsByPage($user);
            $permissionSummary = getPermissionSummary($user);
        }
        
        return view('admin.dashboard', compact('permissions', 'permissionSummary'));
    }
}
