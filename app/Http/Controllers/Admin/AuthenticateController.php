<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'aadhaar'  => $request->aadhaar,
            'pancard'  => $request->pancard,
            'password' => Hash::make($request->password),
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
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
