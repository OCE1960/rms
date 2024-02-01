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

        Gate::define('Super Admin', function ($user) {
            $superAdmin =  Role::where('key', 'super-admin')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $superAdmin->id)->first();
        });

        Gate::define('Result Compiler', function ($user) {
            $resultCompiler =  Role::where('key', 'result-compiler')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $resultCompiler->id)->first();
        });

        Gate::define('Checking Officer', function ($user) {
            $checkingOfficer =  Role::where('key', 'checking-officer')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $checkingOfficer->id)->first();
        });
    }
}
