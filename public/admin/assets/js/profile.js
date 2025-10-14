// Profile Photo Management
function uploadProfilePhoto(input) {
    if (!input.files || !input.files[0]) return;

    const formData = new FormData();
    formData.append('profile_photo', input.files[0]);

    $.ajax({
        url: '/portal/profile/photo',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message);
                // Update preview
                $('#profilePhotoPreview').attr('src', response.photo_url);
                // Reload page to update sidebar
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Failed to upload photo');
        }
    });
}

function deleteProfilePhoto() {
    if (!confirm('Are you sure you want to remove your profile photo?')) return;

    $.ajax({
        url: '/portal/profile/photo',
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message);
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Failed to delete photo');
        }
    });
}

// Personal Information Form
$('#personalInfoForm').on('submit', function(e) {
    e.preventDefault();
    
    const btn = $('#updateProfileBtn');
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Updating...');

    $.ajax({
        url: '/portal/profile/update',
        method: 'POST',
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message);
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Failed to update profile');
            if (xhr.responseJSON?.errors) {
                Object.values(xhr.responseJSON.errors).forEach(errors => {
                    errors.forEach(error => showToast('error', error));
                });
            }
        },
        complete: function() {
            btn.prop('disabled', false).html('<i class="ti ti-check me-1"></i>Update Profile');
        }
    });
});

// Change Password Form
$('#changePasswordForm').on('submit', function(e) {
    e.preventDefault();
    
    const btn = $('#changePasswordBtn');
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Changing...');

    $.ajax({
        url: '/portal/profile/password',
        method: 'POST',
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message);
                $('#changePasswordForm')[0].reset();
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Failed to change password');
            if (xhr.responseJSON?.errors) {
                Object.values(xhr.responseJSON.errors).forEach(errors => {
                    errors.forEach(error => showToast('error', error));
                });
            }
        },
        complete: function() {
            btn.prop('disabled', false).html('<i class="ti ti-lock me-1"></i>Change Password');
        }
    });
});

// Password Visibility Toggle
function togglePasswordVisibility(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('ti-eye');
        icon.classList.add('ti-eye-off');
    } else {
        input.type = 'password';
        icon.classList.remove('ti-eye-off');
        icon.classList.add('ti-eye');
    }
}

// Two-Factor Authentication
let currentRecoveryCodes = [];

function enableTwoFactor() {
    $.ajax({
        url: '/portal/profile/two-factor/enable',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Show setup section
                $('#enable2FASection').addClass('d-none');
                $('#setup2FASection').removeClass('d-none');
                
                // Display QR code SVG
                $('#qrCodeContainer').html(response.qr_code_svg);
                $('#secretKey').val(response.secret);
                
                // Display recovery codes
                currentRecoveryCodes = response.recovery_codes;
                displayRecoveryCodes(response.recovery_codes, '#recoveryCodesContainer');
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Failed to enable 2FA');
        }
    });
}

function cancel2FASetup() {
    if (confirm('Are you sure you want to cancel 2FA setup?')) {
        location.reload();
    }
}

$('#confirm2FAForm').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: '/portal/profile/two-factor/confirm',
        method: 'POST',
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message);
                setTimeout(() => location.reload(), 1500);
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Invalid verification code');
        }
    });
});

function showDisable2FAModal() {
    const modal = new bootstrap.Modal(document.getElementById('disable2FAModal'));
    modal.show();
}

function disableTwoFactor() {
    const formData = $('#disable2FAForm').serialize();
    
    $.ajax({
        url: '/portal/profile/two-factor/disable',
        method: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message);
                bootstrap.Modal.getInstance(document.getElementById('disable2FAModal')).hide();
                setTimeout(() => location.reload(), 1500);
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Failed to disable 2FA');
        }
    });
}

function viewRecoveryCodes() {
    $.ajax({
        url: '/portal/profile/two-factor/recovery-codes',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                currentRecoveryCodes = response.recovery_codes;
                displayRecoveryCodes(response.recovery_codes, '#modalRecoveryCodesContainer');
                const modal = new bootstrap.Modal(document.getElementById('recoveryCodesModal'));
                modal.show();
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Failed to retrieve recovery codes');
        }
    });
}

function regenerateRecoveryCodes() {
    const password = prompt('Enter your password to regenerate recovery codes:');
    if (!password) return;
    
    $.ajax({
        url: '/portal/profile/two-factor/recovery-codes',
        method: 'POST',
        data: { password: password },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message);
                currentRecoveryCodes = response.recovery_codes;
                displayRecoveryCodes(response.recovery_codes, '#modalRecoveryCodesContainer');
                const modal = new bootstrap.Modal(document.getElementById('recoveryCodesModal'));
                modal.show();
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Failed to regenerate recovery codes');
        }
    });
}

function displayRecoveryCodes(codes, container) {
    let html = '<div class="row g-2">';
    codes.forEach((code, index) => {
        html += `<div class="col-6"><div class="p-2 border rounded text-center">${code}</div></div>`;
    });
    html += '</div>';
    $(container).html(html);
}

function downloadRecoveryCodes() {
    if (!currentRecoveryCodes || currentRecoveryCodes.length === 0) {
        showToast('error', 'No recovery codes available');
        return;
    }
    
    const content = 'Two-Factor Authentication Recovery Codes\n' +
                   'Save these codes in a safe place\n\n' +
                   currentRecoveryCodes.join('\n');
    
    const blob = new Blob([content], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = '2fa-recovery-codes.txt';
    a.click();
    window.URL.revokeObjectURL(url);
    
    showToast('success', 'Recovery codes downloaded');
}

// Passkeys Management
function registerNewPasskey() {
    const modal = new bootstrap.Modal(document.getElementById('registerPasskeyModal'));
    modal.show();
}

async function initiatePasskeyRegistration() {
    const name = $('#registerPasskeyForm input[name="name"]').val();
    
    if (!name) {
        showToast('error', 'Please enter a device name');
        return;
    }
    
    // Check if WebAuthn is supported
    if (!window.PublicKeyCredential) {
        showToast('error', 'Passkeys are not supported on this device/browser');
        return;
    }

    try {
        // Step 1: Get registration options from server
        const optionsResponse = await fetch('/portal/profile/passkeys/register-options', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            }
        });

        if (!optionsResponse.ok) {
            throw new Error('Failed to get registration options');
        }

        const options = await optionsResponse.json();

        // Step 2: Prepare WebAuthn options
        const publicKeyCredentialCreationOptions = {
            challenge: base64ToArrayBuffer(options.challenge),
            rp: options.rp,
            user: {
                id: base64ToArrayBuffer(options.user.id),
                name: options.user.name,
                displayName: options.user.displayName,
            },
            pubKeyCredParams: options.pubKeyCredParams,
            timeout: options.timeout,
            attestation: options.attestation,
            excludeCredentials: options.excludeCredentials.map(cred => ({
                ...cred,
                id: base64ToArrayBuffer(cred.id),
            })),
            authenticatorSelection: options.authenticatorSelection,
        };

        // Step 3: Create credential
        showToast('info', 'Please use your device\'s biometric authentication...');
        const credential = await navigator.credentials.create({
            publicKey: publicKeyCredentialCreationOptions
        });

        if (!credential) {
            throw new Error('Credential creation failed');
        }

        // Step 4: Prepare credential data for server
        const credentialData = {
            name: name,
            credential_id: arrayBufferToBase64(credential.rawId),
            public_key: arrayBufferToBase64(credential.response.getPublicKey()),
            aaguid: credential.id,
            transports: credential.response.getTransports ? credential.response.getTransports() : [],
        };

        // Step 5: Send to server for verification and storage
        const registerResponse = await fetch('/portal/profile/passkeys', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify(credentialData),
        });

        const result = await registerResponse.json();

        if (result.success) {
            showToast('success', result.message);
            bootstrap.Modal.getInstance(document.getElementById('registerPasskeyModal')).hide();
            setTimeout(() => location.reload(), 1000);
        } else {
            throw new Error(result.message || 'Registration failed');
        }

    } catch (error) {
        console.error('Passkey registration error:', error);
        if (error.name === 'NotAllowedError') {
            showToast('error', 'Registration cancelled or not allowed');
        } else if (error.name === 'InvalidStateError') {
            showToast('error', 'This authenticator is already registered');
        } else {
            showToast('error', error.message || 'Failed to register passkey');
        }
    }
}

function deletePasskey(id, name) {
    if (!confirm(`Are you sure you want to delete the passkey "${name}"?\n\nYou won't be able to use it to sign in anymore.`)) return;
    
    $.ajax({
        url: `/portal/profile/passkeys/${id}`,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showToast('success', response.message);
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function(xhr) {
            showToast('error', xhr.responseJSON?.message || 'Failed to delete passkey');
        }
    });
}

// WebAuthn Helper Functions
function base64ToArrayBuffer(base64) {
    const binaryString = atob(base64.replace(/-/g, '+').replace(/_/g, '/'));
    const bytes = new Uint8Array(binaryString.length);
    for (let i = 0; i < binaryString.length; i++) {
        bytes[i] = binaryString.charCodeAt(i);
    }
    return bytes.buffer;
}

function arrayBufferToBase64(buffer) {
    const bytes = new Uint8Array(buffer);
    let binary = '';
    for (let i = 0; i < bytes.byteLength; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
}

// Utility Functions
function copyToClipboard(selector) {
    const element = document.querySelector(selector);
    element.select();
    document.execCommand('copy');
    showToast('success', 'Copied to clipboard');
}
