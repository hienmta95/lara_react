<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(
            'App\Repositories\Category\CategoryRepositoryInterface',
            'App\Repositories\Category\CategoryRepository'
        );
        $this->app->bind(
            'App\Repositories\User\UserRepositoryInterface',
            'App\Repositories\User\UserRepository'
        );
        $this->app->bind(
            'App\Repositories\Post\PostRepositoryInterface',
            'App\Repositories\Post\PostRepository'
        );
    }
}
