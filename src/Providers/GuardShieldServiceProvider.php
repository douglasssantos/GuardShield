<?php

namespace Larakeeps\GuardShield\Providers;

use Illuminate\Support\ServiceProvider;
use Larakeeps\GuardShield\Services\GuardShieldService;
use Larakeeps\GuardShield\Services\GuardShieldServiceInterface;

class GuardShieldServiceProvider extends ServiceProvider
{
    const ROOT_PATH = __DIR__ . '/../..';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GuardShieldServiceInterface::class, GuardShieldService::class);
        $this->app->singleton('GuardShield', GuardShieldServiceInterface::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(self::ROOT_PATH . '/database/migrations');
        $this->publishes([
            self::ROOT_PATH.'/database/migrations/2024_01_01_211442_create_guard_shield_permissions_table.php' => database_path('migrations/2024_01_01_211442_create_guard_shield_permissions_table.php'),
            self::ROOT_PATH.'/database/migrations/2024_01_01_211512_create_guard_shield_roles_table.php' => database_path('migrations/2024_01_01_211512_create_guard_shield_roles_table.php'),
            self::ROOT_PATH.'/database/migrations/2024_01_01_211838_guard_shield_role_user.php' => database_path('migrations/2024_01_01_211838_guard_shield_role_user.php'),
            self::ROOT_PATH.'/database/migrations/2024_01_01_214412_create_guard_shield_assigns_table.php' => database_path('migrations/2024_01_01_214412_create_guard_shield_assigns_table.php'),
        ], 'guard-shield-migrations');

        //GuardShieldService::generateGates();
    }
}
