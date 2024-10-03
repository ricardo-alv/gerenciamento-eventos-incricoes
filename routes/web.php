<?php

use App\Http\Controllers\Admin\{
    CategoryController,
    DashboardController,
    EventController,
    UserController
};

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        /** EVENTS */
        Route::any('events/search', [EventController::class, 'search'])->name('events.search');
        Route::resource('events', EventController::class);

        /** CATEGORIES */
        Route::any('categories/search', [CategoryController::class, 'search'])->name('categories.search');
        Route::resource('categories', CategoryController::class);

        /** DASHBOARD */
        Route::any('dashboard/search', [DashboardController::class, 'search'])->name('dashboard.search');
        Route::resource('dashboard', DashboardController::class);

        /** USERS */
        Route::any('users/search', [UserController::class, 'search'])->name('users.search');
        Route::resource('users', UserController::class);
    });

require __DIR__ . '/auth.php';
