<?php

use App\Http\Controllers\Admin\AuthenticateController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

// guest / open routes

Route::get('/', function () {
    return view('frontend.index');
})->name('home');


Route::get('/login', [AuthenticateController::class, 'loginPage'])->name('login');
Route::get('/register', [AuthenticateController::class, 'index'])->name('register');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register.submit');

Route::get('/logout', [AuthenticateController::class, 'logout'])->name('logout');

Route::get('/template', function () {
    return file_get_contents(public_path('template/index.html'));
});


// Forgot Password Routes
Route::prefix('admin')->group(function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('admin.forgot.password.form');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('admin.forgot.password.send');


    Route::get('/validate-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('admin.otp.form');
    Route::post('/validate-otp', [ForgotPasswordController::class, 'validateOtp'])->name('admin.otp.validate');


    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('admin.reset.password.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('admin.reset.password');
    Route::get('/userdetails', [ForgotPasswordController::class, 'showUserForm'])->name('admin.userdetails.form');
    Route::post('/reset-userdetails', [ForgotPasswordController::class, 'validateDetails'])->name('admin.userdetails.validate');
    Route::get('/userdetails', [ForgotPasswordController::class, 'showUserForm'])->name('admin.userdetails.form');

    
});

// Portal Routes (Authenticated)
Route::prefix('portal')->group(function () {
    require __DIR__.'/portal.php';
});
