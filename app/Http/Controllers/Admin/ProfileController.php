<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passkey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = Auth::user();

        // Delete old photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        
        $user->update(['profile_photo' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Profile photo updated successfully!',
            'photo_url' => Storage::url($path)
        ]);
    }

    /**
     * Delete profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
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
     * Register a new passkey.
     */
    public function registerPasskey(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'credential_id' => ['required', 'string', 'unique:passkeys,credential_id'],
            'public_key' => ['required', 'string'],
            'aaguid' => ['nullable', 'string'],
            'transports' => ['nullable', 'array'],
        ]);

        $passkey = Auth::user()->passkeys()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Passkey registered successfully!',
            'passkey' => $passkey,
        ]);
    }

    /**
     * Delete a passkey.
     */
    public function deletePasskey($id)
    {
        $passkey = Auth::user()->passkeys()->findOrFail($id);
        $passkey->delete();

        return response()->json([
            'success' => true,
            'message' => 'Passkey deleted successfully!'
        ]);
    }
}
