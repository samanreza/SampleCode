<?php

namespace App\Providers;

use App\Contract\Services\CustomBonusServiceInterface;
use App\Contract\Services\CustomTaskServiceInterface;
use App\Contract\Services\CustomUserServiceInterface;
use App\Contract\Services\Pipe;
use App\Services\CustomBonusService;
use App\Services\CustomTaskService;
use App\Services\CustomUserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CustomUserServiceInterface::class, CustomUserService::class);
        $this->app->bind(CustomTaskServiceInterface::class, CustomTaskService::class);
        $this->app->bind(CustomBonusServiceInterface::class, CustomBonusService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       //
    }
}
