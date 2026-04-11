<?php

namespace App\Providers;

use App\Repositories\Post\PostEloquentRepository;
use App\Repositories\Post\PostRepositoryContract;
use App\Repositories\Tag\TagEloquentRepository;
use App\Repositories\Tag\TagRepositoryContract;
use App\Services\Post\PostService;
use App\Services\Post\PostServiceContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repos
        $this->app->bind(PostRepositoryContract::class, PostEloquentRepository::class);
        $this->app->bind(TagRepositoryContract::class, TagEloquentRepository::class);
        // Services
        $this->app->bind(PostServiceContract::class, PostService::class);
    }

    public function boot(): void
    {
        //
    }
}
