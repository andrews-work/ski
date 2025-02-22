<?php

namespace App\Providers;

use App\Models\ForumComment;
use App\Models\ForumPost;
use App\Policies\ForumPostPolicy;
use App\Policies\ForumCommentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
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
        // Register the policy
        Gate::policy(ForumPost::class, ForumPostPolicy::class);
        Gate::policy(ForumComment::class, ForumCommentPolicy::class)
;
        // Other boot logic
        Vite::prefetch(concurrency: 3);
    }
}
