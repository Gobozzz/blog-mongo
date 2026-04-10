<?php

namespace App\Providers;

use App\Repositories\Post\PostEloquentRepository;
use App\Repositories\Post\PostRepositoryContract;
use App\Repositories\Tag\TagEloquentRepository;
use App\Repositories\Tag\TagRepositoryContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repos
        $this->app->bind(PostRepositoryContract::class, PostEloquentRepository::class);
        $this->app->bind(TagRepositoryContract::class, TagEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
