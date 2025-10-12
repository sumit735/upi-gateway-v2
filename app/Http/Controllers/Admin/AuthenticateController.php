<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserSession;
use PragmaRX\Google2FA\Google2FA;

class AuthenticateController extends Controller
{
    // Show register page
    public function index()
    {
        return view('admin.register'); // resources/views/admin/register.blade.php
    }

    // Show login page
    public function loginPage()
    {
        return view('admin.login'); // resources/views/admin/login.blade.php
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email:rfc,dns|unique:users',
            'phone'    => ['required','regex:/^[6-9]\d{9}$/','unique:users,phone'],
            'aadhaar'  => ['required','digits:12','unique:users,aadhaar'],
            'pancard'  => ['required','regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/','unique:users,pancard'],
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:255',
            'district'     => 'required|string|max:255',
            'state'        => 'required|string|max:255',
            'pincode'      => 'required|digits:6',
        ]);
        

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'aadhaar'  => $request->aadhaar,
            'pancard'  => $request->pancard,
            'password' => Hash::make($request->password),
        ]);
        $userDetail = UserDetail::create([
            'user_id'      => $user->id,
            'company_name' => $request->company_name,
            'district'     => $request->district,
            'state'        => $request->state,
            'pincode'      => $request->pincode,
        ]);
        Auth::login($user); // auto login after registration

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }
    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Find user first
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // Increment invalid login attempts
            if ($user) {
                $user->increment('invalid_attempts');
                
                // Block user after 5 failed attempts
                if ($user->invalid_attempts >= 5) {
                    $user->update(['is_blocked' => true]);
                    return back()->withErrors(['email' => 'Too many failed attempts. Your account has been blocked.']);
                }
            }
            
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // Check if user is blocked
        if ($user->is_blocked) {
            return back()->withErrors(['email' => 'Your account has been blocked. Contact administrator.']);
        }

        if (!$user->is_active) {
            return back()->withErrors(['email' => 'Your account is inactive. Contact administrator.']);
        }

        // Reset invalid attempts on successful login
        $user->update(['invalid_attempts' => 0]);

        // Check if user has 2FA enabled
        if ($user->two_factor_enabled && $user->two_factor_secret) {
            // Store user ID in session temporarily for 2FA verification
            session([
                'two_factor_auth_id' => $user->id,
                'two_factor_remember' => $request->remember ? true : false,
            ]);

            return redirect()->route('two-factor.challenge');
        }

        // Login user directly if no 2FA
        Auth::login($user, $request->remember);

        // Cache user permissions in session
        $this->cacheUserPermissions($user);

        // Maintain user_sessions mapping for immediate invalidation
        try {
            UserSession::updateOrCreate([
                'session_id' => session()->getId(),
            ], [
                'user_id' => $user->id,
                'ip' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 1000),
                'last_activity' => now(),
            ]);
        } catch (\Exception $e) {
            // don't block login if mapping fails; log or ignore
        }

        return redirect()->route('dashboard')->with('success', 'Login successful!');
    }

    /**
     * Cache user permissions in session
     *
     * @param User $user
     * @return void
     */
    protected function cacheUserPermissions(User $user): void
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

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear permissions cache
        session()->forget('user_permissions');

        // Remove user_sessions mapping
        try {
            UserSession::where('session_id', session()->getId())->delete();
        } catch (\Exception $e) {
            // ignore
        }

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    /**
     * Extend user session (for activity tracking)
     */
    public function extendSession(Request $request)
    {
        if (Auth::check()) {
            // Update last activity
            try {
                UserSession::where('session_id', session()->getId())
                    ->update(['last_activity' => now()]);
            } catch (\Exception $e) {
                // ignore
            }

            return response()->json([
                'success' => true,
                'message' => 'Session extended',
                'expires_in' => config('session.lifetime') * 60 // in seconds
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Not authenticated'
        ], 401);
    }

    /**
     * Show two-factor challenge page
     */
    public function showTwoFactorChallenge()
    {
        if (!session()->has('two_factor_auth_id')) {
            return redirect()->route('login');
        }

        return view('admin.two-factor-challenge');
    }

    /**
     * Verify two-factor authentication code
     */
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = session('two_factor_auth_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please login again.']);
        }

        $user = User::find($userId);
        if (!$user || !$user->two_factor_enabled || !$user->two_factor_secret) {
            session()->forget('two_factor_auth_id');
            return redirect()->route('login')->withErrors(['email' => 'Two-factor authentication is not properly configured.']);
        }

        $google2fa = new Google2FA();
        $secret = decrypt($user->two_factor_secret);
        $valid = $google2fa->verifyKey($secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid verification code. Please try again.']);
        }

        // Login successful
        $this->completeLogin($user, $request);

        return redirect()->route('dashboard')->with('success', 'Login successful!');
    }

    /**
     * Verify two-factor authentication using recovery code
     */
    public function verifyTwoFactorRecovery(Request $request)
    {
        $request->validate([
            'recovery_code' => 'required|string',
        ]);

        $userId = session('two_factor_auth_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please login again.']);
        }

        $user = User::find($userId);
        if (!$user || !$user->two_factor_enabled) {
            session()->forget('two_factor_auth_id');
            return redirect()->route('login')->withErrors(['email' => 'Two-factor authentication is not properly configured.']);
        }

        // Find unused recovery code
        $recoveryCode = $user->twoFactorRecoveryCodes()
            ->where('used_at', null)
            ->get()
            ->first(function ($code) use ($request) {
                return decrypt($code->code) === strtoupper($request->recovery_code);
            });

        if (!$recoveryCode) {
            return back()->withErrors(['recovery_code' => 'Invalid or already used recovery code.']);
        }

        // Mark recovery code as used
        $recoveryCode->update([
            'used' => true,
            'used_at' => now(),
        ]);

        // Login successful
        $this->completeLogin($user, $request);

        return redirect()->route('dashboard')
            ->with('warning', 'Login successful! You used a recovery code. Please generate new recovery codes from your profile.');
    }

    /**
     * Complete the login process
     */
    protected function completeLogin(User $user, Request $request)
    {
        $remember = session('two_factor_remember', false);
        
        // Clear 2FA session data
        session()->forget(['two_factor_auth_id', 'two_factor_remember']);

        // Login user
        Auth::login($user, $remember);

        // Cache user permissions in session
        $this->cacheUserPermissions($user);

        // Maintain user_sessions mapping for immediate invalidation
        try {
            UserSession::updateOrCreate([
                'session_id' => session()->getId(),
            ], [
                'user_id' => $user->id,
                'ip' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 1000),
                'last_activity' => now(),
            ]);
        } catch (\Exception $e) {
            // don't block login if mapping fails; log or ignore
        }
    }
}
