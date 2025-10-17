@extends('admin.layouts.app')

@section('title', 'Ticket Categories')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">Ticket Categories</h4>
                <p class="mb-0 text-muted">Manage support ticket categories</p>
            </div>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="ti ti-plus me-1"></i> Add Category
                </button>
            </div>
        </div>

        <div class="row">
            @if($categories->count() > 0)
                @foreach($categories as $category)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex align-items-center justify-content-between" style="background: {{ $category->color }}; color: #fff;">
                            <h5 class="mb-0">{{ $category->name }}</h5>
                            @if($category->is_active)
                                <span class="badge bg-light text-dark">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">{{ $category->description ?: 'No description provided' }}</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="fw-bold" style="color: {{ $category->color }}">{{ $category->tickets_count }}</span>
                                    <small class="text-muted ms-1">tickets</small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary me-2" 
                                            onclick="openEditModal({{ $category->id }}, @json($category))">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    @if($category->tickets_count == 0)
                                        <button class="btn btn-sm btn-danger" onclick="openDeleteModal({{ $category->id }}, '{{ addslashes($category->name) }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <i class="ti ti-folder-open" style="font-size: 48px; color: #e9ecef;"></i>
                            <h5 class="mt-3">No Categories Yet</h5>
                            <p class="text-muted">Create your first ticket category to get started.</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                <i class="ti ti-plus me-1"></i> Create Category
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.tickets.categories.store') }}" method="POST">
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
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach(['#667eea',' #f5222d','#52c41a','#1890ff','#faad14','#722ed1'] as $color)
                                <label class="btn btn-sm" style="background: {{ $color }}; color: #fff;">
                                    <input type="radio" name="color" value="{{ $color }}" {{ $loop->first ? 'checked' : '' }} class="d-none">
                                </label>
                            @endforeach
                        </div>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteCategoryForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure you want to delete the category "<strong id="delete_category_name"></strong>"?</p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const colorPalette = ['#667eea','#f5222d','#52c41a','#1890ff','#faad14','#722ed1'];

    function openEditModal(id, category) {
        const form = document.getElementById('editCategoryForm');
        form.action = `{{ url('/portal/tickets/categories') }}/${id}`;
        document.getElementById('edit_name').value = category.name;
        document.getElementById('edit_description').value = category.description || '';
        document.getElementById('edit_is_active').checked = !!category.is_active;

        // Build color options
        const container = document.getElementById('edit_color_options');
        container.innerHTML = '';
        colorPalette.forEach(col => {
            const label = document.createElement('label');
            label.className = 'btn btn-sm';
            label.style.background = col;
            label.style.color = '#fff';
            label.style.marginRight = '6px';
            const input = document.createElement('input');
            input.type = 'radio';
            input.name = 'color';
            input.value = col;
            input.className = 'd-none';
            if (col.toLowerCase() === (category.color || '').toLowerCase()) input.checked = true;
            label.appendChild(input);
            container.appendChild(label);
        });

        new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    }

    function openDeleteModal(id, name) {
        const form = document.getElementById('deleteCategoryForm');
        form.action = `{{ url('/portal/tickets/categories') }}/${id}`;
        document.getElementById('delete_category_name').textContent = name;
        new bootstrap.Modal(document.getElementById('deleteCategoryModal')).show();
    }
</script>
@endsection
