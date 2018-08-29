<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->group_id == 1;
        });
        Gate::define('architect', function ($user) {
            return $user->group_id == 2;
        });
        Gate::define('client', function ($user) {
            return $user->group_id == 3;
        });
        Gate::define('edit-project', function ($user, $project) {
            return $user->id == $project->user_id || $user->group_id == 1;
        });
    }
}
