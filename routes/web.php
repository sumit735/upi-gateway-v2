<?php

use App\Http\Controllers\Admin\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard')->middleware('admin');

Route::get('/', function () {
    return view('frontend.index');
})->name('home');

Route::get('/login', [AuthenticateController::class, 'loginPage'])->name('login');
Route::get('/register', [AuthenticateController::class, 'index'])->name('register');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register.submit');

Route::get('/logout', [AuthenticateController::class, 'logout'])->name('logout');