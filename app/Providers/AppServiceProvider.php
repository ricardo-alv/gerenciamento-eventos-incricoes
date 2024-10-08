<?php

namespace App\Providers;

use App\Models\{Category, Event, Registration};
use App\Observers\{CategoryObserver, EventObserver, RegistrationObserver};
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Category::observe(CategoryObserver::class);
        Event::observe(EventObserver::class);
        Registration::observe(RegistrationObserver::class);
    }
}
