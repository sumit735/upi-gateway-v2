<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Change Password</h5>
    </div>
    <div class="card-body">
        <form id="changePasswordForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Current Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" name="current_password" id="current_password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_password')">
                        <i class="ti ti-eye" id="current_password_icon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="new_password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password')">
                        <i class="ti ti-eye" id="new_password_icon"></i>
                    </button>
                </div>
                <small class="text-muted">Password must be at least 8 characters with uppercase, lowercase, number, and symbol.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation')">
                        <i class="ti ti-eye" id="password_confirmation_icon"></i>
                    </button>
                </div>
            </div>

            <div class="alert alert-warning">
                <i class="ti ti-alert-triangle me-2"></i>
                <strong>Security Notice:</strong> After changing your password, you will remain logged in on this device but will be logged out from all other devices.
            </div>

            <div class="text-end">
                <button type="button" class="btn btn-light me-2" onclick="$('#changePasswordForm')[0].reset()">
                    <i class="ti ti-refresh me-1"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                    <i class="ti ti-lock me-1"></i>Change Password
                </button>
            </div>
        </form>
    </div>
</div>
