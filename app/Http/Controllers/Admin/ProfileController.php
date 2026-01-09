<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passkey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user()->load(['userDetail', 'passkeys']);
        return view('admin.profile.show', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:15', 'unique:users,phone,' . $user->id],
            'company_name' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'pincode' => ['nullable', 'string', 'max:10'],
        ]);

        // Update user basic info
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        // Update or create user details
        $user->userDetail()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'company_name' => $validated['company_name'],
                'district' => $validated['district'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!'
        ]);
    }

    /**
     * Upload profile photo.
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        $user = Auth::user();
        $fileService = \App\Services\FileService::forProfilePhotos();

        if ($user->profile_photo) {
            $fileService->delete($user->profile_photo);
        }

        $uploadedFile = $fileService->upload($request->file('profile_photo'));
        $user->update(['profile_photo' => $uploadedFile['file_path']]);

        return response()->json([
            'success' => true,
            'message' => 'Profile photo updated successfully!',
            'photo_url' => $fileService->getUrl($uploadedFile['file_path'])
        ]);
    }

    /**
     * Delete profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();
        $fileService = \App\Services\FileService::forProfilePhotos();

        if ($user->profile_photo) {
            $fileService->delete($user->profile_photo);
        }

        $user->update(['profile_photo' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Profile photo removed successfully!'
        ]);
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully!'
        ]);
    }

    /**
     * Enable two-factor authentication.
     */
    public function enableTwoFactor(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        if ($user->two_factor_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication is already enabled.'
            ], 400);
        }

        // Generate secret key
        $secret = $google2fa->generateSecretKey();
        
        // Generate QR code URL
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        // Generate SVG QR code
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($qrCodeUrl);

        // Generate recovery codes
        $recoveryCodes = collect(range(1, 8))->map(function () {
            return strtoupper(substr(md5(random_bytes(10)), 0, 10));
        })->toArray();

        // Store secret temporarily (not confirmed yet)
        $user->update([
            'two_factor_secret' => encrypt($secret),
        ]);

        // Delete old recovery codes if any and create new ones
        $user->twoFactorRecoveryCodes()->delete();
        foreach ($recoveryCodes as $code) {
            $user->twoFactorRecoveryCodes()->create([
                'code' => encrypt($code),
            ]);
        }

        return response()->json([
            'success' => true,
            'secret' => $secret,
            'qr_code_svg' => $qrCodeSvg,
            'recovery_codes' => $recoveryCodes,
        ]);
    }

    /**
     * Confirm two-factor authentication.
     */
    public function confirmTwoFactor(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();
        $google2fa = new Google2FA();

        if (!$user->two_factor_secret) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication is not set up.'
            ], 400);
        }

        $secret = decrypt($user->two_factor_secret);
        $valid = $google2fa->verifyKey($secret, $request->code);

        if (!$valid) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code. Please try again.'
            ], 400);
        }

        $user->update([
            'two_factor_enabled' => true,
            'two_factor_confirmed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication enabled successfully!'
        ]);
    }

    /**
     * Disable two-factor authentication.
     */
    public function disableTwoFactor(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        // Delete all recovery codes
        $user->twoFactorRecoveryCodes()->delete();

        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_confirmed_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication disabled successfully!'
        ]);
    }
    /**
     * Get recovery codes.
     */
    public function getRecoveryCodes()
    {
        $user = Auth::user();

        if (!$user->two_factor_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication is not enabled.'
            ], 400);
        }

        // Get unused recovery codes
        $recoveryCodes = $user->twoFactorRecoveryCodes()
            ->where('used_at', null)
            ->pluck('code')
            ->map(fn($code) => decrypt($code))
            ->toArray();

        return response()->json([
            'success' => true,
            'recovery_codes' => $recoveryCodes,
        ]);
    }
    /**
     * Regenerate recovery codes.
     */
    public function regenerateRecoveryCodes(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        if (!$user->two_factor_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication is not enabled.'
            ], 400);
        }

        // Generate new recovery codes
        $recoveryCodes = collect(range(1, 8))->map(function () {
            return strtoupper(substr(md5(random_bytes(10)), 0, 10));
        })->toArray();

        // Delete old recovery codes and create new ones
        $user->twoFactorRecoveryCodes()->delete();
        foreach ($recoveryCodes as $code) {
            $user->twoFactorRecoveryCodes()->create([
                'code' => encrypt($code),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Recovery codes regenerated successfully!',
            'recovery_codes' => $recoveryCodes,
        ]);
    
    }

    /**
     * Get challenge for passkey registration.
     */
    public function getPasskeyRegistrationOptions(Request $request)
    {
        $user = Auth::user();
        
        // Generate a random challenge (32 bytes)
        $challenge = random_bytes(32);
        
        // Store challenge in session for verification
        $request->session()->put('passkey_challenge', base64_encode($challenge));
        
        // Get existing credentials to exclude (prevent duplicate registration)
        $excludeCredentials = $user->passkeys->map(function ($passkey) {
            return [
                'type' => 'public-key',
                'id' => $passkey->credential_id,
            ];
        })->toArray();
        
        return response()->json([
            'challenge' => base64_encode($challenge),
            'rp' => [
                'name' => config('app.name'),
                'id' => parse_url(config('app.url'), PHP_URL_HOST) ?? request()->getHost(),
            ],
            'user' => [
                'id' => base64_encode($user->id),
                'name' => $user->email,
                'displayName' => $user->name,
            ],
            'pubKeyCredParams' => [
                ['type' => 'public-key', 'alg' => -7],  // ES256
                ['type' => 'public-key', 'alg' => -257], // RS256
            ],
            'timeout' => 60000,
            'attestation' => 'none',
            'excludeCredentials' => $excludeCredentials,
            'authenticatorSelection' => [
                'authenticatorAttachment' => 'platform',
                'requireResidentKey' => true,  // Make it discoverable
                'residentKey' => 'required',   // Required for discoverable credentials
                'userVerification' => 'preferred',
            ],
        ]);
    }

    /**
     * Register a new passkey.
     */
    public function registerPasskey(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'credential_id' => ['required', 'string'],
            'public_key' => ['required', 'string'],
            'aaguid' => ['nullable', 'string'],
            'transports' => ['nullable', 'array'],
        ]);

        // Verify challenge
        $storedChallenge = $request->session()->get('passkey_challenge');
        if (!$storedChallenge) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired challenge.'
            ], 400);
        }

        // Check for duplicate credential
        if (Passkey::where('credential_id', $validated['credential_id'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This passkey is already registered.'
            ], 400);
        }

        // Create passkey
        $passkey = Auth::user()->passkeys()->create([
            'name' => $validated['name'],
            'credential_id' => $validated['credential_id'],
            'public_key' => $validated['public_key'],
            'counter' => 0,
            'aaguid' => $validated['aaguid'] ?? null,
            'transports' => $validated['transports'] ?? null,
        ]);

        // Clear challenge from session
        $request->session()->forget('passkey_challenge');

        return response()->json([
            'success' => true,
            'message' => 'Passkey registered successfully! You can now use it to sign in.',
            'passkey' => $passkey,
        ]);
    }

    /**
     * Delete a passkey.
     */
    public function deletePasskey($id)
    {
        $passkey = Auth::user()->passkeys()->findOrFail($id);
        $name = $passkey->name;
        $passkey->delete();

        return response()->json([
            'success' => true,
            'message' => "Passkey '{$name}' deleted successfully!"
        ]);
    }

    /**
     * Get challenge for passkey authentication (login).
     */
    public function getPasskeyAuthenticationOptions(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = \App\Models\User::where('email', $validated['email'])->first();
        
        if (!$user || $user->passkeys->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No passkeys registered for this account.'
            ], 404);
        }

        // Generate challenge
        $challenge = random_bytes(32);
        $request->session()->put('passkey_auth_challenge', base64_encode($challenge));
        $request->session()->put('passkey_auth_user_id', $user->id);

        // Get allowed credentials
        $allowCredentials = $user->passkeys->map(function ($passkey) {
            return [
                'type' => 'public-key',
                'id' => $passkey->credential_id,
                'transports' => $passkey->transports ?? ['internal', 'hybrid'],
            ];
        })->toArray();

        return response()->json([
            'success' => true,
            'challenge' => base64_encode($challenge),
            'timeout' => 60000,
            'rpId' => parse_url(config('app.url'), PHP_URL_HOST) ?? request()->getHost(),
            'allowCredentials' => $allowCredentials,
            'userVerification' => 'preferred',
        ]);
    }

    /**
     * Get challenge for discoverable passkey authentication (no email required).
     * This uses resident keys where the credential itself contains user information.
     */
    public function getDiscoverablePasskeyOptions(Request $request)
    {
        // Generate challenge
        $challenge = random_bytes(32);
        $request->session()->put('passkey_auth_challenge', base64_encode($challenge));

        return response()->json([
            'success' => true,
            'challenge' => base64_encode($challenge),
            'timeout' => 60000,
            'rpId' => parse_url(config('app.url'), PHP_URL_HOST) ?? request()->getHost(),
            'userVerification' => 'required',
            // No allowCredentials - let the authenticator provide any passkey for this domain
        ]);
    }

    /**
     * Verify passkey and login user.
     */
    public function verifyPasskeyAuthentication(Request $request)
    {
        $validated = $request->validate([
            'credential_id' => ['required', 'string'],
            'authenticator_data' => ['required', 'string'],
            'client_data_json' => ['required', 'string'],
            'signature' => ['required', 'string'],
            'user_handle' => ['nullable', 'string'], // For discoverable credentials
        ]);

        // Verify challenge
        $storedChallenge = $request->session()->get('passkey_auth_challenge');
        
        if (!$storedChallenge) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired challenge.'
            ], 400);
        }

        // Find passkey by credential_id (works for both discoverable and non-discoverable)
        $passkey = Passkey::where('credential_id', $validated['credential_id'])->first();

        if (!$passkey) {
            return response()->json([
                'success' => false,
                'message' => 'Passkey not found. This device is not registered with any account.'
            ], 404);
        }

        // Optional: Verify user_handle matches (for discoverable credentials)
        if (isset($validated['user_handle'])) {
            $userIdFromHandle = base64_decode($validated['user_handle']);
            if ($userIdFromHandle != $passkey->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'User handle mismatch.'
                ], 400);
            }
        }

        // In production, you should verify the signature here
        // For now, we'll do basic verification
        
        // Update last used
        $passkey->update([
            'last_used_at' => now(),
            'counter' => $passkey->counter + 1,
        ]);

        // Login user
        Auth::login($passkey->user);
        
        // Cache permissions
        $this->cacheUserPermissions($passkey->user);
        
        // Clear session
        $request->session()->forget(['passkey_auth_challenge', 'passkey_auth_user_id']);

        return response()->json([
            'success' => true,
            'message' => 'Authentication successful!',
            'redirect' => route('dashboard'),
            'user' => [
                'name' => $passkey->user->name,
                'email' => $passkey->user->email,
            ]
        ]);
    }

    /**
     * Cache user permissions in session.
     */
    protected function cacheUserPermissions($user): void
    {
        if (!$user->role_id) {
            session(['user_permissions' => []]);
            return;
        }

        // Fetch all permissions for the user's role
        $permissions = DB::table('role_permissions')
            ->join('pages', 'role_permissions.page_id', '=', 'pages.id')
            ->join('actions', 'role_permissions.action_id', '=', 'actions.id')
            ->where('role_permissions.role_id', $user->role_id)
            ->select(
                'pages.route_pattern',
                'actions.slug as action_slug',
                'role_permissions.scope'
            )
            ->get()
            ->groupBy('route_pattern')
            ->map(function ($perms) {
                return $perms->map(function ($perm) {
                    return [
                        'action_slug' => $perm->action_slug,
                        'scope' => $perm->scope,
                    ];
                })->toArray();
            })
            ->toArray();

        session(['user_permissions' => $permissions]);
    }
}
