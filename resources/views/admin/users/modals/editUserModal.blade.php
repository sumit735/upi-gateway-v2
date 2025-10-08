
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editUserForm">
                @csrf
                <input type="hidden" id="edit_user_id" name="user_id">
                <input type="hidden" id="form_method" name="_method" value="PUT">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">
                        <i class="ti ti-user-edit me-2" id="userModalIcon"></i><span id="userModalTitleText">Edit User</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <!-- Loading State -->
                    <div id="editUserLoading" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Loading user details...</p>
                    </div>
                    
                    <!-- Form Content -->
                    <div id="editUserFormContent">
                        <!-- User Details Section -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="ti ti-user me-2"></i>User Information
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                                        <input type="text" class="form-control" id="edit_name" name="name" required>
                                    </div>
                                    <div class="invalid-feedback" id="error_edit_name"></div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-mail"></i></span>
                                        <input type="email" class="form-control" id="edit_email" name="email" required>
                                    </div>
                                    <div class="invalid-feedback" id="error_edit_email"></div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-phone"></i></span>
                                        <input type="text" class="form-control" id="edit_phone" name="phone" required>
                                    </div>
                                    <div class="invalid-feedback" id="error_edit_phone"></div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Role <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-shield"></i></span>
                                        <select class="form-select" id="edit_role_id" name="role_id" required>
                                            <option value="">Select Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="invalid-feedback" id="error_edit_role_id"></div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Aadhaar Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-id"></i></span>
                                        <input type="text" class="form-control" id="edit_aadhaar" name="aadhaar" maxlength="12">
                                    </div>
                                    <div class="invalid-feedback" id="error_edit_aadhaar"></div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">PAN Card</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-id-badge"></i></span>
                                        <input type="text" class="form-control" id="edit_pancard" name="pancard" maxlength="10" style="text-transform: uppercase;">
                                    </div>
                                    <div class="invalid-feedback" id="error_edit_pancard"></div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                                        <label class="form-check-label" for="edit_is_active">
                                            <i class="ti ti-user-check me-1"></i>Active Status
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Details Section -->
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="ti ti-building me-2"></i>Additional Details
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Company Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-building"></i></span>
                                        <input type="text" class="form-control" id="edit_company_name" name="company_name">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">District</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                                        <input type="text" class="form-control" id="edit_district" name="district">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">State</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-map"></i></span>
                                        <input type="text" class="form-control" id="edit_state" name="state">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Pincode</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-mailbox"></i></span>
                                        <input type="text" class="form-control" id="edit_pincode" name="pincode" maxlength="6">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Password Section -->
                        <div class="mb-3" id="passwordSection">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="ti ti-lock me-2"></i><span id="passwordSectionTitle">Change Password</span>
                            </h6>
                            
                            <div class="form-check form-switch mb-3" id="passwordToggleSection">
                                <input class="form-check-input" type="checkbox" id="change_password_toggle">
                                <label class="form-check-label" for="change_password_toggle">
                                    <i class="ti ti-key me-1"></i>Update Password
                                </label>
                            </div>
                            
                            <div id="passwordChangeFields">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-lock"></i></span>
                                            <input type="password" class="form-control" id="edit_password" name="password" autocomplete="new-password">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('edit_password')">
                                                <i class="ti ti-eye" id="edit_password_icon"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Minimum 8 characters</small>
                                        <div class="invalid-feedback" id="error_edit_password"></div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-lock"></i></span>
                                            <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" autocomplete="new-password">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('edit_password_confirmation')">
                                                <i class="ti ti-eye" id="edit_password_confirmation_icon"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback" id="error_edit_password_confirmation"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="updateUserBtn">
                        <i class="ti ti-device-floppy me-1" id="submitBtnIcon"></i><span id="submitBtnText">Update User</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
