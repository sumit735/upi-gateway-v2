<?php

/**
 * Example Routes using Enum-based Permissions
 * 
 * This file demonstrates clean, type-safe route protection
 * using enums instead of string literals.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use App\Enums\ScopeEnum;

/*
|--------------------------------------------------------------------------
| Enum-Based Permission Routes (Type-Safe!)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function() {
    
    // ================================
    // Dashboard Routes
    // ================================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware(permission(PageEnum::DASHBOARD, ActionEnum::VIEW));

    
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
    
    Route::middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::VIEW, ScopeEnum::ALL))->group(function() {
        Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/admin/users/{user}/details', [UserController::class, 'details'])->name('admin.users.details');
    });
});


/*
|--------------------------------------------------------------------------
| Benefits of This Approach:
|--------------------------------------------------------------------------
| 
| ✅ Type-safe - No typos, IDE autocomplete
| ✅ Refactor-friendly - Change enum value once, updates everywhere
| ✅ Self-documenting - Clear what permission is being checked
| ✅ Centralized - All permissions defined in enums
| ✅ Validated - Can't use invalid page/action values
|
*/
