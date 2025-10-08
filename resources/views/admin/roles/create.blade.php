@extends('admin.layouts.app')

@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create New Role</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.roles.index') }}">Roles</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Role</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-light me-2">
                    <i class="ti ti-arrow-left me-2"></i>Back to Roles
                </a>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <form id="roleForm">
            @csrf
            
            <div class="row">
                <!-- Role Information -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="ti ti-shield me-2"></i>Role Information
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Enter role name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" 
                                          placeholder="Brief description of this role">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1">
                                <label class="form-check-label" for="is_default">
                                    Default role for new users
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-info btn-sm" onclick="selectAllPermissions()">
                                    <i class="ti ti-check-all me-1"></i>Select All
                                </button>
                                <button type="button" class="btn btn-warning btn-sm" onclick="selectViewOnly()">
                                    <i class="ti ti-eye me-1"></i>View Only
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="clearAllPermissions()">
                                    <i class="ti ti-x me-1"></i>Clear All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">
                                <i class="ti ti-lock me-2"></i>Permissions
                            </h4>
                            <span class="badge bg-primary" id="selectedCount">0 selected</span>
                        </div>
                        <div class="card-body">
                            
                            @foreach($pageEnums as $pageEnum)
                            <div class="permission-group mb-4">
                                <div class="card border">
                                    <div class="card-header bg-light py-2">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check me-3">
                                                    <input class="form-check-input page-toggle" 
                                                           type="checkbox" 
                                                           id="page-{{ $pageEnum->value }}"
                                                           data-page="{{ $pageEnum->value }}">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        @switch($pageEnum->value)
                                                            @case('dashboard')
                                                                <i class="ti ti-dashboard me-2 text-primary"></i>
                                                                @break
                                                            @case('admin.users.*')
                                                                <i class="ti ti-users me-2 text-success"></i>
                                                                @break
                                                            @case('profile.*')
                                                                <i class="ti ti-user me-2 text-info"></i>
                                                                @break
                                                        @endswitch
                                                        {{ $pageEnum->label() }}
                                                    </h6>
                                                    <small class="text-muted">{{ $pageEnum->description() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6 class="text-muted mb-2 fs-12">Actions</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($actionEnums as $actionEnum)
                                                    <label class="permission-checkbox">
                                                        <input type="checkbox" 
                                                               name="permissions[]" 
                                                               value="{{ $pageEnum->value }},{{ $actionEnum->value }},self"
                                                               class="permission-input me-2"
                                                               data-page="{{ $pageEnum->value }}"
                                                               data-action="{{ $actionEnum->value }}">
                                                        <span class="badge badge-outline-{{ $actionEnum->value === 'view' ? 'info' : ($actionEnum->value === 'create' ? 'success' : ($actionEnum->value === 'edit' ? 'warning' : 'danger')) }}">
                                                            @switch($actionEnum->value)
                                                                @case('view')
                                                                    <i class="ti ti-eye me-1"></i>
                                                                    @break
                                                                @case('create')
                                                                    <i class="ti ti-plus me-1"></i>
                                                                    @break
                                                                @case('edit')
                                                                    <i class="ti ti-edit me-1"></i>
                                                                    @break
                                                                @case('delete')
                                                                    <i class="ti ti-trash me-1"></i>
                                                                    @break
                                                            @endswitch
                                                            {{ $actionEnum->label() }}
                                                        </span>
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h6 class="text-muted mb-2 fs-12">Scope</h6>
                                                <div class="d-flex gap-2">
                                                    <div class="form-check form-check-md flex-fill">
                                                        <input class="form-check-input scope-radio" 
                                                               type="radio" 
                                                               name="scope-{{ $pageEnum->value }}" 
                                                               id="scope-self-{{ $pageEnum->value }}" 
                                                               value="self" 
                                                               data-page="{{ $pageEnum->value }}" 
                                                               checked>
                                                        <label class="form-check-label" for="scope-self-{{ $pageEnum->value }}">
                                                            <i class="ti ti-user me-1"></i>Self
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-md flex-fill">
                                                        <input class="form-check-input scope-radio" 
                                                               type="radio" 
                                                               name="scope-{{ $pageEnum->value }}" 
                                                               id="scope-all-{{ $pageEnum->value }}" 
                                                               value="all" 
                                                               data-page="{{ $pageEnum->value }}">
                                                        <label class="form-check-label" for="scope-all-{{ $pageEnum->value }}">
                                                            <i class="ti ti-users me-1"></i>All
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-light" onclick="window.history.back()">
                                    <i class="ti ti-arrow-left me-1"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <span class="btn-text">
                                        <i class="ti ti-device-floppy me-1"></i>Create Role
                                    </span>
                                    <span class="btn-loader d-none">
                                        <span class="spinner-border spinner-border-sm me-2"></span>Creating...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<!-- /Page Wrapper -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // AJAX Form Submission
    document.getElementById('roleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoader = submitBtn.querySelector('.btn-loader');
        
        // Show loading state
        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnLoader.classList.remove('d-none');
        
        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        
        // Prepare form data
        const formData = new FormData(this);
        
        // Add permissions array
        const permissions = [];
        document.querySelectorAll('.permission-input:checked').forEach(checkbox => {
            permissions.push(checkbox.value);
        });
        
        // Clear existing permission entries and add new ones
        formData.delete('permissions[]');
        permissions.forEach(permission => {
            formData.append('permissions[]', permission);
        });
        
        fetch('{{ route("admin.roles.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success toast
                showToast('success', data.message || 'Role created successfully!');
                
                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = '{{ route("admin.roles.index") }}';
                }, 1000);
            } else {
                throw new Error(data.message || 'Something went wrong');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Handle validation errors
            if (error.response) {
                error.response.json().then(errorData => {
                    if (errorData.errors) {
                        Object.keys(errorData.errors).forEach(field => {
                            const input = document.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                                const feedback = document.createElement('div');
                                feedback.className = 'invalid-feedback';
                                feedback.textContent = errorData.errors[field][0];
                                input.parentNode.appendChild(feedback);
                            }
                        });
                    }
                    showToast('error', errorData.message || 'Validation failed');
                });
            } else {
                showToast('error', error.message || 'An error occurred while creating the role');
            }
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnLoader.classList.add('d-none');
        });
    });

    // Update permission values when scope changes
    document.querySelectorAll('.scope-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const page = this.dataset.page;
            const scope = this.value;
            
            document.querySelectorAll(`input[data-page="${page}"].permission-input`).forEach(checkbox => {
                if (checkbox.checked) {
                    const action = checkbox.dataset.action;
                    checkbox.value = `${page},${action},${scope}`;
                }
            });
            updateSelectedCount();
        });
    });

    // Update permission values and scope when checkbox changes
    document.querySelectorAll('.permission-input').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const page = this.dataset.page;
            const action = this.dataset.action;
            const scopeRadio = document.querySelector(`input[name="scope-${page}"]:checked`);
            const scope = scopeRadio ? scopeRadio.value : 'self';
            
            this.value = `${page},${action},${scope}`;
            
            // Update page toggle
            updatePageToggle(page);
            updateSelectedCount();
        });
    });

    // Page toggle functionality
    document.querySelectorAll('.page-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const page = this.dataset.page;
            const checkboxes = document.querySelectorAll(`input[data-page="${page}"].permission-input`);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                checkbox.dispatchEvent(new Event('change'));
            });
        });
    });

    function updatePageToggle(page) {
        const checkboxes = document.querySelectorAll(`input[data-page="${page}"].permission-input`);
        const checkedBoxes = document.querySelectorAll(`input[data-page="${page}"].permission-input:checked`);
        const pageToggle = document.querySelector(`#page-${page}`);
        
        if (pageToggle) {
            pageToggle.checked = checkedBoxes.length > 0;
            pageToggle.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < checkboxes.length;
        }
    }

    function updateSelectedCount() {
        const selectedCount = document.querySelectorAll('.permission-input:checked').length;
        document.getElementById('selectedCount').textContent = `${selectedCount} selected`;
    }

    // Global functions
    window.selectAllPermissions = function() {
        document.querySelectorAll('.permission-input').forEach(checkbox => {
            checkbox.checked = true;
            checkbox.dispatchEvent(new Event('change'));
        });
    };

    window.selectViewOnly = function() {
        document.querySelectorAll('.permission-input').forEach(checkbox => {
            checkbox.checked = checkbox.dataset.action === 'view';
            checkbox.dispatchEvent(new Event('change'));
        });
    };

    window.clearAllPermissions = function() {
        document.querySelectorAll('.permission-input').forEach(checkbox => {
            checkbox.checked = false;
            checkbox.dispatchEvent(new Event('change'));
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
.permission-checkbox {
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    margin: 2px;
}

.permission-checkbox input[type="checkbox"] {
    margin: 0;
}

.permission-checkbox:hover .badge {
    opacity: 0.8;
}

.badge-outline-info {
    color: #0dcaf0;
    border: 1px solid #0dcaf0;
    background: transparent;
}

.badge-outline-success {
    color: #198754;
    border: 1px solid #198754;
    background: transparent;
}

.badge-outline-warning {
    color: #ffc107;
    border: 1px solid #ffc107;
    background: transparent;
}

.badge-outline-danger {
    color: #dc3545;
    border: 1px solid #dc3545;
    background: transparent;
}
</style>
@endsection