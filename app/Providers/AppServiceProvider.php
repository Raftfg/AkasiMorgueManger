<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Modules\Acl\Entities\Role;
use Modules\Acl\Entities\User;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use Modules\Acl\Entities\Permission;
use App\Observers\PermissionObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void {
        if ($this->app->environment('local')) {
            
        }
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Schema::defaultStringLength(125);
        $this->bootObservers();
    }

    /**
     * Boot observers
     */
    public function bootObservers() {
        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        Permission::observe(PermissionObserver::class);
    }

}
