@extends('admin.layouts.app')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            @component('admin.partials.breadcrumb', [
                'title' => 'Roles & Permissions',
                'breadcrumbs' => [
                    ['title' => 'Roles']
                ]
            ])
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>Create Role
                    </a>
                </div>
            @endcomponent
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

            <!-- Roles Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-shield me-2"></i>Roles List
                    </h5>
                    {{-- <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" id="searchRoles" placeholder="Search roles...">
                    </div> --}}
                </div>
                <div class="card-body">
                    @if($roles->isEmpty())
                        <div class="text-center py-5">
                            <div class="avatar avatar-xl rounded bg-light mb-3 mx-auto">
                                <i class="ti ti-shield fs-24 text-muted"></i>
                            </div>
                            <h5 class="mb-2">No Roles Found</h5>
                            <p class="text-muted mb-3">Get started by creating your first role with custom permissions.</p>
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-2"></i>Create First Role
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover" id="rolesTable">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Role Name</th>
                                        <th>Description</th>
                                        <th width="100" class="text-center">Users</th>
                                        <th width="120" class="text-center">Permissions</th>
                                        <th width="100" class="text-center">Status</th>
                                        <th width="150" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr class="role-row">
                                            <td>{{ $role->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm rounded bg-primary-transparent me-2">
                                                        <i class="ti ti-shield fs-14 text-primary"></i>
                                                    </div>
                                                    <span class="fw-semibold role-name">{{ $role->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted role-description">
                                                    {{ $role->description ? Str::limit($role->description, 60) : 'No description' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary-transparent text-primary">
                                                    {{ $role->users_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success-transparent text-success">
                                                    {{ $role->permissions->count() }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($role->is_default)
                                                    <span class="badge bg-success"><i class="ti ti-star me-1"></i>Default</span>
                                                @else
                                                    <span class="badge bg-secondary">Custom</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-sm btn-icon btn-light"
                                                        onclick="viewRoleDetails({{ $role->id }})" title="View Details">
                                                        <i class="ti ti-eye"></i>
                                                    </button>
                                                    <a href="{{ route('admin.roles.edit', $role) }}"
                                                        class="btn btn-sm btn-icon btn-primary" title="Edit Role">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    @if(!$role->is_default && $role->users_count == 0)
                                                        <button type="button" class="btn btn-sm btn-icon btn-danger"
                                                            onclick="deleteRole({{ $role->id }}, '{{ addslashes($role->name) }}')"
                                                            title="Delete Role">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /Roles Table -->

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

<!-- Include Reusable Confirmation Modal -->
@include('admin.partials.confirmModal')

<!-- Reusable Toast & Modal Scripts -->
@include('admin.partials.toastAndModal')
@endsection

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.bootstrap5.min.css') }}">
@endpush
@push('scripts')
    
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.bootstrap5.min.js') }}"></script>

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
            showConfirmModal({
                title: 'Confirm Delete',
                message: `Are you sure you want to delete the role <strong>"${roleName}"</strong>? This action cannot be undone.`,
                type: 'danger',
                icon: 'ti ti-trash-x',
                confirmText: 'Yes, Delete',
                confirmIcon: 'ti-trash',
                onConfirm: function () {
                    // Show loading toast
                    showToast('info', 'Deleting role...');

                    
                    fetch(`{{ url('/portal/roles') }}/${roleId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('success', data.message || 'Role deleted successfully!');
                                // Reload page after delay
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
            });
        }

        // Simple search functionality
        document.addEventListener('DOMContentLoaded', function () {
            // const searchInput = document.getElementById('searchRoles');
            // if (searchInput) {
            //     searchInput.addEventListener('keyup', function() {
            //         const searchValue = this.value.toLowerCase();
            //         const rows = document.querySelectorAll('#rolesTable tbody .role-row');

            //         rows.forEach(row => {
            //             const roleName = row.querySelector('.role-name')?.textContent.toLowerCase() || '';
            //             const roleDescription = row.querySelector('.role-description')?.textContent.toLowerCase() || '';

            //             if (roleName.includes(searchValue) || roleDescription.includes(searchValue)) {
            //                 row.style.display = '';
            //             } else {
            //                 row.style.display = 'none';
            //             }
            //         });
            //     });
            // }
            // load datatable
            $('.table').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true
            })
        });
    </script>
@endpush