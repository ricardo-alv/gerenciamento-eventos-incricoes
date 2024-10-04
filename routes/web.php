<?php

use App\Http\Controllers\Admin\{
    CategoryController,
    DashboardController,
    EventController,
    RegistrationController,
    UserController
};

use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::any('dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        /** REGISTRATION */
        Route::any('registrations/search', [RegistrationController::class, 'search'])->name('registrations.search');
        Route::resource('registrations', RegistrationController::class);

        /** EVENTS */
        Route::any('events/search', [EventController::class, 'search'])->name('events.search');
        Route::resource('events', EventController::class);

        /** CATEGORIES */
        Route::any('categories/search', [CategoryController::class, 'search'])->name('categories.search');
        Route::resource('categories', CategoryController::class);

        /** USERS */
        Route::any('users/search', [UserController::class, 'search'])->name('users.search');
        Route::resource('users', UserController::class);

        /** DASHBOARD */
        Route::resource('dashboard', DashboardController::class);
    });

require __DIR__ . '/auth.php';
