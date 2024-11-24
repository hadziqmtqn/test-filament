<?php

namespace App\Providers;

use App\Policies\CategoryPolicy;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use App\Policies\SubCategoryPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Gate::policy(RolePolicy::class, RolePolicy::class);
        Gate::policy(PostPolicy::class, PostPolicy::class);
        Gate::policy(CategoryPolicy::class, CategoryPolicy::class);
        Gate::policy(SubCategoryPolicy::class, SubCategoryPolicy::class);
        Gate::policy(UserPolicy::class, UserPolicy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
