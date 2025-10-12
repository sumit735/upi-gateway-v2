<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Two-Factor Authentication</h5>
        @if($user->two_factor_enabled)
            <span class="badge bg-success">Enabled</span>
        @else
            <span class="badge bg-secondary">Disabled</span>
        @endif
    </div>
    <div class="card-body">
        @if(!$user->two_factor_enabled)
            <!-- Enable 2FA Section -->
            <div id="enable2FASection">
                <div class="alert alert-info">
                    <i class="ti ti-info-circle me-2"></i>
                    Two-factor authentication adds an extra layer of security to your account. You'll need to enter a code from your authenticator app along with your password when logging in.
                </div>

                <p class="mb-3">Use an authenticator app like:</p>
                <ul class="mb-4">
                    <li>Google Authenticator</li>
                    <li>Microsoft Authenticator</li>
                    <li>Authy</li>
                    <li>1Password</li>
                </ul>

                <button type="button" class="btn btn-primary" onclick="enableTwoFactor()">
                    <i class="ti ti-shield-check me-1"></i>Enable Two-Factor Authentication
                </button>
            </div>

            <!-- Setup 2FA Section (Hidden Initially) -->
            <div id="setup2FASection" class="d-none">
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle me-2"></i>
                    <strong>Important:</strong> Save your recovery codes in a safe place. You'll need them if you lose access to your authenticator app.
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="mb-3">Step 1: Scan QR Code</h6>
                        <div class="text-center mb-3">
                            <div id="qrCodeContainer" class="border rounded p-3 bg-white d-inline-block"></div>
                        </div>
                        <p class="text-muted small">Or enter this key manually:</p>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="secretKey" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('#secretKey')">
                                <i class="ti ti-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="mb-3">Step 2: Recovery Codes</h6>
                        <div class="bg-light border rounded p-3 mb-3">
                            <div id="recoveryCodesContainer" class="font-monospace small"></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="downloadRecoveryCodes()">
                            <i class="ti ti-download me-1"></i>Download Codes
                        </button>
                    </div>
                </div>

                <h6 class="mb-3">Step 3: Verify Setup</h6>
                <form id="confirm2FAForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Enter the 6-digit code from your authenticator app</label>
                        <input type="text" class="form-control" name="code" maxlength="6" pattern="[0-9]{6}" required placeholder="000000">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light" onclick="cancel2FASetup()">
                            <i class="ti ti-x me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-check me-1"></i>Verify & Enable
                        </button>
                    </div>
                </form>
            </div>
        @else
            <!-- Disable 2FA Section -->
            <div id="disable2FASection">
                <div class="alert alert-success">
                    <i class="ti ti-shield-check me-2"></i>
                    Two-factor authentication is currently <strong>enabled</strong> on your account.
                    <div class="mt-2 small text-muted">Enabled on: {{ $user->two_factor_confirmed_at->format('M d, Y') }}</div>
                </div>

                <div class="mb-4">
                    <h6 class="mb-3">Recovery Codes</h6>
                    <p class="text-muted small mb-2">Keep these codes safe. You can use them to access your account if you lose your authenticator device.</p>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewRecoveryCodes()">
                            <i class="ti ti-eye me-1"></i>View Codes
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="regenerateRecoveryCodes()">
                            <i class="ti ti-refresh me-1"></i>Regenerate Codes
                        </button>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="text-danger mb-3">Disable Two-Factor Authentication</h6>
                <p class="text-muted mb-3">This will remove the extra security layer from your account.</p>
                
                <button type="button" class="btn btn-danger" onclick="showDisable2FAModal()">
                    <i class="ti ti-shield-off me-1"></i>Disable Two-Factor Authentication
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Recovery Codes Modal -->
<div class="modal fade" id="recoveryCodesModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recovery Codes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle me-2"></i>
                    Store these codes in a safe place. Each code can only be used once.
                </div>
                <div class="bg-light border rounded p-3 mb-3">
                    <div id="modalRecoveryCodesContainer" class="font-monospace small"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadRecoveryCodes()">
                    <i class="ti ti-download me-1"></i>Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Disable 2FA Modal -->
<div class="modal fade" id="disable2FAModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Disable Two-Factor Authentication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="ti ti-alert-triangle me-2"></i>
                    <strong>Warning:</strong> Disabling two-factor authentication will make your account less secure.
                </div>
                <form id="disable2FAForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Enter your password to confirm</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="disableTwoFactor()">
                    <i class="ti ti-shield-off me-1"></i>Disable
                </button>
            </div>
        </div>
    </div>
</div>
