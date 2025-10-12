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

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            $user = Auth::user();

            // Check if user is blocked
            if ($user->is_blocked) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been blocked. Contact administrator.']);
            }
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is inactive. Contact administrator.']);
            }

            // Reset invalid attempts on successful login
            $user->update(['invalid_attempts' => 0]);

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

        // Increment invalid login attempts
        $user = User::where('email', $request->email)->first();
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
}
