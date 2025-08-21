<?php

namespace App\Providers;

use App\Http\Repositories\ActiveLogRepositories;
use App\Http\Repositories\ActiveLogRepositoriesInterface;
use App\Http\Repositories\BaseRepositories;
use App\Http\Repositories\BaseRepositoriesInterface;
use App\Http\Repositories\FileRepositories;
use App\Http\Repositories\FileRepositoriesInterface;
use App\Http\Repositories\UserRepositories;
use App\Http\Repositories\UserRepositoriesInterface;
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
        $this->app->bind(BaseRepositoriesInterface::class, BaseRepositories::class);
        $this->app->bind(FileRepositoriesInterface::class, FileRepositories::class);
        $this->app->bind(UserRepositoriesInterface::class, UserRepositories::class);
        $this->app->bind(ActiveLogRepositoriesInterface::class, ActiveLogRepositories::class);
    }
}
