<?php

use App\Http\Controllers\Admin\AuthenticateController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard')->middleware('admin');

Route::get('/', function () {
    return view('frontend.index');
})->name('home');
Route::get('/reg', function () {
    return view('admin.forgot-password-email');
})->name('home');

Route::get('/login', [AuthenticateController::class, 'loginPage'])->name('login');
Route::get('/register', [AuthenticateController::class, 'index'])->name('register');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register.submit');

Route::get('/logout', [AuthenticateController::class, 'logout'])->name('logout');




// Forgot Password Routes
Route::prefix('admin')->group(function() {
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('admin.forgot.password.form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('admin.forgot.password.send');


Route::get('/validate-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('admin.otp.form');
Route::post('/validate-otp', [ForgotPasswordController::class, 'validateOtp'])->name('admin.otp.validate');


Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('admin.reset.password.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('admin.reset.password');
});