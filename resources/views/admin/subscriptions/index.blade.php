@extends('admin.layouts.app')

@section('title', 'Subscriptions')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                <div class="my-auto mb-2">
                    <h2 class="mb-1">Subscription Management</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                    <button type="button" class="btn btn-light me-2" onclick="refreshTable()">
                        <i class="ti ti-refresh me-2"></i>Refresh
                    </button>
                    <button type="button" class="btn btn-primary" onclick="createSubscription()">
                        <i class="ti ti-plus me-2"></i>Add Subscription Plan
                    </button>
                </div>
            </div>
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

            <!-- Subscriptions Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-package me-2"></i>Subscription Plans
                    </h5>
                    {{-- <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" id="searchSubscriptions" placeholder="Search plans...">
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="subscriptionsTable">
                            <thead>
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Plan Name</th>
                                    <th width="120">Duration</th>
                                    <th width="100">Price</th>
                                    <th width="100">Discount</th>
                                    <th width="120">Final Price</th>
                                    <th width="100" class="text-center">Status</th>
                                    <th width="100" class="text-center">Popular</th>
                                    <th width="150" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr class="subscription-row">
                                        <td>{{ $subscription->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm rounded bg-primary-transparent me-2">
                                                    <i class="ti ti-package text-primary"></i>
                                                </div>
                                                <span class="fw-semibold subscription-name">{{ $subscription->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $subscription->duration_text }}</span>
                                        </td>
                                        <td>₹{{ number_format($subscription->price, 2) }}</td>
                                        <td>
                                            @if($subscription->discount_percentage > 0)
                                                <span class="badge bg-success-transparent text-success">
                                                    {{ number_format($subscription->discount_percentage, 2) }}% OFF
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-bold text-primary">₹{{ number_format($subscription->final_price, 2) }}</span>
                                                @if($subscription->discount_percentage > 0)
                                                    <br><small class="text-muted"><del>₹{{ number_format($subscription->price, 2) }}</del></small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($subscription->is_active)
                                                <span class="badge bg-success"><i class="ti ti-check me-1"></i>Active</span>
                                            @else
                                                <span class="badge bg-danger"><i class="ti ti-x me-1"></i>Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($subscription->is_popular)
                                                <span class="badge bg-warning"><i class="ti ti-star me-1"></i>Popular</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="button" class="btn btn-sm btn-icon btn-light" 
                                                        onclick="viewSubscription({{ $subscription->id }})" 
                                                        title="View Details">
                                                    <i class="ti ti-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-icon btn-primary" 
                                                        onclick="editSubscription({{ $subscription->id }})" 
                                                        title="Edit">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-icon btn-danger" 
                                                        onclick="deleteSubscription({{ $subscription->id }}, '{{ addslashes($subscription->name) }}')" 
                                                        title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Subscriptions Table -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Subscription Details Modal -->
    <div class="modal fade" id="subscriptionDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-eye me-2"></i>Subscription Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="subscriptionDetailsContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Loading subscription details...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Reusable Confirmation Modal -->
    @include('admin.partials.confirmModal')

    <!-- Include Edit Subscription Modal -->
    @include('admin.subscriptions.modals.editSubscriptionModal')

    <!-- Reusable Toast & Modal Scripts -->
    @include('admin.partials.toastAndModal')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.bootstrap5.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/dataTables.bootstrap5.min.js') }}"></script>

        <script>
            let subscriptionsTable;

            document.addEventListener('DOMContentLoaded', function () {
                subscriptionsTable = $('#subscriptionsTable').DataTable({
                    "paging": true,
                    "ordering": true,
                    "info": true,
                    "searching": true,
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                    "language": {
                        "lengthMenu": "Show _MENU_ entries",
                        "search": "Search:",
                        "paginate": {
                            "previous": '<i class="ti ti-chevron-left"></i>',
                            "next": '<i class="ti ti-chevron-right"></i>'
                        }
                    },
                    "order": [[0, 'desc']]
                });

                // Custom search functionality
                // $('#searchSubscriptions').on('keyup', function() {
                //     subscriptionsTable.search(this.value).draw();
                // });
            });

            function refreshTable() {
                location.reload();
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
                const modal = new bootstrap.Modal(document.getElementById('subscriptionDetailsModal'));
                const content = document.getElementById('subscriptionDetailsContent');

                // Show loading state
                content.innerHTML = `
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Loading subscription details...</p>
                        </div>
                    `;

                modal.show();

                // Fetch subscription details via AJAX
                fetch(`{{ url('/portal/subscriptions') }}/${id}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displaySubscriptionDetails(data.subscription);
                        } else {
                            showError('Failed to load subscription details');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('An error occurred while loading subscription details');
                    });
            }

            function displaySubscriptionDetails(subscription) {
                const content = document.getElementById('subscriptionDetailsContent');

                // Generate features HTML
                let featuresHtml = '';
                if (subscription.features && subscription.features.length > 0) {
                    featuresHtml = subscription.features.map(feature => `
                            <li class="mb-1"><i class="ti ti-check text-success me-2"></i>${feature}</li>
                        `).join('');
                } else {
                    featuresHtml = '<li class="text-muted">No features listed</li>';
                }

                content.innerHTML = `
                        <div class="row">
                            <!-- Subscription Information -->
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="mb-0">
                                            <i class="ti ti-info-circle me-2"></i>Plan Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted small">Plan Name</label>
                                            <h6 class="mb-0">${subscription.name}</h6>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted small">Duration</label>
                                            <div><span class="badge bg-info">${subscription.duration_value + subscription.duration_type}</span></div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted small">Sort Order</label>
                                            <p class="mb-0">${subscription.sort_order}</p>
                                        </div>
                                        ${subscription.description ? `
                                        <div class="mb-0">
                                            <label class="text-muted small">Description</label>
                                            <p class="mb-0">${subscription.description}</p>
                                        </div>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Information -->
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="mb-0">
                                            <i class="ti ti-currency-rupee me-2"></i>Pricing & Status
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted small">Original Price</label>
                                            <h6 class="mb-0">₹${parseFloat(subscription.price).toFixed(2)}</h6>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted small">Discount</label>
                                            <div>${parseFloat(subscription.discount_percentage).toFixed(2)}%</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted small">Final Price</label>
                                            <h5 class="mb-0 text-success">₹${parseFloat(subscription.final_price).toFixed(2)}</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted small">Status</label>
                                            <div>
                                                ${subscription.is_active ?
                        '<span class="badge bg-success"><i class="ti ti-check me-1"></i>Active</span>' :
                        '<span class="badge bg-danger"><i class="ti ti-x me-1"></i>Inactive</span>'
                    }
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <label class="text-muted small">Popular</label>
                                            <div>
                                                ${subscription.is_popular ?
                        '<span class="badge bg-warning"><i class="ti ti-star me-1"></i>Popular</span>' :
                        '<span class="badge bg-secondary">No</span>'
                    }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="card border mb-0">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="ti ti-list me-2"></i>Features
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">${featuresHtml}</ul>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="editSubscription(${subscription.id}); bootstrap.Modal.getInstance(document.getElementById('subscriptionDetailsModal')).hide();">
                                <i class="ti ti-edit me-1"></i>Edit Plan
                            </button>
                        </div>
                    `;
            }

            function showError(message) {
                const content = document.getElementById('subscriptionDetailsContent');
                content.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="ti ti-alert-circle me-2"></i>${message}
                        </div>
                    `;
            }

            function deleteSubscription(id, name) {
                showConfirmModal({
                    title: 'Confirm Delete',
                    message: `Are you sure you want to delete the subscription plan <strong>"${name}"</strong>? This action cannot be undone.`,
                    type: 'danger',
                    icon: 'ti ti-trash-x',
                    confirmText: 'Yes, Delete',
                    confirmIcon: 'ti-trash',
                    onConfirm: function () {
                        // Show loading toast
                        showToast('info', 'Deleting subscription...');

                        fetch(`{{ url('/portal/subscriptions') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showToast('success', data.message);
                                    setTimeout(function () {
                                        refreshTable();
                                    }, 1500);
                                } else {
                                    showToast('error', data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showToast('error', 'An error occurred while deleting the subscription');
                            });
                    }
                });
            }

            // Handle form submission
            document.getElementById('editSubscriptionForm').addEventListener('submit', function (e) {
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
                    '{{ route('admin.settings.subscriptions.store') }}' :
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

@endsection