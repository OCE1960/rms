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

        Gate::define('student', function ($user) {
            return $user->is_student;
        });

        Gate::define('result-enquirer', function ($user) {
            return $user->is_result_enquirer;
        });

        Gate::define('Super Admin', function ($user) {
            $superAdmin =  Role::where('key', 'super-admin')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $superAdmin->id)->first();
        });

        Gate::define('Result Compiler', function ($user) {
            $resultCompiler =  Role::where('key', 'result-compiling-officer')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $resultCompiler->id)->first();
        });

        Gate::define('Checking Officer', function ($user) {
            $checkingOfficer =  Role::where('key', 'checking-officer')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $checkingOfficer->id)->first();
        });

        Gate::define('Registry', function ($user) {
            $registry =  Role::where('key', 'registry')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $registry->id)->first();
        });

        Gate::define('Recommending Officer', function ($user) {
            $recommendingOfficer =  Role::where('key', 'recommending-officer')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $recommendingOfficer->id)->first();
        });

        Gate::define('Approving Officer', function ($user) {
            $approvingOfficer =  Role::where('key', 'approving-officer')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $approvingOfficer->id)->first();
        });

        Gate::define('School Admin', function ($user) {
            $schoolAdmin =  Role::where('key', 'school-admin')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $schoolAdmin->id)->first();
        });

        Gate::define('Result Uploader', function ($user) {
            $resultUploader =  Role::where('key', 'result-uploader')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $resultUploader->id)->first();
        });

        Gate::define('Dispatching Officer', function ($user) {
            $dispatchingOfficer =  Role::where('key', 'dispatching-officer')->first();

            return $user->roles()->where('user_id', $user->id)->where('role_id', $dispatchingOfficer->id)->first();
        });
    }
}
