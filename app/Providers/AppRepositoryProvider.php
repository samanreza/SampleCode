<?php

namespace App\Providers;

use App\Contract\Repository\CustomTaskModelInterface;
use App\Contract\Repository\CustomUserModelInterface;
use App\Repositories\CustomTaskRepository;
use App\Repositories\CustomUserRepository;
use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CustomUserModelInterface::class, CustomUserRepository::class);
        $this->app->bind(CustomTaskModelInterface::class, CustomTaskRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
