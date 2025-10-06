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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Role Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="roleDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function viewRoleDetails(roleId) {
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('roleDetailsModal'));
    const content = document.getElementById('roleDetailsContent');
    
    content.innerHTML = '<div class="text-center py-3"><i class="ti ti-loader spinner-border"></i> Loading...</div>';
    modal.show();
    
    // In a real implementation, you'd fetch role details via AJAX
    // For now, we'll just show a placeholder
    setTimeout(() => {
        content.innerHTML = `
            <div class="alert alert-info">
                <i class="ti ti-info-circle me-2"></i>
                Role details functionality can be implemented with an AJAX call to fetch full role permissions and user assignments.
            </div>
        `;
    }, 500);
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

<style>
.role-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.role-card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.avatar.bg-primary-transparent {
    background-color: rgba(107, 70, 193, 0.1) !important;
}

.permission-preview .badge {
    font-size: 10px;
}
</style>
@endsection