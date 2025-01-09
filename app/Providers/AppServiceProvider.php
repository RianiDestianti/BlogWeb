<?php

namespace App\Providers;

use App\Models\Post; // Assuming the Post model is in the App\Models namespace
use App\Policies\PostPolicy; // Correct namespace
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Post::class, PostPolicy::class); 
    }
}