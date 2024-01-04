<?php

namespace App\Providers;

use App\Facades\GuardShield;
use Illuminate\Support\ServiceProvider;

class GuardShieldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        GuardShield::generateGates();
    }
}
