<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\KeyGeneratorInterface;
use App\Services\UniqueKeyGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(KeyGeneratorInterface::class, UniqueKeyGenerator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
