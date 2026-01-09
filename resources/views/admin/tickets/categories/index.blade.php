@extends('admin.layouts.app')

@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        @component('admin.partials.breadcrumb', [
            'title' => 'Ticket Categories',
            'breadcrumbs' => [
                ['title' => 'Categories']
            ]
        ])
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="ti ti-plus me-2"></i>Add Category
                </button>
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
                <button type="button"="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Categories Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="ti ti-folder me-2"></i>Categories List
                </h5>
            </div>
            <div class="card-body">
                @if($categories->isEmpty())
                    <div class="text-center py-5">
                        <div class="avatar avatar-xl rounded bg-light mb-3 mx-auto">
                            <i class="ti ti-folder-open fs-24 text-muted"></i>
                        </div>
                        <h5 class="mb-2">No Categories Found</h5>
                        <p class="text-muted mb-3">Get started by creating your first ticket category.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="ti ti-plus me-2"></i>Create First Category
                        </button>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th width="50">#</th>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th width="80">Color</th>
                                    <th width="100" class="text-center">Tickets</th>
                                    <th width="100" class="text-center">Status</th>
                                    <th width="150" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm rounded me-2" style="background: {{ $category->color }};">
                                                    <i class="ti ti-folder fs-14 text-white"></i>
                                                </div>
                                                <span class="fw-semibold">{{ $category->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $category->description ? Str::limit($category->description, 50) : 'No description' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge" style="background: {{ $category->color }}; width: 30px; height: 20px;"></span>
                                                <small class="text-muted">{{ $category->color }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary-transparent text-primary">
                                                {{ $category->tickets_count }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($category->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="button" class="btn btn-sm btn-icon btn-primary"
                                                    data-category-id="{{ $category->id }}"
                                                    data-category='@json($category)'
                                                    onclick="openEditModal(this)" title="Edit Category">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                @if($category->tickets_count == 0)
                                                    <button type="button" class="btn btn-sm btn-icon btn-danger"
                                                        data-category-id="{{ $category->id }}"
                                                        data-category-name="{{ $category->name }}"
                                                        onclick="deleteCategory(this)" title="Delete Category">
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
        <!-- /Categories Table -->

    </div>
</div>
<!-- /Page Wrapper -->

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCategoryForm" action="{{ route('admin.tickets.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Technical Support" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color *</label>
                        <div id="add_color_options" class="d-flex gap-2 flex-wrap"></div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="add_is_active" checked>
                        <label class="form-check-label" for="add_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create Category</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color *</label>
                        <div id="edit_color_options" class="d-flex gap-2 flex-wrap"></div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                        <label class="form-check-label" for="edit_is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Category</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
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
        const colorPalette = ['#667eea','#f5222d','#52c41a','#1890ff','#faad14','#722ed1'];

    // Utility to get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) return meta.getAttribute('content');
        const input = document.querySelector('input[name="_token"]');
        return input ? input.value : '';
    }

    // Build clickable color options into a container element
    function buildColorOptions(containerId, selectedColor) {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.innerHTML = '';
        colorPalette.forEach((col, idx) => {
            const label = document.createElement('label');
            label.className = 'btn btn-sm position-relative';
            label.style.background = col;
            label.style.color = '#fff';
            label.style.width = '36px';
            label.style.height = '36px';
            label.style.display = 'inline-flex';
            label.style.alignItems = 'center';
            label.style.justifyContent = 'center';
            label.style.borderRadius = '6px';
            label.style.cursor = 'pointer';
            label.style.marginRight = '6px';

            const input = document.createElement('input');
            input.type = 'radio';
            input.name = 'color';
            input.value = col;
            input.className = 'd-none';

            const check = document.createElement('i');
            check.className = 'ti ti-check';
            check.style.fontSize = '16px';
            check.style.display = 'none';

            if (selectedColor && col.toLowerCase() === selectedColor.toLowerCase()) {
                input.checked = true;
                check.style.display = 'inline-block';
                label.style.boxShadow = '0 0 0 3px rgba(0,0,0,0.08) inset';
            }

            label.appendChild(input);
            label.appendChild(check);

            label.addEventListener('click', function(e) {
                // Uncheck other radios
                const radios = container.querySelectorAll('input[name="color"]');
                radios.forEach(r => {
                    r.checked = false;
                    if (r.nextSibling) r.nextSibling.style.display = 'none';
                    r.parentNode.style.boxShadow = '';
                });
                input.checked = true;
                check.style.display = 'inline-block';
                label.style.boxShadow = '0 0 0 3px rgba(0,0,0,0.08) inset';
            });

            container.appendChild(label);
        });
    }

    // Initialize add modal colors and wire form submit via AJAX
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        $('#categoriesTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true
        });

        buildColorOptions('add_color_options', colorPalette[0]);

        const addForm = document.getElementById('addCategoryForm');
        if (addForm) {
            addForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(addForm);
                // ensure color exists
                if (!formData.get('color')) formData.set('color', colorPalette[0]);
                // convert to boolean
                formData.set('is_active', (formData.get('is_active') == 'on' ? '1' : '0'));

                fetch(addForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: formData
                }).then(async res => {
                    const data = await res.json().catch(() => ({}));
                    if (res.ok) {
                        // hide modal and show success
                        try { bootstrap.Modal.getInstance(document.getElementById('addCategoryModal')).hide(); } catch(e){}
                        showToast('success', data.message || 'Category created successfully');
                        setTimeout(()=> location.reload(), 700);
                    } else {
                        const msg = (data.errors && Object.values(data.errors).flat()[0]) || data.message || 'Failed to create category';
                        showToast('error', msg);
                    }
                }).catch(err => {
                    showToast('error', 'Network error. Please try again.');
                    console.error(err);
                });
            });
        }

        // Edit form submit handler
        const editForm = document.getElementById('editCategoryForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(editForm);
                // method spoofing
                formData.set('_method', 'PUT');
                // convert to boolean
                formData.set('is_active', (formData.get('is_active') == 'on' ? '1' : '0'));

                const action = editForm.action;
                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: formData
                }).then(async res => {
                    const data = await res.json().catch(() => ({}));
                    if (res.ok) {
                        try { bootstrap.Modal.getInstance(document.getElementById('editCategoryModal')).hide(); } catch(e){}
                        showToast('success', data.message || 'Category updated successfully');
                        setTimeout(()=> location.reload(), 700);
                    } else {
                        const msg = (data.errors && Object.values(data.errors).flat()[0]) || data.message || 'Failed to update category';
                        showToast('error', msg);
                    }
                }).catch(err => {
                    showToast('error', 'Network error. Please try again.');
                    console.error(err);
                });
            });
        }
    });

    function openEditModal(button) {
        try {
            const categoryData = button.getAttribute('data-category');
            const category = JSON.parse(categoryData);
            const id = button.getAttribute('data-category-id');
            
            const form = document.getElementById('editCategoryForm');
            form.action = `{{ url('/portal/tickets/categories') }}/${id}`;
            document.getElementById('edit_name').value = category.name;
            document.getElementById('edit_description').value = category.description || '';
            document.getElementById('edit_is_active').checked = !!category.is_active;

            // Build color options with selected value
            buildColorOptions('edit_color_options', category.color || colorPalette[0]);

            new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
        } catch (error) {
            console.error('Error opening edit modal:', error);
            showToast('error', 'Failed to open edit modal');
        }
    }

    function deleteCategory(button) {
        const id = button.getAttribute('data-category-id');
        const name = button.getAttribute('data-category-name');
        
        showConfirmModal({
            title: 'Confirm Delete',
            message: `Are you sure you want to delete the category "<strong>${name}</strong>"? This cannot be undone.`,
            type: 'danger',
            icon: 'ti ti-trash-x',
            confirmText: 'Yes, Delete',
            confirmIcon: 'ti ti-trash',
            onConfirm: function() {
                showToast('info', 'Deleting category...');
                
                fetch(`{{ url('/portal/tickets/categories') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', data.message || 'Category deleted successfully!');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast('error', data.message || 'Failed to delete category');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'An error occurred while deleting the category');
                });
            }
        });
    }
    </script>
@endpush
