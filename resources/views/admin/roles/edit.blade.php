@extends('admin.layouts.app')

@section('content')
@push('styles')
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
    
@endpush
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
                                        <label for="name" class="form-label">Role Name <span
                                                class="text-danger">*</span></label>
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
                                                <small class="text-muted d-block">Automatically assigned to new
                                                    users</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    placeholder="Enter role description...">{{ $role->description }}</textarea>
                                <div class="invalid-feedback" id="description-error"></div>
                            </div>

                            <!-- Permissions Section -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Permissions</h6>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-success me-2"
                                            onclick="selectAllPermissions()">
                                            <i class="ti ti-check-all"></i> Select All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="clearAllPermissions()">
                                            <i class="ti ti-x"></i> Clear All
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach($pages as $page)
                                    @php
                                        // Check if any action for this page has 'all' scope
                                        $hasAllScope = $role->permissions()
                                            ->whereHas('page', fn($q) => $q->where('route_pattern', $page->route_pattern))
                                            ->where('scope', 'all')
                                            ->exists();
                                    @endphp
                                    <div class="col-lg-6 col-xl-4 mb-3">
                                        <div class="card border permission-card">
                                            <div class="card-header bg-light py-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <h6 class="card-title mb-0">
                                                            <i class="ti ti-folder me-2"></i>{{ $page->name }}
                                                        </h6>
                                                        <small class="text-muted">{{ $page->description }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-3">
                                                @if($page->actions->count() > 0)
                                                <div class="mb-3">
                                                    <h6 class="fs-12 text-muted mb-2 text-uppercase">Actions</h6>
                                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                                        @foreach($page->actions as $action)
                                                        @php
                                                            // Check if any scope is selected for this action
                                                            $selfChecked = $role->permissions()
                                                                ->whereHas('page', fn($q) => $q->where('route_pattern', $page->route_pattern))
                                                                ->whereHas('action', fn($q) => $q->where('slug', $action->slug))
                                                                ->where('scope', 'self')
                                                                ->exists();
                                                            $allChecked = $role->permissions()
                                                                ->whereHas('page', fn($q) => $q->where('route_pattern', $page->route_pattern))
                                                                ->whereHas('action', fn($q) => $q->where('slug', $action->slug))
                                                                ->where('scope', 'all')
                                                                ->exists();
                                                            $isChecked = $selfChecked || $allChecked;
                                                            $currentScope = $allChecked ? 'all' : 'self';
                                                        @endphp
                                                        <label class="permission-checkbox">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $page->route_pattern }},{{ $action->slug }},{{ $currentScope }}"
                                                                class="permission-input me-2"
                                                                data-page="{{ $page->route_pattern }}"
                                                                data-action="{{ $action->slug }}" {{ $isChecked
                                                                ? 'checked' : '' }}>
                                                            <span
                                                                class="badge badge-outline-{{ $action->slug === 'view' ? 'info' : ($action->slug === 'create' ? 'success' : ($action->slug === 'edit' ? 'warning' : 'danger')) }}">
                                                                @switch($action->slug)
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
                                                                @case('export')
                                                                <i class="ti ti-download me-1"></i>
                                                                @break
                                                                @default
                                                                <i class="ti ti-check me-1"></i>
                                                                @endswitch
                                                                {{ $action->name }}
                                                            </span>
                                                        </label>
                                                        @endforeach
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <div class="form-check form-check-sm flex-fill">
                                                            <input class="form-check-input scope-radio" type="radio"
                                                                name="scope-{{ $page->id }}" id="scope-self-{{ $page->id }}"
                                                                value="self" data-page="{{ $page->route_pattern }}" {{
                                                                !$hasAllScope ? 'checked' : '' }}>
                                                            <label class="form-check-label small"
                                                                for="scope-self-{{ $page->id }}">
                                                                <i class="ti ti-user me-1"></i>Self
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-sm flex-fill">
                                                            <input class="form-check-input scope-radio" type="radio"
                                                                name="scope-{{ $page->id }}" id="scope-all-{{ $page->id }}"
                                                                value="all" data-page="{{ $page->route_pattern }}" {{
                                                                $hasAllScope ? 'checked' : '' }}>
                                                            <label class="form-check-label small"
                                                                for="scope-all-{{ $page->id }}">
                                                                <i class="ti ti-users me-1"></i>All
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
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
                                    <span class="spinner-border spinner-border-sm me-2 d-none"
                                        id="submitSpinner"></span>
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
@push('scripts')
    @include('admin.partials.toastAndModal')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('roleEditForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitSpinner = document.getElementById('submitSpinner');
        const submitText = document.getElementById('submitText');

        // Update permission values when scope changes
        document.querySelectorAll('.scope-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const page = this.dataset.page;
                const scope = this.value;
                
                // Update ALL checkboxes for this page
                document.querySelectorAll(`input[data-page="${page}"].permission-input`).forEach(checkbox => {
                    const action = checkbox.dataset.action;
                    checkbox.value = `${page},${action},${scope}`;
                });
            });
        });

        // Update permission values when checkbox changes
        document.querySelectorAll('.permission-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const page = this.dataset.page;
                const action = this.dataset.action;
                // Find the scope radio for this page by finding the container and looking for checked radio
                const pageCard = this.closest('.card');
                const scopeRadio = pageCard.querySelector('.scope-radio:checked');
                const scope = scopeRadio ? scopeRadio.value : 'self';
                
                this.value = `${page},${action},${scope}`;
            });
        });

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
            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch('{{ route("admin.roles.update", $role) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
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
    });
    </script>
@endpush


@endsection