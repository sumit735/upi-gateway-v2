<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Mail\PasswordOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class ForgotPasswordController extends Controller
{
    // Show email input form
    public function showForgotForm()
    {
        return view('admin.forgot-password-email');
    }


    // Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);


        $existing = DB::table('password_resets')->where('email', $request->email)->first();
        if ($existing && $existing->created_at && Carbon::parse($existing->created_at)->gt(Carbon::now()->subMinute())) {
            return back()->withErrors(['email' => 'OTP recently sent. Please wait a minute and try again.']);
        }


       // $otp = random_int(100000, 999999);
     $otp = 123456;

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'otp_expires_at' => Carbon::now()->addMinutes(10), 'created_at' => Carbon::now()]
        );


        Mail::to($request->email)->send(new PasswordOtpMail($otp));


        return redirect()->route('admin.otp.form')->with('status', 'OTP sent to your email.');
    }


    // Show OTP input form
    public function showOtpForm()
    {
        return view('admin.validate-otp');
    }


    // Validate OTP
    public function validateOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'otp'   => 'required|digits:6'
    ]);

    $record = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('otp', $request->otp)
        ->where('otp_expires_at', '>', Carbon::now())
        ->first();

    if (!$record) {
        // Track wrong attempts
        $attempts = session()->get('otp_attempts', 0) + 1;
        session(['otp_attempts' => $attempts]);

        if ($attempts >= 3) {
            // Destroy session after 3 wrong tries
            session()->forget('otp_attempts');
            session()->forget('admin_password_reset_email');

            return redirect()->route('admin.forgot.password.form')
                ->withErrors(['otp' => 'Too many failed attempts. Please request a new OTP.']);
        }

        return back()->withErrors([
            'otp' => 'Invalid or expired OTP. Attempt ' . $attempts . ' of 3'
        ])->withInput();
    }

    // If OTP correct → clear attempts
    session()->forget('otp_attempts');

    session(['admin_password_reset_email' => $request->email]);
    return redirect()->route('admin.reset.password.form');
}


    // Show reset password form (after OTP validation)
    public function showResetForm()
    {
        
        return view('admin.reset-password');
    }


    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate(['password' => 'required|confirmed|min:6']);


            return redirect()->route('admin.forgot.password.form');
        
        }
    

    public function showUserForm()
    {
        return view('admin.forgot-password-user-details');
    }

       public function validateDetails(Request $request)
    {
        // Step 1: Validate inputs
        $request->validate([
            'phone'   => ['required', 'regex:/^[6-9]\d{9}$/'],
            'pancard' => ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'aadhaar' => ['required', 'digits:12'],
        ]);

        // Step 2: Check user in DB
        $user = User::where('phone', $request->phone)
            ->where('pancard', $request->pancard)
            ->where('aadhaar', $request->aadhaar)
            ->first();

        // Step 3: Return response
        if ($user) {
            // ✅ User matched
            return redirect()->route('admin.reset.password.form')
                ->with('success', 'User verified successfully. Please reset your password.');
        } else {
            // ❌ User not found
            return back()->withErrors(['User details do not match our records.'])->withInput();
        }
    }
}