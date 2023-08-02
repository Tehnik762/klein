<?php

namespace App\Providers;

use App\Models\Advert;
use App\Models\User;
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

        Gate::define('admin-panel', function(User $user){
            return $user->isAdmin();
        });

        Gate::define('moderate', function(User $user){
            return $user->isAdmin() OR $user->isModerator();
        });

        Gate::define('show-advert', function(User $user, Advert $advert) {
            return $user->isAdmin() || $user->isModerator() || $advert->user_id == $user->id;
        });

    }
}
