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
                    <button type="button" class="btn btn-primary" onclick="createUser()">
                        <i class="ti ti-plus me-2"></i>Add User
                    </button>
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

    <!-- Delete Confirmation Modal -->
    <!-- Include Reusable Confirmation Modal -->
    @include('admin.partials.confirmModal')

    <!-- Include Edit User Modal -->
    @include('admin.users.modals.editUserModal')

    </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables JS -->
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.bootstrap5.min.js') }}"></script>
    
    <!-- Reusable Toast & Modal Scripts -->
    @include('admin.partials.toastAndModal')
    
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
                            // Generate random color based on name

                            return `
                                    <div class="d-flex align-items-center">

                                        <div>
                                            <h6 class="mb-0 fw-medium">${data}</h6>
                                        </div>
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
            const statusTextCap = newStatus ? 'Activate' : 'Deactivate';
            
            showConfirmModal({
                title: `Confirm ${statusTextCap}`,
                message: `Are you sure you want to <strong>${statusText}</strong> this user?`,
                type: newStatus ? 'success' : 'warning',
                icon: newStatus ? 'ti ti-user-check' : 'ti ti-user-off',
                confirmText: `Yes, ${statusTextCap}`,
                confirmIcon: newStatus ? 'ti ti-check' : 'ti ti-x',
                onConfirm: function() {
                    // Show loading state
                    showToast('info', `${statusTextCap}ing user...`);
                    
                    // Perform the status toggle
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
            });
        }
        
        function deleteUser(userId, userName) {
            showConfirmModal({
                title: 'Confirm Delete',
                message: `Are you sure you want to delete <strong>"${userName}"</strong>? This action cannot be undone.`,
                type: 'danger',
                icon: 'ti ti-trash-x',
                confirmText: 'Yes, Delete',
                confirmIcon: 'ti-trash',
                onConfirm: function() {
                    // Show loading state
                    showToast('info', 'Deleting user...');

                    // Perform the delete
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
            });
        }

        function createUser() {
            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            const loadingDiv = document.getElementById('editUserLoading');
            const formContent = document.getElementById('editUserFormContent');
            
            // Update modal title and icon
            document.getElementById('userModalIcon').className = 'ti ti-user-plus me-2';
            document.getElementById('userModalTitleText').textContent = 'Add New User';
            
            // Update submit button
            document.getElementById('submitBtnIcon').className = 'ti ti-plus me-1';
            document.getElementById('submitBtnText').textContent = 'Create User';
            
            // Set form for creation
            document.getElementById('edit_user_id').value = '';
            document.getElementById('form_method').value = 'POST';
            
            // Hide loading, show form
            loadingDiv.style.display = 'none';
            formContent.style.display = 'block';
            
            // Clear all form fields
            document.getElementById('editUserForm').reset();
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            
            // Password section for create mode
            document.getElementById('passwordSectionTitle').textContent = 'Set Password';
            document.getElementById('passwordToggleSection').style.display = 'none';
            document.getElementById('passwordChangeFields').style.display = 'block';
            document.getElementById('edit_password').required = true;
            document.getElementById('edit_password_confirmation').required = true;
            
            // Set default active status
            document.getElementById('edit_is_active').checked = true;
            
            modal.show();
        }

        function editUser(userId) {
            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            const loadingDiv = document.getElementById('editUserLoading');
            const formContent = document.getElementById('editUserFormContent');
            
            // Update modal title and icon
            document.getElementById('userModalIcon').className = 'ti ti-user-edit me-2';
            document.getElementById('userModalTitleText').textContent = 'Edit User';
            
            // Update submit button
            document.getElementById('submitBtnIcon').className = 'ti ti-device-floppy me-1';
            document.getElementById('submitBtnText').textContent = 'Update User';
            
            // Set form for editing
            document.getElementById('form_method').value = 'PUT';
            
            // Show loading, hide form
            loadingDiv.style.display = 'block';
            formContent.style.display = 'none';
            
            // Clear previous errors
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            
            // Password section for edit mode
            document.getElementById('passwordSectionTitle').textContent = 'Change Password';
            document.getElementById('passwordToggleSection').style.display = 'block';
            document.getElementById('change_password_toggle').checked = false;
            document.getElementById('passwordChangeFields').style.display = 'none';
            document.getElementById('edit_password').value = '';
            document.getElementById('edit_password_confirmation').value = '';
            document.getElementById('edit_password').required = false;
            document.getElementById('edit_password_confirmation').required = false;
            
            modal.show();
            
            // Fetch user data
            fetch(`{{ url('/portal/users') }}/${userId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const user = data.user;
                    
                    // Populate form fields
                    document.getElementById('edit_user_id').value = user.id;
                    document.getElementById('edit_name').value = user.name || '';
                    document.getElementById('edit_email').value = user.email || '';
                    document.getElementById('edit_phone').value = user.phone || '';
                    document.getElementById('edit_role_id').value = user.role_id || '';
                    document.getElementById('edit_aadhaar').value = user.aadhaar || '';
                    document.getElementById('edit_pancard').value = user.pancard || '';
                    document.getElementById('edit_is_active').checked = user.is_active;
                    
                    // Populate user details if exists
                    if (user.user_detail) {
                        document.getElementById('edit_company_name').value = user.user_detail.company_name || '';
                        document.getElementById('edit_district').value = user.user_detail.district || '';
                        document.getElementById('edit_state').value = user.user_detail.state || '';
                        document.getElementById('edit_pincode').value = user.user_detail.pincode || '';
                    } else {
                        document.getElementById('edit_company_name').value = '';
                        document.getElementById('edit_district').value = '';
                        document.getElementById('edit_state').value = '';
                        document.getElementById('edit_pincode').value = '';
                    }
                    
                    // Show form, hide loading
                    loadingDiv.style.display = 'none';
                    formContent.style.display = 'block';
                } else {
                    modal.hide();
                    showToast('error', 'Failed to load user details');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                modal.hide();
                showToast('error', 'An error occurred while loading user details');
            });
        }

        // Password change toggle
        document.getElementById('change_password_toggle').addEventListener('change', function() {
            const passwordFields = document.getElementById('passwordChangeFields');
            const passwordInput = document.getElementById('edit_password');
            const confirmInput = document.getElementById('edit_password_confirmation');
            
            if (this.checked) {
                passwordFields.style.display = 'block';
                passwordInput.required = true;
                confirmInput.required = true;
            } else {
                passwordFields.style.display = 'none';
                passwordInput.required = false;
                confirmInput.required = false;
                passwordInput.value = '';
                confirmInput.value = '';
            }
        });

        // Toggle password visibility
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '_icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ti-eye');
                icon.classList.add('ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.remove('ti-eye-off');
                icon.classList.add('ti-eye');
            }
        }

        // Handle form submission
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const userId = document.getElementById('edit_user_id').value;
            const formMethod = document.getElementById('form_method').value;
            const isCreating = !userId || formMethod === 'POST';
            const formData = new FormData(this);
            const updateBtn = document.getElementById('updateUserBtn');
            
            // Clear previous errors
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            
            // Validate password confirmation
            const changePassword = document.getElementById('change_password_toggle').checked;
            const passwordRequired = isCreating || changePassword;
            
            if (passwordRequired) {
                const password = document.getElementById('edit_password').value;
                const confirmation = document.getElementById('edit_password_confirmation').value;
                
                if (!password) {
                    document.getElementById('edit_password').classList.add('is-invalid');
                    document.getElementById('error_edit_password').textContent = 'Password is required';
                    return;
                }
                
                if (password !== confirmation) {
                    document.getElementById('edit_password_confirmation').classList.add('is-invalid');
                    document.getElementById('error_edit_password_confirmation').textContent = 'Password confirmation does not match';
                    return;
                }
            }
            
            // Disable submit button
            updateBtn.disabled = true;
            updateBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span>${isCreating ? 'Creating...' : 'Updating...'}`;
            
            // Convert FormData to JSON
            const data = {};
            formData.forEach((value, key) => {
                if (key !== '_method' && key !== 'user_id') {
                    data[key] = value;
                }
            });
            
            // Handle checkbox for is_active
            data.is_active = document.getElementById('edit_is_active').checked ? 1 : 0;
            
            // Remove password fields if not changing password (edit mode only)
            if (!isCreating && !changePassword) {
                delete data.password;
                delete data.password_confirmation;
            }
            
            // Determine URL and method
            const url = isCreating 
                ? '{{ url("/portal/users") }}' 
                : `{{ url('/portal/users') }}/${userId}`;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide modal
                    bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
                    
                    // Show success message
                    showToast('success', data.message || (isCreating ? 'User created successfully' : 'User updated successfully'));
                    
                    // Refresh table
                    usersTable.ajax.reload();
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const input = document.getElementById('edit_' + field);
                            const error = document.getElementById('error_edit_' + field);
                            
                            if (input && error) {
                                input.classList.add('is-invalid');
                                error.textContent = data.errors[field][0];
                            }
                        });
                    }
                    
                    showToast('error', data.message || (isCreating ? 'Failed to create user' : 'Failed to update user'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', `An error occurred while ${isCreating ? 'creating' : 'updating'} user`);
            })
            .finally(() => {
                // Re-enable submit button
                updateBtn.disabled = false;
                const btnIcon = isCreating ? 'ti-plus' : 'ti-device-floppy';
                const btnText = isCreating ? 'Create User' : 'Update User';
                updateBtn.innerHTML = `<i class="ti ${btnIcon} me-1"></i>${btnText}`;
            });
        });
    </script>
@endpush