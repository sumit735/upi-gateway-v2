@extends('admin.layouts.app')

@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Roles & Permissions</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Roles</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-2"></i>Create Role
                </a>
            </div>
        </div>
        <!-- /Breadcrumb -->

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Roles Grid -->
        <div class="row">
            @foreach($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card role-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md rounded bg-primary-transparent me-3">
                                    <i class="ti ti-shield fs-18 text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $role->name }}</h5>
                                    @if($role->is_default)
                                        <span class="badge badge-sm bg-success">Default Role</span>
                                    @endif
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="btn btn-light btn-icon btn-sm" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.roles.edit', $role) }}">
                                            <i class="ti ti-edit me-2"></i>Edit Role
                                        </a>
                                    </li>
                                    @if(!$role->is_default && $role->users_count == 0)
                                    <li>
                                        <a class="dropdown-item text-danger" href="javascript:void(0);" 
                                           onclick="deleteRole({{ $role->id }}, '{{ $role->name }}')">
                                            <i class="ti ti-trash me-2"></i>Delete Role
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        @if($role->description)
                        <p class="text-muted mb-3">{{ Str::limit($role->description, 80) }}</p>
                        @endif

                        <div class="row text-center mb-3">
                            <div class="col-6">
                                <div class="border-end">
                                    <h6 class="mb-1 text-primary">{{ $role->users_count }}</h6>
                                    <p class="mb-0 fs-12 text-muted">Users</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="mb-1 text-success">{{ $role->permissions->count() }}</h6>
                                <p class="mb-0 fs-12 text-muted">Permissions</p>
                            </div>
                        </div>

                        @if($role->permissions->count() > 0)
                        <div class="permission-preview mb-3">
                            <h6 class="fs-12 text-muted mb-2">Permissions Preview:</h6>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($role->permissions->take(3) as $permission)
                                <span class="badge badge-sm bg-light text-dark">
                                    {{ $permission->page->name ?? 'Unknown' }} - {{ $permission->action->name ?? 'Unknown' }}
                                </span>
                                @endforeach
                                @if($role->permissions->count() > 3)
                                <span class="badge badge-sm bg-secondary">
                                    +{{ $role->permissions->count() - 3 }} more
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="ti ti-edit me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="viewRoleDetails({{ $role->id }})">
                                <i class="ti ti-eye me-1"></i>View
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @if($roles->isEmpty())
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="avatar avatar-xl rounded bg-light mb-3 mx-auto">
                            <i class="ti ti-shield fs-24 text-muted"></i>
                        </div>
                        <h5 class="mb-2">No Roles Found</h5>
                        <p class="text-muted mb-3">Get started by creating your first role with custom permissions.</p>
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-2"></i>Create First Role
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- /Roles Grid -->

    </div>
</div>
<!-- /Page Wrapper -->

<!-- Role Details Modal -->
<div class="modal fade" id="roleDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-shield me-2"></i>Role Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="roleDetailsContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading role details...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewRoleDetails(roleId) {
    const modal = new bootstrap.Modal(document.getElementById('roleDetailsModal'));
    const content = document.getElementById('roleDetailsContent');
    
    // Show loading state
    content.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Loading role details...</p>
        </div>
    `;
    
    modal.show();
    
    // Fetch role details via AJAX
    fetch(`{{ url('/portal/roles') }}/${roleId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayRoleDetails(data.role);
        } else {
            showError('Failed to load role details');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('An error occurred while loading role details');
    });
}

function displayRoleDetails(role) {
    const content = document.getElementById('roleDetailsContent');
    
    // Group permissions by page
    const permissionsByPage = {};
    role.permissions.forEach(perm => {
        const pageName = perm.page?.name || 'Unknown Page';
        if (!permissionsByPage[pageName]) {
            permissionsByPage[pageName] = [];
        }
        permissionsByPage[pageName].push(perm);
    });
    
    // Generate users list HTML
    let usersHtml = '';
    if (role.users && role.users.length > 0) {
        usersHtml = role.users.slice(0, 5).map(user => `
            <div class="d-flex align-items-center mb-2">
                <div class="avatar avatar-sm me-2">
                    <span class="avatar-title rounded-circle bg-primary-transparent text-primary">
                        ${user.name.charAt(0).toUpperCase()}
                    </span>
                </div>
                <div>
                    <h6 class="mb-0 fs-14">${user.name}</h6>
                    <p class="mb-0 fs-12 text-muted">${user.email}</p>
                </div>
            </div>
        `).join('');
        
        if (role.users.length > 5) {
            usersHtml += `<p class="text-muted fs-12 mb-0">+${role.users.length - 5} more users</p>`;
        }
    } else {
        usersHtml = '<p class="text-muted mb-0">No users assigned to this role yet.</p>';
    }
    
    // Generate permissions HTML
    let permissionsHtml = '';
    if (Object.keys(permissionsByPage).length > 0) {
        permissionsHtml = Object.entries(permissionsByPage).map(([pageName, perms]) => `
            <div class="card border mb-3">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0 fs-14">
                        <i class="ti ti-file-text me-2 text-primary"></i>${pageName}
                    </h6>
                </div>
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap gap-2">
                        ${perms.map(perm => {
                            const actionName = perm.action?.name || 'Unknown';
                            const scope = perm.scope || 'self';
                            const badgeColor = actionName === 'View' ? 'info' : 
                                              actionName === 'Create' ? 'success' : 
                                              actionName === 'Edit' ? 'warning' : 'danger';
                            const scopeIcon = scope === 'all' ? 'ti-users' : 'ti-user';
                            
                            return `
                                <span class="badge bg-${badgeColor}">
                                    <i class="ti ${getActionIcon(actionName)} me-1"></i>${actionName}
                                    <i class="ti ${scopeIcon} ms-1"></i>
                                </span>
                            `;
                        }).join('')}
                    </div>
                </div>
            </div>
        `).join('');
    } else {
        permissionsHtml = '<p class="text-muted mb-0">No permissions assigned to this role yet.</p>';
    }
    
    content.innerHTML = `
        <div class="row">
            <!-- Role Information -->
            <div class="col-md-6 mb-3">
                <div class="card border">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="ti ti-info-circle me-2"></i>Role Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted fs-12 mb-1">Role Name</label>
                            <h5 class="mb-0">${role.name}</h5>
                        </div>
                        
                        ${role.description ? `
                        <div class="mb-3">
                            <label class="form-label text-muted fs-12 mb-1">Description</label>
                            <p class="mb-0">${role.description}</p>
                        </div>
                        ` : ''}
                        
                        <div class="mb-3">
                            <label class="form-label text-muted fs-12 mb-1">Status</label>
                            <div>
                                ${role.is_default ? '<span class="badge bg-success">Default Role</span>' : '<span class="badge bg-secondary">Custom Role</span>'}
                            </div>
                        </div>
                        
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="mb-1 text-primary">${role.users ? role.users.length : 0}</h4>
                                    <p class="mb-0 fs-12 text-muted">Users Assigned</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-1 text-success">${role.permissions ? role.permissions.length : 0}</h4>
                                <p class="mb-0 fs-12 text-muted">Permissions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Assigned Users -->
            <div class="col-md-6 mb-3">
                <div class="card border">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="ti ti-users me-2"></i>Assigned Users
                        </h6>
                    </div>
                    <div class="card-body">
                        ${usersHtml}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Permissions -->
        <div class="card border mb-0">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="ti ti-lock me-2"></i>Permissions
                </h6>
            </div>
            <div class="card-body">
                ${permissionsHtml}
            </div>
        </div>
        
        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <a href="{{ url('/portal/roles') }}/${role.id}/edit" class="btn btn-primary">
                <i class="ti ti-edit me-1"></i>Edit Role
            </a>
        </div>
    `;
}

function getActionIcon(actionName) {
    const icons = {
        'View': 'ti-eye',
        'Create': 'ti-plus',
        'Edit': 'ti-edit',
        'Delete': 'ti-trash',
        'Approve': 'ti-check',
        'Reject': 'ti-x'
    };
    return icons[actionName] || 'ti-point';
}

function showError(message) {
    const content = document.getElementById('roleDetailsContent');
    content.innerHTML = `
        <div class="alert alert-danger">
            <i class="ti ti-alert-circle me-2"></i>${message}
        </div>
    `;
}

function deleteRole(roleId, roleName) {
    if (!confirm(`Are you sure you want to delete the role "${roleName}"? This action cannot be undone.`)) {
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`{{ url('/portal/roles') }}/${roleId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message || 'Role deleted successfully!');
            // Remove the role card from the DOM
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showToast('error', data.message || 'Failed to delete role');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'An error occurred while deleting the role');
    });
}

// Toast notification system
function showToast(type, message) {
    const toastContainer = getOrCreateToastContainer();
    
    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `toast align-items-center text-bg-${type === 'success' ? 'success' : 'danger'} border-0 show`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="ti ti-${type === 'success' ? 'check-circle' : 'alert-circle'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="removeToast('${toastId}')"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => removeToast(toastId), 5000);
}

function removeToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.classList.add('fade');
        setTimeout(() => toast.remove(), 150);
    }
}

function getOrCreateToastContainer() {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    return container;
}
</script>
@endsection