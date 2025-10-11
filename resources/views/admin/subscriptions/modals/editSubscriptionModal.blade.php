<!-- Edit/Create Subscription Modal -->
<div class="modal fade" id="editSubscriptionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-package me-2"></i><span id="subscriptionModalTitle">Add Subscription Plan</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSubscriptionForm">
                @csrf
                <input type="hidden" id="subscription_id" name="subscription_id">
                <input type="hidden" id="form_method" name="_method" value="POST">
                
                <div class="modal-body">
                    <div class="row">
                        <!-- Plan Name -->
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback" id="error_name"></div>
                        </div>

                        <!-- Duration Type -->
                        <div class="col-md-6 mb-3">
                            <label for="duration_type" class="form-label">Duration Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="duration_type" name="duration_type" required>
                                <option value="days">Days</option>
                                <option value="months" selected>Months</option>
                                <option value="years">Years</option>
                            </select>
                            <div class="invalid-feedback" id="error_duration_type"></div>
                        </div>

                        <!-- Duration Value -->
                        <div class="col-md-6 mb-3">
                            <label for="duration_value" class="form-label">Duration Value <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="duration_value" name="duration_value" min="1" required>
                            <div class="invalid-feedback" id="error_duration_value"></div>
                            <small class="text-muted">E.g., 1 for monthly, 3 for quarterly, 6 for biannual, 12 for yearly</small>
                        </div>

                        <!-- Price -->
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Original Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                            <div class="invalid-feedback" id="error_price"></div>
                        </div>

                        <!-- Discount Percentage -->
                        <div class="col-md-6 mb-3">
                            <label for="discount_percentage" class="form-label">Discount (%)</label>
                            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" step="0.01" min="0" max="100" value="0">
                            <div class="invalid-feedback" id="error_discount_percentage"></div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            <div class="invalid-feedback" id="error_description"></div>
                        </div>

                        <!-- Features -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Features</label>
                            <div id="featuresContainer">
                                <!-- Features will be added dynamically -->
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addFeature()">
                                <i class="ti ti-plus me-1"></i>Add Feature
                            </button>
                            <div class="invalid-feedback" id="error_features"></div>
                        </div>

                        <!-- Sort Order -->
                        <div class="col-md-12 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="0">
                            <small class="text-muted">Lower values appear first</small>
                            <div class="invalid-feedback" id="error_sort_order"></div>
                        </div>

                        <!-- Status Checkboxes -->
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">
                                    Active Status
                                </label>
                            </div>
                            <small class="text-muted">Plan will be visible to users</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular">
                                <label class="form-check-label" for="is_popular">
                                    Mark as Popular
                                </label>
                            </div>
                            <small class="text-muted">Highlight this plan</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i><span id="submitBtnText">Create Plan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
