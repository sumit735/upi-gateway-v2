/**
 * Passkey Authentication for Login
 * WebAuthn implementation for passwordless authentication
 * Supports both discoverable (no email) and non-discoverable (with email) credentials
 */

// Login with discoverable passkey (no email required - like GitHub)
async function loginWithDiscoverablePasskey() {
    console.log('🔐 Starting discoverable passkey authentication...');
    
    if (!window.PublicKeyCredential) {
        showNotification('Passkeys are not supported on this device/browser', 'danger');
        console.error('❌ WebAuthn not supported');
        return false;
    }

    // Show loading state
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<span uk-spinner="ratio: 0.6"></span> Connecting...';

    try {
        console.log('📡 Step 1: Fetching authentication options...');
        showNotification('Preparing passkey authentication...', 'primary');
        
        // Step 1: Get authentication options from server (no email needed)
        const optionsResponse = await fetch('/passkey/discoverable-options', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Accept': 'application/json',
            },
        });

        console.log('📡 Response status:', optionsResponse.status);

        if (!optionsResponse.ok) {
            const errorText = await optionsResponse.text();
            console.error('❌ Server error:', errorText);
            throw new Error('Failed to get authentication options from server');
        }

        const options = await optionsResponse.json();
        console.log('✅ Received options:', options);

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

        console.log('🔑 Step 2: Prepared WebAuthn options:', {
            rpId: options.rpId,
            timeout: options.timeout,
            userVerification: options.userVerification
        });

        // Update button state
        button.innerHTML = '<span uk-spinner="ratio: 0.6"></span> Use your passkey...';

        // Step 3: Get credential from authenticator
        console.log('👆 Step 3: Requesting credential from authenticator...');
        showNotification('Please use your passkey to sign in...', 'primary');
        
        const credential = await navigator.credentials.get({
            publicKey: publicKeyCredentialRequestOptions
        });

        console.log('✅ Credential received:', credential);

        if (!credential) {
            throw new Error('No credential received from authenticator');
        }

        // Update button state
        button.innerHTML = '<span uk-spinner="ratio: 0.6"></span> Verifying...';

        // Step 4: Prepare credential data for server verification
        const credentialData = {
            credential_id: arrayBufferToBase64(credential.rawId),
            authenticator_data: arrayBufferToBase64(credential.response.authenticatorData),
            client_data_json: arrayBufferToBase64(credential.response.clientDataJSON),
            signature: arrayBufferToBase64(credential.response.signature),
            user_handle: credential.response.userHandle ? arrayBufferToBase64(credential.response.userHandle) : null,
        };

        console.log('📤 Step 4: Sending credential data to server...', {
            credential_id: credentialData.credential_id.substring(0, 20) + '...',
            has_user_handle: !!credentialData.user_handle
        });

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

        console.log('📡 Verify response status:', verifyResponse.status);

        const result = await verifyResponse.json();
        console.log('📥 Verification result:', result);

        if (result.success) {
            showNotification(`Welcome back, ${result.user.name}! Redirecting...`, 'success');
            button.innerHTML = '<i class="fas fa-check uk-margin-small-right"></i>Success!';
            
            console.log('✅ Authentication successful! Redirecting to:', result.redirect);
            
            setTimeout(() => {
                window.location.href = result.redirect;
            }, 1000);
            return true;
        } else {
            throw new Error(result.message || 'Authentication failed');
        }

    } catch (error) {
        console.error('❌ Passkey authentication error:', error);
        console.error('Error details:', {
            name: error.name,
            message: error.message,
            stack: error.stack
        });
        
        // Reset button
        button.disabled = false;
        button.innerHTML = originalHTML;
        
        if (error.name === 'NotAllowedError') {
            showNotification('Authentication cancelled or not allowed', 'danger');
            console.log('ℹ️ User cancelled the authentication');
        } else if (error.name === 'InvalidStateError') {
            showNotification('No passkeys found for this site. Please register a passkey first.', 'warning');
            console.log('ℹ️ No passkeys registered for this domain');
        } else if (error.name === 'NotSupportedError') {
            showNotification('Passkeys not supported on this device', 'danger');
            console.log('❌ WebAuthn not supported');
        } else if (error.name === 'SecurityError') {
            showNotification('Security error. Make sure you\'re using HTTPS (or localhost).', 'danger');
            console.error('❌ Security error - check HTTPS');
        } else if (error.name === 'AbortError') {
            showNotification('Authentication timeout. Please try again.', 'warning');
            console.log('⏱️ Authentication timed out');
        } else {
            showNotification(error.message || 'Failed to authenticate with passkey. Please try password login.', 'danger');
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
    console.log(`📢 Notification (${status}):`, message);
    
    if (typeof UIkit !== 'undefined' && UIkit.notification) {
        UIkit.notification({
            message: message,
            status: status,
            pos: 'top-center',
            timeout: 5000
        });
    } else {
        // Fallback to alert if UIkit is not loaded
        console.warn('⚠️ UIkit not loaded, using alert fallback');
        alert(message);
    }
}

// Check WebAuthn support on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Passkey auth script loaded');
    console.log('WebAuthn support:', !!window.PublicKeyCredential);
    
    const discoverableSection = document.getElementById('discoverablePasskeySection');
    
    if (discoverableSection) {
        // Hide passkey button if WebAuthn is not supported
        if (!window.PublicKeyCredential) {
            console.warn('⚠️ WebAuthn not supported - hiding passkey button');
            discoverableSection.style.display = 'none';
            showNotification('Passkeys are not supported on this browser. Please use password login.', 'warning');
        } else {
            console.log('✅ Passkey button visible - WebAuthn supported');
            
            // Check if platform authenticator is available
            if (PublicKeyCredential.isUserVerifyingPlatformAuthenticatorAvailable) {
                PublicKeyCredential.isUserVerifyingPlatformAuthenticatorAvailable()
                    .then(available => {
                        console.log('Platform authenticator available:', available);
                        if (!available) {
                            console.warn('⚠️ No platform authenticator detected');
                        }
                    })
                    .catch(err => console.error('Error checking authenticator:', err));
            }
        }
    } else {
        console.warn('⚠️ Discoverable passkey section not found in DOM');
    }
});
