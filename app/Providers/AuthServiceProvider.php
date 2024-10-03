<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('is-admin', function (User $user) {
            return $user->roles()->where('name', 'admin')->exists();
        });

        Gate::define('is-participante', function (User $user) {
            return $user->roles()->where('name', 'participante')->exists();
        });

        Gate::define('is-super-admin', function (User $user) {
            return in_array($user->email, config('acl.super_admins'));
        });

        Gate::before(function (User $user) {
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}
