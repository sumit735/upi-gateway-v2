@extends('admin.layouts.app')

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">User Management</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ti ti-smart-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                    <button type="button" class="btn btn-light me-2" onclick="refreshTable()">
                        <i class="ti ti-refresh me-2"></i>Refresh
                    </button>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>Add User
                    </a>
                </div>
            </div>
            <!-- /Breadcrumb -->

            <!-- Filters -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            {{-- <label class="form-label">Filter by Role</label> --}}
                            <select class="form-select" id="roleFilter">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            {{-- <label class="form-label">Filter by Status</label> --}}
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="applyFilters()">
                                <i class="ti ti-filter me-2"></i>Apply Filters
                            </button>
                            <button type="button" class="btn btn-light" onclick="clearFilters()">
                                <i class="ti ti-x me-2"></i>Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Filters -->

            <!-- Users Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-users me-2"></i>Users List
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="usersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Users Table -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- User Details Modal -->
    <div class="modal fade" id="userDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-user me-2"></i>User Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="userDetailsContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Loading user details...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables JS -->
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        // initialize select2
        $('#roleFilter, #statusFilter').select2();
        let usersTable;

        document.addEventListener('DOMContentLoaded', function () {
            initializeDataTable();
        });

        function initializeDataTable() {
            usersTable = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.users.list") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (d) {
                        d.role_filter = $('#roleFilter').val();
                        d.status_filter = $('#statusFilter').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id', width: '50px' },
                    {
                        data: 'name',
                        name: 'name',
                        render: function (data, type, row) {
                            return `
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-2">
                                    <span class="avatar-title rounded-circle bg-primary-transparent text-primary">
                                        ${data.charAt(0).toUpperCase()}
                                    </span>
                                </div>
                                <span class="fw-medium">${data}</span>
                            </div>
                        `;
                        }
                    },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    {
                        data: 'role_badge',
                        name: 'role_id',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'status_badge',
                        name: 'is_active',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function (data, type, row) {
                            return `<span title="${row.created_at_full}">${data}</span>`;
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-end'
                    }
                ],
                order: [[0, 'desc']],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                language: {
                    lengthMenu: 'Row Per Page _MENU_ Entries',
                    search: '',
                    searchPlaceholder: 'Search',
                    paginate: {
                        previous: '<i class="ti ti-chevron-left"></i>',
                        next: '<i class="ti ti-chevron-right"></i>'
                    },
                    info: 'Showing _START_ - _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 - 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                drawCallback: function () {
                    // Add Bootstrap classes to pagination
                    $('.dataTables_paginate .pagination').addClass('pagination-sm');
                }
            });
        }

        function refreshTable() {
            usersTable.ajax.reload();
        }

        function applyFilters() {
            usersTable.ajax.reload();
        }

        function clearFilters() {
            $('#roleFilter').val('');
            $('#statusFilter').val('');
            usersTable.ajax.reload();
        }

        function viewUser(userId) {
            const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
            const content = document.getElementById('userDetailsContent');

            content.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Loading user details...</p>
            </div>
        `;

            modal.show();

            fetch(`{{ url('/portal/users') }}/${userId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayUserDetails(data.user);
                    } else {
                        showError('Failed to load user details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('An error occurred while loading user details');
                });
        }

        function displayUserDetails(user) {
            const content = document.getElementById('userDetailsContent');

            content.innerHTML = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="ti ti-user me-2"></i>Personal Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted fs-12 mb-1">Full Name</label>
                                <h6 class="mb-0">${user.name}</h6>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fs-12 mb-1">Email Address</label>
                                <p class="mb-0">${user.email}</p>
                            </div>
                            ${user.phone ? `
                            <div class="mb-3">
                                <label class="form-label text-muted fs-12 mb-1">Phone Number</label>
                                <p class="mb-0">${user.phone}</p>
                            </div>
                            ` : ''}
                            <div class="mb-0">
                                <label class="form-label text-muted fs-12 mb-1">Account Status</label>
                                <div>
                                    ${user.is_active
                    ? '<span class="badge bg-success"><i class="ti ti-check me-1"></i>Active</span>'
                    : '<span class="badge bg-danger"><i class="ti ti-x me-1"></i>Inactive</span>'}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="ti ti-shield me-2"></i>Role & Permissions</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted fs-12 mb-1">Role</label>
                                <div>
                                    <span class="badge bg-primary">${user.role ? user.role.name : 'No Role'}</span>
                                </div>
                            </div>
                            ${user.role && user.role.description ? `
                            <div class="mb-0">
                                <label class="form-label text-muted fs-12 mb-1">Role Description</label>
                                <p class="mb-0">${user.role.description}</p>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <a href="{{ url('/portal/users') }}/${user.id}/edit" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>Edit User
                </a>
            </div>
        `;
        }

        function showError(message) {
            const content = document.getElementById('userDetailsContent');
            content.innerHTML = `
            <div class="alert alert-danger">
                <i class="ti ti-alert-circle me-2"></i>${message}
            </div>
        `;
        }

        function toggleUserStatus(userId, newStatus) {
            const statusText = newStatus ? 'activate' : 'deactivate';

            if (!confirm(`Are you sure you want to ${statusText} this user?`)) {
                return;
            }

            fetch(`{{ url('/portal/users') }}/${userId}/toggle-status`, {
                method: 'POST',
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
                        showToast('success', data.message);
                        refreshTable();
                    } else {
                        showToast('error', data.message || 'Failed to update user status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'An error occurred while updating user status');
                });
        }

        function deleteUser(userId, userName) {
            if (!confirm(`Are you sure you want to delete "${userName}"? This action cannot be undone.`)) {
                return;
            }

            fetch(`{{ url('/portal/users') }}/${userId}`, {
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
                        showToast('success', data.message);
                        refreshTable();
                    } else {
                        showToast('error', data.message || 'Failed to delete user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'An error occurred while deleting the user');
                });
        }

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
@endpush