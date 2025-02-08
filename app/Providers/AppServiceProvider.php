<?php

namespace App\Providers;

use App\Contracts\CacheRepositoryContract;
use App\Contracts\FileRepositoryContract;
use App\Repositories\CacheRepository;
use App\Repositories\FileRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //связываем контракты с репозиториями
        $this->app->bind(CacheRepositoryContract::class, CacheRepository::class);
        $this->app->bind(FileRepositoryContract::class, FileRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
