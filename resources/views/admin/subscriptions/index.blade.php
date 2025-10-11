@extends('admin.layouts.app')

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('title', 'Subscriptions')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('admin.partials.breadcrumb', [
                'title' => 'Subscription Management',
                'breadcrumbs' => [['title' => 'Subscriptions']]
            ])
                <button type="button" class="btn btn-light me-2" onclick="refreshTable()">
                    <i class="ti ti-refresh me-2"></i>Refresh
                </button>
                <button type="button" class="btn btn-primary" onclick="createSubscription()">
                    <i class="ti ti-plus me-2"></i>Add Subscription Plan
                </button>
            @endcomponent

            <!-- Filters -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
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

            <!-- Subscriptions Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-package me-2"></i>Subscription Plans
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="subscriptionsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Plan Name</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Final Price</th>
                                    <th>Status</th>
                                    <th>Popular</th>
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
            <!-- /Subscriptions Table -->

        </div>
    </div>

    <!-- Include Reusable Confirmation Modal -->
    @include('admin.partials.confirmModal')

    <!-- Include Edit Subscription Modal -->
    @include('admin.subscriptions.modals.editSubscriptionModal')

    <!-- View Details Modal -->
    <div class="modal fade" id="viewSubscriptionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-eye me-2"></i>Subscription Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewSubscriptionContent">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
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
        let subscriptionsTable;

        document.addEventListener('DOMContentLoaded', function() {
            initializeDataTable();
        });

        function initializeDataTable() {
            subscriptionsTable = $('#subscriptionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.subscriptions.list') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(d) {
                        d.status_filter = $('#statusFilter').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        width: '50px'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'duration',
                        name: 'duration_value',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: function(data) {
                            return '₹' + parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'discount_percentage',
                        name: 'discount_percentage',
                        render: function(data) {
                            return parseFloat(data).toFixed(2) + '%';
                        }
                    },
                    {
                        data: 'price_display',
                        name: 'final_price',
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
                        data: 'popular_badge',
                        name: 'is_popular',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-end'
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                language: {
                    lengthMenu: 'Row Per Page _MENU_ Entries',
                    search: '',
                    searchPlaceholder: 'Search',
                    paginate: {
                        previous: '<i class="ti ti-chevron-left"></i>',
                        next: '<i class="ti ti-chevron-right"></i>'
                    }
                }
            });
        }

        function refreshTable() {
            subscriptionsTable.ajax.reload();
        }

        function applyFilters() {
            subscriptionsTable.ajax.reload();
        }

        function clearFilters() {
            $('#statusFilter').val('');
            subscriptionsTable.ajax.reload();
        }

        function createSubscription() {
            const modal = new bootstrap.Modal(document.getElementById('editSubscriptionModal'));
            
            // Update modal title
            document.getElementById('subscriptionModalTitle').textContent = 'Add New Subscription Plan';
            document.getElementById('submitBtnText').textContent = 'Create Plan';
            
            // Reset form
            document.getElementById('editSubscriptionForm').reset();
            document.getElementById('subscription_id').value = '';
            document.getElementById('form_method').value = 'POST';
            
            // Clear errors
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            
            // Reset features
            document.getElementById('featuresContainer').innerHTML = '';
            addFeature();
            
            modal.show();
        }

        function editSubscription(id) {
            const modal = new bootstrap.Modal(document.getElementById('editSubscriptionModal'));
            
            // Update modal title
            document.getElementById('subscriptionModalTitle').textContent = 'Edit Subscription Plan';
            document.getElementById('submitBtnText').textContent = 'Update Plan';
            
            // Set form method
            document.getElementById('form_method').value = 'PUT';
            
            modal.show();
            
            // Fetch subscription data
            fetch(`{{ url('/portal/subscriptions') }}/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const sub = data.subscription;
                        
                        document.getElementById('subscription_id').value = sub.id;
                        document.getElementById('name').value = sub.name;
                        document.getElementById('duration_type').value = sub.duration_type;
                        document.getElementById('duration_value').value = sub.duration_value;
                        document.getElementById('price').value = sub.price;
                        document.getElementById('discount_percentage').value = sub.discount_percentage;
                        document.getElementById('description').value = sub.description || '';
                        document.getElementById('is_active').checked = sub.is_active;
                        document.getElementById('is_popular').checked = sub.is_popular;
                        document.getElementById('sort_order').value = sub.sort_order;
                        
                        // Load features
                        document.getElementById('featuresContainer').innerHTML = '';
                        if (sub.features && sub.features.length > 0) {
                            sub.features.forEach(feature => {
                                addFeature(feature);
                            });
                        } else {
                            addFeature();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Failed to load subscription details');
                });
        }

        function viewSubscription(id) {
            const modal = new bootstrap.Modal(document.getElementById('viewSubscriptionModal'));
            const content = document.getElementById('viewSubscriptionContent');
            
            content.innerHTML = '<div class="text-center py-5"><div class="spinner-border"></div></div>';
            modal.show();
            
            fetch(`{{ url('/portal/subscriptions') }}/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const sub = data.subscription;
                        content.innerHTML = `
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Plan Name</label>
                                    <h5>${sub.name}</h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Duration</label>
                                    <h5><span class="badge bg-info">${sub.duration_text}</span></h5>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small">Original Price</label>
                                    <h5>₹${parseFloat(sub.price).toFixed(2)}</h5>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small">Discount</label>
                                    <h5>${parseFloat(sub.discount_percentage).toFixed(2)}%</h5>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small">Final Price</label>
                                    <h5 class="text-success">₹${parseFloat(sub.final_price).toFixed(2)}</h5>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="text-muted small">Description</label>
                                    <p>${sub.description || 'No description'}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="text-muted small">Features</label>
                                    <ul class="list-group">
                                        ${sub.features && sub.features.length > 0 ? 
                                            sub.features.map(f => `<li class="list-group-item"><i class="ti ti-check text-success me-2"></i>${f}</li>`).join('') : 
                                            '<li class="list-group-item">No features added</li>'}
                                    </ul>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Status</label>
                                    <div>${sub.is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Popular</label>
                                    <div>${sub.is_popular ? '<span class="badge bg-warning">Popular</span>' : '<span class="badge bg-secondary">No</span>'}</div>
                                </div>
                            </div>
                        `;
                    }
                });
        }

        function toggleStatus(id, newStatus) {
            showConfirmModal({
                title: 'Confirm Status Change',
                message: `Are you sure you want to ${newStatus ? 'activate' : 'deactivate'} this subscription plan?`,
                type: newStatus ? 'success' : 'warning',
                onConfirm: function() {
                    fetch(`{{ url('/portal/subscriptions') }}/${id}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('success', data.message);
                                refreshTable();
                            } else {
                                showToast('error', data.message);
                            }
                        });
                }
            });
        }

        function togglePopular(id, newStatus) {
            fetch(`{{ url('/portal/subscriptions') }}/${id}/toggle-popular`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', data.message);
                        refreshTable();
                    } else {
                        showToast('error', data.message);
                    }
                });
        }

        function deleteSubscription(id, name) {
            showConfirmModal({
                title: 'Confirm Delete',
                message: `Are you sure you want to delete "${name}"? This action cannot be undone.`,
                type: 'danger',
                onConfirm: function() {
                    fetch(`{{ url('/portal/subscriptions') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('success', data.message);
                                refreshTable();
                            } else {
                                showToast('error', data.message);
                            }
                        });
                }
            });
        }

        // Handle form submission
        document.getElementById('editSubscriptionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const subscriptionId = document.getElementById('subscription_id').value;
            const formMethod = document.getElementById('form_method').value;
            const formData = new FormData(this);
            
            // Clear previous errors
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            
            // Collect features
            const features = [];
            document.querySelectorAll('.feature-input').forEach(input => {
                if (input.value.trim()) {
                    features.push(input.value.trim());
                }
            });
            
            // Convert to JSON
            const data = {
                name: formData.get('name'),
                duration_type: formData.get('duration_type'),
                duration_value: formData.get('duration_value'),
                price: formData.get('price'),
                discount_percentage: formData.get('discount_percentage') || 0,
                description: formData.get('description'),
                features: features,
                is_active: formData.get('is_active') ? 1 : 0,
                is_popular: formData.get('is_popular') ? 1 : 0,
                sort_order: formData.get('sort_order') || 0
            };
            
            const url = formMethod === 'POST' ? 
                '{{ route('admin.subscriptions.store') }}' : 
                `{{ url('/portal/subscriptions') }}/${subscriptionId}`;
            
            fetch(url, {
                    method: formMethod,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('editSubscriptionModal')).hide();
                        showToast('success', data.message);
                        refreshTable();
                    } else {
                        if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                const input = document.getElementById(field);
                                const error = document.getElementById('error_' + field);
                                if (input && error) {
                                    input.classList.add('is-invalid');
                                    error.textContent = data.errors[field][0];
                                }
                            });
                        }
                        showToast('error', data.message);
                    }
                });
        });

        // Feature management
        function addFeature(value = '') {
            const container = document.getElementById('featuresContainer');
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" class="form-control feature-input" placeholder="Enter feature" value="${value}">
                <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">
                    <i class="ti ti-x"></i>
                </button>
            `;
            container.appendChild(div);
        }
    </script>
@endpush
