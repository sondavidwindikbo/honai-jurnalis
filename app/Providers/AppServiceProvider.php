<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\User;
use App\Observers\ArticleObserver;
use App\Policies\ArticlePolicy;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {

        // Observer
        Article::observe(ArticleObserver::class);

        // Policy
        Gate::policy(Article::class, ArticlePolicy::class);
        Gate::policy(\App\Models\Comment::class, CommentPolicy::class);
        Gate::policy(User::class, UserPolicy::class);


    }
}
