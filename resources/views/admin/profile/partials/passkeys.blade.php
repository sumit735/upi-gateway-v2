<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Passkeys</h5>
        <button type="button" class="btn btn-sm btn-primary" onclick="registerNewPasskey()">
            <i class="ti ti-plus me-1"></i>Add Passkey
        </button>
    </div>
    <div class="card-body">
        <div class="alert alert-info mb-4">
            <i class="ti ti-info-circle me-2"></i>
            Passkeys let you sign in quickly and securely using your device's biometric authentication (fingerprint, face, or PIN). They're more secure than passwords and easier to use.
        </div>

        @if($user->passkeys->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Device Name</th>
                            <th>Created</th>
                            <th>Last Used</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->passkeys as $passkey)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm bg-primary-transparent text-primary me-2">
                                            <i class="ti ti-key"></i>
                                        </span>
                                        <div>
                                            <h6 class="mb-0">{{ $passkey->name }}</h6>
                                            <small class="text-muted">{{ substr($passkey->credential_id, 0, 20) }}...</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $passkey->created_at->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    @if($passkey->last_used_at)
                                        <span class="text-muted">{{ $passkey->last_used_at->diffForHumans() }}</span>
                                    @else
                                        <span class="badge bg-secondary">Never used</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-icon btn-danger" 
                                        onclick="deletePasskey({{ $passkey->id }}, '{{ $passkey->name }}')"
                                        title="Delete Passkey">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <span class="avatar avatar-xl bg-light text-muted mb-3">
                    <i class="ti ti-key-off fs-36"></i>
                </span>
                <h6 class="mb-2">No Passkeys Added</h6>
                <p class="text-muted mb-3">Add a passkey to enable passwordless authentication</p>
                <button type="button" class="btn btn-primary" onclick="registerNewPasskey()">
                    <i class="ti ti-plus me-1"></i>Add Your First Passkey
                </button>
            </div>
        @endif

        <div class="mt-4">
            <h6 class="mb-3">How Passkeys Work</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="d-flex">
                        <span class="avatar avatar-sm bg-success-transparent text-success me-2 flex-shrink-0">
                            <i class="ti ti-shield-check"></i>
                        </span>
                        <div>
                            <h6 class="mb-1 fs-14">More Secure</h6>
                            <p class="text-muted small mb-0">Passkeys use cryptographic keys stored securely on your device</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex">
                        <span class="avatar avatar-sm bg-primary-transparent text-primary me-2 flex-shrink-0">
                            <i class="ti ti-bolt"></i>
                        </span>
                        <div>
                            <h6 class="mb-1 fs-14">Faster Login</h6>
                            <p class="text-muted small mb-0">Sign in with just your fingerprint or face recognition</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex">
                        <span class="avatar avatar-sm bg-warning-transparent text-warning me-2 flex-shrink-0">
                            <i class="ti ti-lock"></i>
                        </span>
                        <div>
                            <h6 class="mb-1 fs-14">Phishing Resistant</h6>
                            <p class="text-muted small mb-0">Can't be stolen or used on fake websites</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Passkey Modal -->
<div class="modal fade" id="registerPasskeyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register New Passkey</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="ti ti-info-circle me-2"></i>
                    You'll be prompted to use your device's biometric authentication or security key.
                </div>
                <form id="registerPasskeyForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Device Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="e.g., My iPhone, Work Laptop" required>
                        <small class="text-muted">Give this passkey a name to help you identify it later</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="initiatePasskeyRegistration()">
                    <i class="ti ti-key me-1"></i>Register Passkey
                </button>
            </div>
        </div>
    </div>
</div>
