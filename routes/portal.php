<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PortalController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;

use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use App\Enums\ScopeEnum;

// authenticated routes
Route::middleware(['auth'])->group(function () {

    // ================================
    // Dashboard Routes
    // ================================
    Route::get('/dashboard', [PortalController::class, 'index'])
        ->name('dashboard')
        ->middleware(permission(PageEnum::DASHBOARD, ActionEnum::VIEW));


    // ================================
    // Role Management Routes (Admin Only)
    // ================================
    Route::get('/roles', [RoleController::class, 'index'])
        ->name('admin.roles.index')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::VIEW, ScopeEnum::ALL));

    Route::get('/roles/create', [RoleController::class, 'create'])
        ->name('admin.roles.create')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::CREATE, ScopeEnum::ALL));

    Route::post('/roles', [RoleController::class, 'store'])
        ->name('admin.roles.store')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::CREATE, ScopeEnum::ALL));

    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])
        ->name('admin.roles.edit')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::EDIT, ScopeEnum::ALL));

    Route::put('/roles/{role}', [RoleController::class, 'update'])
        ->name('admin.roles.update')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::EDIT, ScopeEnum::ALL));

    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])
        ->name('admin.roles.destroy')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::DELETE, ScopeEnum::ALL));
    // ================================
    // User Management Routes (Admin Only)
    // ================================

    // View all users
    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::VIEW, ScopeEnum::ALL));

    // Create new user
    Route::get('/admin/users/create', [UserController::class, 'create'])
        ->name('admin.users.create')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::CREATE, ScopeEnum::ALL));

    Route::post('/admin/users', [UserController::class, 'store'])
        ->name('admin.users.store')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::CREATE, ScopeEnum::ALL));

    // Edit user
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])
        ->name('admin.users.edit')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::EDIT, ScopeEnum::ALL));

    Route::put('/admin/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::EDIT, ScopeEnum::ALL));

    // Delete user
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::DELETE, ScopeEnum::ALL));


    // ================================
    // Profile Routes (Own Profile Only)
    // ================================

    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::VIEW, ScopeEnum::SELF));

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));


    // ================================
    // Grouped Routes Example
    // ================================

    Route::middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::VIEW, ScopeEnum::ALL))->group(function () {
        Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/admin/users/{user}/details', [UserController::class, 'details'])->name('admin.users.details');
    });
});