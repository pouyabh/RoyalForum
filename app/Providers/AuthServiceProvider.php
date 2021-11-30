<?php

namespace App\Providers;


use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        Gate::define('user-thread', function (User $user, Thread $thread) {
            return $thread->user_id == $user->id;
        });


//        Gate::before(function ($user, $ability) {
//            return $user->hasRole('Super Admin') ? true : null;
//        });
//
    }
}
