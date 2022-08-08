<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user, $role) {
            if($user->hasRole(getModelFromRoleName('admin'))){
                return true;
            }
            if($user->hasRole(getModelFromRoleName('teacher'))){
                if($role == getModelFromRoleName('student')){
                    return true;
                }
            }else{
                return false;
            }
            return false;
        });
        Gate::define('see-user', [RolePolicy::class, 'seeUser']);

    }
}
