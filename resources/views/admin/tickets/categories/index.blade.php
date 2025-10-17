@extends('admin.layouts.app')

@section('title', 'Ticket Categories')

@section('content')
<div class="uk-container uk-container-large uk-margin-large-top">
    
    <!-- Header -->
    <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-medium-bottom">
        <div>
            <h2 class="uk-margin-remove">Ticket Categories</h2>
            <p class="uk-text-muted uk-margin-remove-top">Manage support ticket categories</p>
        </div>
        <button class="uk-button uk-button-primary uk-border-rounded" uk-toggle="target: #addCategoryModal">
            <i class="fas fa-plus"></i> Add Category
        </button>
    </div>

    <!-- Categories Grid -->
    @if($categories->count() > 0)
        <div class="uk-grid-small uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
            @foreach($categories as $category)
                <div>
                    <div class="uk-card uk-card-default uk-card-hover uk-border-rounded">
                        <div class="uk-card-header" style="background: {{ $category->color }}; color: white; border-radius: 8px 8px 0 0;">
                            <div class="uk-flex uk-flex-between uk-flex-middle">
                                <h4 class="uk-margin-remove">{{ $category->name }}</h4>
                                <div>
                                    @if($category->is_active)
                                        <span class="uk-badge uk-border-rounded" style="background: rgba(255,255,255,0.3);">
                                            <i class="fas fa-check"></i> Active
                                        </span>
                                    @else
                                        <span class="uk-badge uk-border-rounded" style="background: rgba(0,0,0,0.3);">
                                            <i class="fas fa-times"></i> Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="uk-card-body">
                            <p class="uk-text-muted uk-margin-small">
                                {{ $category->description ?: 'No description provided' }}
                            </p>
                            <div class="uk-flex uk-flex-between uk-flex-middle">
                                <div>
                                    <span class="uk-text-bold" style="color: {{ $category->color }};">{{ $category->tickets_count }}</span>
                                    <span class="uk-text-small uk-text-muted">tickets</span>
                                </div>
                                <div>
                                    <button class="uk-button uk-button-small uk-button-default uk-border-rounded" 
                                            onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}', '{{ $category->color }}', {{ $category->is_active ? 'true' : 'false' }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    @if($category->tickets_count == 0)
                                        <button class="uk-button uk-button-small uk-button-danger uk-border-rounded" 
                                                onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="uk-card uk-card-default uk-card-body uk-text-center uk-border-rounded" style="padding: 60px;">
            <i class="fas fa-folder-open" style="font-size: 80px; color: #e5e5e5;"></i>
            <h3 class="uk-margin-top">No Categories Yet</h3>
            <p class="uk-text-muted">Create your first ticket category to get started.</p>
            <button class="uk-button uk-button-primary uk-border-rounded uk-margin-top" uk-toggle="target: #addCategoryModal">
                <i class="fas fa-plus"></i> Create Category
            </button>
        </div>
    @endif

</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-border-rounded">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h3><i class="fas fa-plus-circle"></i> Add New Category</h3>
        <form action="{{ route('admin.tickets.categories.store') }}" method="POST">
            @csrf
            <div class="uk-margin">
                <label class="uk-form-label">Category Name *</label>
                <input type="text" 
                       name="name" 
                       class="uk-input uk-border-rounded" 
                       placeholder="e.g., Technical Support" 
                       required>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label">Description</label>
                <textarea name="description" 
                          class="uk-textarea uk-border-rounded" 
                          rows="3" 
                          placeholder="Brief description of this category"></textarea>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label">Color *</label>
                <div class="uk-grid-small uk-child-width-auto" uk-grid>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#667eea" checked class="uk-radio">
                            <span class="uk-badge uk-border-rounded" style="background: #667eea; color: white; padding: 8px 15px; cursor: pointer;">Purple</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#f5222d" class="uk-radio">
                            <span class="uk-badge uk-border-rounded" style="background: #f5222d; color: white; padding: 8px 15px; cursor: pointer;">Red</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#52c41a" class="uk-radio">
                            <span class="uk-badge uk-border-rounded" style="background: #52c41a; color: white; padding: 8px 15px; cursor: pointer;">Green</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#1890ff" class="uk-radio">
                            <span class="uk-badge uk-border-rounded" style="background: #1890ff; color: white; padding: 8px 15px; cursor: pointer;">Blue</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#faad14" class="uk-radio">
                            <span class="uk-badge uk-border-rounded" style="background: #faad14; color: white; padding: 8px 15px; cursor: pointer;">Orange</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#722ed1" class="uk-radio">
                            <span class="uk-badge uk-border-rounded" style="background: #722ed1; color: white; padding: 8px 15px; cursor: pointer;">Purple</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="uk-margin">
                <label>
                    <input type="checkbox" name="is_active" value="1" checked class="uk-checkbox">
                    Active
                </label>
            </div>
            <div class="uk-margin-top">
                <button type="submit" class="uk-button uk-button-primary uk-border-rounded">
                    <i class="fas fa-save"></i> Create Category
                </button>
                <button type="button" class="uk-button uk-button-default uk-border-rounded uk-modal-close">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-border-rounded">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h3><i class="fas fa-edit"></i> Edit Category</h3>
        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')
            <div class="uk-margin">
                <label class="uk-form-label">Category Name *</label>
                <input type="text" 
                       id="edit_name" 
                       name="name" 
                       class="uk-input uk-border-rounded" 
                       required>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label">Description</label>
                <textarea id="edit_description" 
                          name="description" 
                          class="uk-textarea uk-border-rounded" 
                          rows="3"></textarea>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label">Color *</label>
                <div class="uk-grid-small uk-child-width-auto" uk-grid>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#667eea" class="uk-radio edit-color">
                            <span class="uk-badge uk-border-rounded" style="background: #667eea; color: white; padding: 8px 15px; cursor: pointer;">Purple</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#f5222d" class="uk-radio edit-color">
                            <span class="uk-badge uk-border-rounded" style="background: #f5222d; color: white; padding: 8px 15px; cursor: pointer;">Red</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#52c41a" class="uk-radio edit-color">
                            <span class="uk-badge uk-border-rounded" style="background: #52c41a; color: white; padding: 8px 15px; cursor: pointer;">Green</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#1890ff" class="uk-radio edit-color">
                            <span class="uk-badge uk-border-rounded" style="background: #1890ff; color: white; padding: 8px 15px; cursor: pointer;">Blue</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#faad14" class="uk-radio edit-color">
                            <span class="uk-badge uk-border-rounded" style="background: #faad14; color: white; padding: 8px 15px; cursor: pointer;">Orange</span>
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="color" value="#722ed1" class="uk-radio edit-color">
                            <span class="uk-badge uk-border-rounded" style="background: #722ed1; color: white; padding: 8px 15px; cursor: pointer;">Purple</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="uk-margin">
                <label>
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="uk-checkbox">
                    Active
                </label>
            </div>
            <div class="uk-margin-top">
                <button type="submit" class="uk-button uk-button-primary uk-border-rounded">
                    <i class="fas fa-save"></i> Update Category
                </button>
                <button type="button" class="uk-button uk-button-default uk-border-rounded uk-modal-close">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteCategoryModal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-border-rounded">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h3><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h3>
        <p>Are you sure you want to delete the category "<strong id="delete_category_name"></strong>"?</p>
        <p class="uk-text-danger uk-text-small">This action cannot be undone.</p>
        <form id="deleteCategoryForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="uk-margin-top">
                <button type="submit" class="uk-button uk-button-danger uk-border-rounded">
                    <i class="fas fa-trash"></i> Delete Category
                </button>
                <button type="button" class="uk-button uk-button-default uk-border-rounded uk-modal-close">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function editCategory(id, name, description, color, isActive) {
        document.getElementById('editCategoryForm').action = "{{ url('/portal/tickets/categories') }}/" + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_is_active').checked = isActive;
        
        // Set the color radio button
        document.querySelectorAll('.edit-color').forEach(radio => {
            radio.checked = radio.value === color;
        });
        
        UIkit.modal('#editCategoryModal').show();
    }

    function deleteCategory(id, name) {
        document.getElementById('deleteCategoryForm').action = "{{ url('/portal/tickets/categories') }}/" + id;
        document.getElementById('delete_category_name').textContent = name;
        UIkit.modal('#deleteCategoryModal').show();
    }
</script>
@endsection
