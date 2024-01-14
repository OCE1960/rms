<?php

namespace App\Providers;

use App\Models\Role;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('Admin', function ($user) {
            $admin =  Role::where('role', 'Admin')->first();
            return $user->roles()->where('user_id', $user->id)->where('role_id', $admin->id)->first();
        });

        Gate::define('Manager', function ($user) {
            $manager =  Role::where('role', 'Manager')->first();
            return $user->roles()->where('user_id', $user->id)->where('role_id', $manager->id)->first();
        });

        Gate::define('Staff', function ($user) {
            $staff =  Role::where('role', 'Staff')->first();
            return $user->roles()->where('user_id', $user->id)->where('role_id', $staff->id)->first();
        });
    }
}
