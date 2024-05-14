<?php

namespace App\Providers;

use App\Repository\FixtureRepository;
use App\Repository\Interfaces\FixtureRepositoryInterface;
use App\Repository\Interfaces\TeamRepositoryInterface;
use App\Repository\TeamRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(FixtureRepositoryInterface::class, FixtureRepository::class);
        app()->bind(TeamRepositoryInterface::class, TeamRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
