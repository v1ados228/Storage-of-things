<?php

namespace App\Providers;

use App\Models\Place;
use App\Models\Thing;
use App\Policies\PlacePolicy;
use App\Policies\ThingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Thing::class => ThingPolicy::class,
        Place::class => PlacePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin-panel', function ($user) {
            return $user->isAdmin();
        });

    }
}
