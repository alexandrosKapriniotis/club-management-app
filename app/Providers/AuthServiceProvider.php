<?php

namespace App\Providers;

use App\Policies\ClubPolicy;
use App\Policies\PlayerPolicy;
use App\Policies\SportMatchPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ClubPolicy::class,
        TeamPolicy::class,
        PlayerPolicy::class,
        SportMatchPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /* Use the below code to gain super admin rights app-wide */
//        Gate::before(function ($user, $ability) {
//            return $user->hasRole('admin') ? true : null;
//        });
    }
}
