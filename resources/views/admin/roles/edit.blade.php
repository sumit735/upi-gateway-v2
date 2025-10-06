@extends('admin.layouts.app')

@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Edit Role</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.roles.index') }}">Roles</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-primary me-2">
                    <i class="ti ti-arrow-left me-2"></i>Back to Roles
                </a>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ti ti-edit me-2"></i>Edit Role: {{ $role->name }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="roleEditForm">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ $role->name }}" required>
                                        <div class="invalid-feedback" id="name-error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_default" 
                                                   name="is_default" value="1" {{ $role->is_default ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_default">
                                                Default Role
                                                <small class="text-muted d-block">Automatically assigned to new users</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" 
                                          rows="3" placeholder="Enter role description...">{{ $role->description }}</textarea>
                                <div class="invalid-feedback" id="description-error"></div>
                            </div>

                            <!-- Permissions Section -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Permissions</h6>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-success me-2" onclick="selectAllPermissions()">
                                            <i class="ti ti-check-all"></i> Select All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAllPermissions()">
                                            <i class="ti ti-x"></i> Clear All
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach($pageEnums as $page)
                                    <div class="col-lg-6 col-xl-4 mb-3">
                                        <div class="card border permission-card">
                                            <div class="card-header bg-light py-2">
                                                <h6 class="card-title mb-0 text-capitalize">
                                                    <i class="ti ti-folder me-2"></i>{{ str_replace('_', ' ', $page->value) }}
                                                </h6>
                                            </div>
                                            <div class="card-body p-3">
                                                @foreach($actionEnums as $action)
                                                @foreach($scopeEnums as $scope)
                                                @php
                                                    $permissionKey = $page->value . ',' . $action->value . ',' . $scope->value;
                                                    $isChecked = $role->permissions()
                                                        ->whereHas('page', fn($q) => $q->where('route_pattern', $page->value))
                                                        ->whereHas('action', fn($q) => $q->where('slug', $action->value))
                                                        ->where('scope', $scope->value)
                                                        ->exists();
                                                @endphp
                                                <div class="form-check form-switch mb-2">
                                                    <input class="form-check-input permission-input" 
                                                           type="checkbox" 
                                                           id="permission_{{ $permissionKey }}"
                                                           name="permissions[]" 
                                                           value="{{ $permissionKey }}"
                                                           {{ $isChecked ? 'checked' : '' }}>
                                                    <label class="form-check-label text-sm" for="permission_{{ $permissionKey }}">
                                                        {{ ucfirst($action->value) }} 
                                                        <span class="badge badge-sm bg-secondary ms-1">{{ $scope->value }}</span>
                                                    </label>
                                                </div>
                                                @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-x me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" id="submitSpinner"></span>
                                    <span id="submitText">
                                        <i class="ti ti-check me-2"></i>Update Role
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /Page Wrapper -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('roleEditForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitSpinner = document.getElementById('submitSpinner');
    const submitText = document.getElementById('submitText');

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        submitBtn.disabled = true;
        submitSpinner.classList.remove('d-none');
        submitText.innerHTML = '<i class="ti ti-loader me-2"></i>Updating...';
        
        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        const formData = new FormData(form);
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ route("admin.roles.update", $role) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message || 'Role updated successfully!');
                setTimeout(() => {
                    window.location.href = '{{ route("admin.roles.index") }}';
                }, 1500);
            } else {
                showToast('error', data.message || 'Failed to update role');
                
                // Show validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = document.getElementById(field);
                        const errorDiv = document.getElementById(field + '-error');
                        if (input && errorDiv) {
                            input.classList.add('is-invalid');
                            errorDiv.textContent = data.errors[field][0];
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'An error occurred while updating the role');
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitSpinner.classList.add('d-none');
            submitText.innerHTML = '<i class="ti ti-check me-2"></i>Update Role';
        });
    });

    // Permission management functions
    window.selectAllPermissions = function() {
        document.querySelectorAll('.permission-input').forEach(checkbox => {
            checkbox.checked = true;
        });
    };

    window.clearAllPermissions = function() {
        document.querySelectorAll('.permission-input').forEach(checkbox => {
            checkbox.checked = false;
        });
    };
    
    // Toast notification system
    window.showToast = function(type, message) {
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
    };
    
    window.removeToast = function(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.add('fade');
            setTimeout(() => toast.remove(), 150);
        }
    };
    
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
});
</script>

<style>
.permission-card {
    transition: all 0.2s ease;
}

.permission-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.form-check-input:checked {
    background-color: #6b46c1;
    border-color: #6b46c1;
}

.badge.bg-secondary {
    font-size: 9px;
    padding: 2px 6px;
}

.form-check-label.text-sm {
    font-size: 0.85rem;
}
</style>
@endsection