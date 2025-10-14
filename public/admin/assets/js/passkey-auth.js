/**
 * Passkey Authentication for Login
 * WebAuthn implementation for passwordless authentication
 * Supports both discoverable (no email) and non-discoverable (with email) credentials
 */

// Login with discoverable passkey (no email required - like GitHub)
async function loginWithDiscoverablePasskey() {
    if (!window.PublicKeyCredential) {
        showNotification('Passkeys are not supported on this device/browser', 'danger');
        return false;
    }

    try {
        // Step 1: Get authentication options from server (no email needed)
        const optionsResponse = await fetch('/passkey/discoverable-options', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json',
            },
        });

        if (!optionsResponse.ok) {
            throw new Error('Failed to get authentication options');
        }

        const options = await optionsResponse.json();

        if (!options.success) {
            throw new Error(options.message || 'Failed to get authentication options');
        }

        // Step 2: Prepare WebAuthn options for discoverable credential
        const publicKeyCredentialRequestOptions = {
            challenge: base64ToArrayBuffer(options.challenge),
            timeout: options.timeout,
            rpId: options.rpId,
            userVerification: options.userVerification,
            // No allowCredentials - authenticator will show all passkeys for this domain
        };

        // Step 3: Get credential from authenticator
        showNotification('Please use your passkey to sign in...', 'primary');
        
        const credential = await navigator.credentials.get({
            publicKey: publicKeyCredentialRequestOptions
        });

        if (!credential) {
            throw new Error('Authentication failed');
        }

        // Step 4: Prepare credential data for server verification
        const credentialData = {
            credential_id: arrayBufferToBase64(credential.rawId),
            authenticator_data: arrayBufferToBase64(credential.response.authenticatorData),
            client_data_json: arrayBufferToBase64(credential.response.clientDataJSON),
            signature: arrayBufferToBase64(credential.response.signature),
            user_handle: credential.response.userHandle ? arrayBufferToBase64(credential.response.userHandle) : null,
        };

        // Step 5: Verify with server
        const verifyResponse = await fetch('/passkey/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify(credentialData),
        });

        const result = await verifyResponse.json();

        if (result.success) {
            showNotification(`Welcome back, ${result.user.name}!`, 'success');
            setTimeout(() => {
                window.location.href = result.redirect;
            }, 500);
            return true;
        } else {
            throw new Error(result.message || 'Authentication failed');
        }

    } catch (error) {
        console.error('Passkey authentication error:', error);
        
        if (error.name === 'NotAllowedError') {
            showNotification('Authentication cancelled or not allowed', 'danger');
        } else if (error.name === 'InvalidStateError') {
            showNotification('No passkeys found for this site', 'danger');
        } else if (error.name === 'NotSupportedError') {
            showNotification('Passkeys not supported on this device', 'danger');
        } else {
            showNotification(error.message || 'Failed to authenticate with passkey', 'danger');
        }
        
        return false;
    }
}
async function checkPasskeyAvailability(email) {
    if (!email || !window.PublicKeyCredential) {
        return false;
    }

    try {
        const response = await fetch('/passkey/auth-options', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ email }),
        });

        return response.ok;
    } catch (error) {
        return false;
    }
}

// Initiate passkey login
async function loginWithPasskey(email) {
    if (!window.PublicKeyCredential) {
        showNotification('Passkeys are not supported on this device/browser', 'danger');
        return false;
    }

    if (!email) {
        showNotification('Please enter your email address', 'danger');
        return false;
    }

    try {
        // Step 1: Get authentication options from server
        const optionsResponse = await fetch('/passkey/auth-options', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ email }),
        });

        if (!optionsResponse.ok) {
            const error = await optionsResponse.json();
            throw new Error(error.message || 'No passkeys found for this account');
        }

        const options = await optionsResponse.json();

        if (!options.success) {
            throw new Error(options.message || 'Failed to get authentication options');
        }

        // Step 2: Prepare WebAuthn options
        const publicKeyCredentialRequestOptions = {
            challenge: base64ToArrayBuffer(options.challenge),
            timeout: options.timeout,
            rpId: options.rpId,
            allowCredentials: options.allowCredentials.map(cred => ({
                ...cred,
                id: base64ToArrayBuffer(cred.id),
            })),
            userVerification: options.userVerification,
        };

        // Step 3: Get credential from authenticator
        showNotification('Please use your passkey to sign in...', 'primary');
        
        const credential = await navigator.credentials.get({
            publicKey: publicKeyCredentialRequestOptions
        });

        if (!credential) {
            throw new Error('Authentication failed');
        }

        // Step 4: Prepare credential data for server verification
        const credentialData = {
            credential_id: arrayBufferToBase64(credential.rawId),
            authenticator_data: arrayBufferToBase64(credential.response.authenticatorData),
            client_data_json: arrayBufferToBase64(credential.response.clientDataJSON),
            signature: arrayBufferToBase64(credential.response.signature),
        };

        // Step 5: Verify with server
        const verifyResponse = await fetch('/passkey/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify(credentialData),
        });

        const result = await verifyResponse.json();

        if (result.success) {
            showNotification('Authentication successful! Redirecting...', 'success');
            setTimeout(() => {
                window.location.href = result.redirect;
            }, 500);
            return true;
        } else {
            throw new Error(result.message || 'Authentication failed');
        }

    } catch (error) {
        console.error('Passkey authentication error:', error);
        
        if (error.name === 'NotAllowedError') {
            showNotification('Authentication cancelled or not allowed', 'danger');
        } else if (error.name === 'InvalidStateError') {
            showNotification('This authenticator is not registered', 'danger');
        } else {
            showNotification(error.message || 'Failed to authenticate with passkey', 'danger');
        }
        
        return false;
    }
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

// Show notification using UIkit
function showNotification(message, status = 'primary') {
    if (typeof UIkit !== 'undefined' && UIkit.notification) {
        UIkit.notification(message, { status: status, pos: 'top-center', timeout: 3000 });
    } else {
        alert(message);
    }
}

// Check WebAuthn support on page load
document.addEventListener('DOMContentLoaded', function() {
    const discoverableSection = document.getElementById('discoverablePasskeySection');
    
    if (discoverableSection) {
        // Hide passkey button if WebAuthn is not supported
        if (!window.PublicKeyCredential) {
            discoverableSection.style.display = 'none';
        }
    }
});
