<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PortalController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DevController;

use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use App\Enums\ScopeEnum;

// authenticated routes
Route::middleware(['auth'])->group(function () {

    // ================================
    // Internal Developer Routes (Local/Dev Only)
    // ================================
    if (app()->environment(['local', 'development'])) {
        Route::prefix('dev')->name('dev.')->group(function () {
            Route::get('/', [DevController::class, 'index'])->name('index');
            Route::post('/sync-pages', [DevController::class, 'syncPages'])->name('sync-pages');
            Route::post('/sync-actions', [DevController::class, 'syncActions'])->name('sync-actions');
            Route::post('/sync-all', [DevController::class, 'syncAll'])->name('sync-all');
            Route::get('/state', [DevController::class, 'getState'])->name('state');
        });
    }

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

    Route::get('/roles/{role}', [RoleController::class, 'show'])
        ->name('admin.roles.show')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::VIEW, ScopeEnum::ALL));

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
    Route::get('/users', [UserController::class, 'index'])
        ->name('admin.users.index')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::VIEW, ScopeEnum::ALL));

    // Get users list for DataTable (API) - Using POST to avoid long URLs
    Route::post('/users/list/data', [UserController::class, 'list'])
        ->name('admin.users.list')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::VIEW, ScopeEnum::ALL));

    // Create new user
    Route::get('/users/create', [UserController::class, 'create'])
        ->name('admin.users.create')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::CREATE, ScopeEnum::ALL));

    Route::post('/users', [UserController::class, 'store'])
        ->name('admin.users.store')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::CREATE, ScopeEnum::ALL));

    // Edit user
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('admin.users.edit')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::EDIT, ScopeEnum::ALL));

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::EDIT, ScopeEnum::ALL));

    // Toggle user status
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('admin.users.toggleStatus')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::EDIT, ScopeEnum::ALL));

    // Delete user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy')
        ->middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::DELETE, ScopeEnum::ALL));


    // ================================
    // Profile Routes (Own Profile Only)
    // ================================

    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::VIEW, ScopeEnum::SELF));

    // Profile management
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])
        ->name('profile.updateProfile')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])
        ->name('profile.uploadPhoto')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])
        ->name('profile.deletePhoto')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.updatePassword')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    // Two-factor authentication
    Route::post('/profile/two-factor/enable', [ProfileController::class, 'enableTwoFactor'])
        ->name('profile.enableTwoFactor')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    Route::post('/profile/two-factor/confirm', [ProfileController::class, 'confirmTwoFactor'])
        ->name('profile.confirmTwoFactor')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    Route::post('/profile/two-factor/disable', [ProfileController::class, 'disableTwoFactor'])
        ->name('profile.disableTwoFactor')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    Route::get('/profile/two-factor/recovery-codes', [ProfileController::class, 'getRecoveryCodes'])
        ->name('profile.getRecoveryCodes')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::VIEW, ScopeEnum::SELF));

    Route::post('/profile/two-factor/recovery-codes', [ProfileController::class, 'regenerateRecoveryCodes'])
        ->name('profile.regenerateRecoveryCodes')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    // Passkeys
    Route::get('/profile/passkeys/register-options', [ProfileController::class, 'getPasskeyRegistrationOptions'])
        ->name('profile.passkey.registerOptions')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    Route::post('/profile/passkeys', [ProfileController::class, 'registerPasskey'])
        ->name('profile.registerPasskey')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));

    Route::delete('/profile/passkeys/{id}', [ProfileController::class, 'deletePasskey'])
        ->name('profile.deletePasskey')
        ->middleware(permission(PageEnum::PROFILE, ActionEnum::EDIT, ScopeEnum::SELF));


    // ================================
    // Grouped Routes Example
    // ================================

    Route::middleware(permission(PageEnum::USER_MANAGEMENT, ActionEnum::VIEW, ScopeEnum::ALL))->group(function () {
        Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/users/{user}/details', [UserController::class, 'details'])->name('admin.users.details');
    });

    // settings routes
    Route::middleware(permission(PageEnum::SETTINGS, ActionEnum::VIEW, ScopeEnum::ALL))->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings/update', [SettingsController::class, 'update'])->name('admin.settings.update');
    });

    // ================================
    // Subscription Management Routes
    // ================================
    Route::prefix('subscriptions')->name('admin.settings.subscriptions.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SubscriptionController::class, 'index'])
            ->name('index')
            ->middleware(permission(PageEnum::SUBSCRIPTIONS, ActionEnum::VIEW, ScopeEnum::ALL));

        Route::post('/list/data', [\App\Http\Controllers\Admin\SubscriptionController::class, 'list'])
            ->name('list')
            ->middleware(permission(PageEnum::SUBSCRIPTIONS, ActionEnum::VIEW, ScopeEnum::ALL));

        Route::get('/{subscription}', [\App\Http\Controllers\Admin\SubscriptionController::class, 'show'])
            ->name('show')
            ->middleware(permission(PageEnum::SUBSCRIPTIONS, ActionEnum::VIEW, ScopeEnum::ALL));

        Route::post('/', [\App\Http\Controllers\Admin\SubscriptionController::class, 'store'])
            ->name('store')
            ->middleware(permission(PageEnum::SUBSCRIPTIONS, ActionEnum::CREATE, ScopeEnum::ALL));

        Route::put('/{subscription}', [\App\Http\Controllers\Admin\SubscriptionController::class, 'update'])
            ->name('update')
            ->middleware(permission(PageEnum::SUBSCRIPTIONS, ActionEnum::EDIT, ScopeEnum::ALL));

        Route::post('/{subscription}/toggle-status', [\App\Http\Controllers\Admin\SubscriptionController::class, 'toggleStatus'])
            ->name('toggleStatus')
            ->middleware(permission(PageEnum::SUBSCRIPTIONS, ActionEnum::EDIT, ScopeEnum::ALL));

        Route::post('/{subscription}/toggle-popular', [\App\Http\Controllers\Admin\SubscriptionController::class, 'togglePopular'])
            ->name('togglePopular')
            ->middleware(permission(PageEnum::SUBSCRIPTIONS, ActionEnum::EDIT, ScopeEnum::ALL));

        Route::delete('/{subscription}', [\App\Http\Controllers\Admin\SubscriptionController::class, 'destroy'])
            ->name('destroy')
            ->middleware(permission(PageEnum::SUBSCRIPTIONS, ActionEnum::DELETE, ScopeEnum::ALL));
    });

    // ================================
    // Ticket Management Routes (Admin)
    // ================================
    Route::prefix('tickets')->name('admin.tickets.')->group(function () {
        // Ticket Categories Management
        Route::get('/categories', [\App\Http\Controllers\Admin\TicketCategoryController::class, 'index'])
            ->name('categories.index')
            ->middleware(permission(PageEnum::SETTINGS, ActionEnum::VIEW, ScopeEnum::ALL));

        Route::post('/categories', [\App\Http\Controllers\Admin\TicketCategoryController::class, 'store'])
            ->name('categories.store')
            ->middleware(permission(PageEnum::SETTINGS, ActionEnum::CREATE, ScopeEnum::ALL));

        Route::put('/categories/{ticketCategory}', [\App\Http\Controllers\Admin\TicketCategoryController::class, 'update'])
            ->name('categories.update')
            ->middleware(permission(PageEnum::SETTINGS, ActionEnum::EDIT, ScopeEnum::ALL));

        Route::delete('/categories/{ticketCategory}', [\App\Http\Controllers\Admin\TicketCategoryController::class, 'destroy'])
            ->name('categories.destroy')
            ->middleware(permission(PageEnum::SETTINGS, ActionEnum::DELETE, ScopeEnum::ALL));

        // Ticket Management
        
        Route::get('/', [\App\Http\Controllers\Admin\TicketManagementController::class, 'index'])
        ->name('index')
        ->middleware(permission(PageEnum::TICKETS, ActionEnum::VIEW));
        
        Route::get('/create', [\App\Http\Controllers\Admin\TicketManagementController::class, 'createIndex'])
            ->name('create')
            ->middleware(permission(PageEnum::TICKETS, ActionEnum::CREATE, ScopeEnum::SELF));
        
        Route::post('/create', [\App\Http\Controllers\Admin\TicketManagementController::class, 'store'])
            ->name('store')
            ->middleware(permission(PageEnum::TICKETS, ActionEnum::CREATE, ScopeEnum::SELF));
        
        Route::get('/{ticket}', [\App\Http\Controllers\Admin\TicketManagementController::class, 'show'])
            ->name('show')
            ->middleware(permission(PageEnum::TICKETS, ActionEnum::VIEW, ScopeEnum::ALL));

        Route::post('/{ticket}/status', [\App\Http\Controllers\Admin\TicketManagementController::class, 'updateStatus'])
            ->name('status')
            ->middleware(permission(PageEnum::TICKETS, ActionEnum::CHANGE_STATUS, ScopeEnum::ALL));

        Route::post('/{ticket}/assign', [\App\Http\Controllers\Admin\TicketManagementController::class, 'assign'])
            ->name('assign')
            ->middleware(permission(PageEnum::TICKETS, ActionEnum::ASSIGN, ScopeEnum::ALL));

        Route::post('/{ticket}/reply', [\App\Http\Controllers\Admin\TicketManagementController::class, 'reply'])
            ->name('reply')
            ->middleware(permission(PageEnum::TICKETS, ActionEnum::REPLY, ScopeEnum::ALL));

        Route::post('/{ticket}/priority', [\App\Http\Controllers\Admin\TicketManagementController::class, 'updatePriority'])
            ->name('priority')
            ->middleware(permission(PageEnum::TICKETS, ActionEnum::CHANGE_PRIORITY, ScopeEnum::ALL));

        Route::get('/stats/dashboard', [\App\Http\Controllers\Admin\TicketManagementController::class, 'statistics'])
            ->name('statistics')
            ->middleware(permission(PageEnum::TICKETS, ActionEnum::VIEW, ScopeEnum::ALL));

    });

});