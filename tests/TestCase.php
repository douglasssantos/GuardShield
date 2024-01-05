<?php

namespace Larakeeps\GuardShield\Tests;

use Larakeeps\GuardShield\Providers\GuardShieldServiceProvider;
use Illuminate\Foundation\Application;
use Larakeeps\GuardShield\Services\GuardShieldService;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{

    /**
     * add the package provider
     *
     * @param  Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            GuardShieldServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'GuardShield' => GuardShieldService::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('user', ['username' => 'testcase', 'password' => 'testcase']);

        $app['config']->set('role', ['name' => 'administrator', 'description' => 'role for users administrators']);

        $app['config']->set('permissions', [
            ['name' => 'View List Users', 'description' => 'Permission to view list users'],
            ['name' => 'Create User', 'description' => 'Permission to create user'],
            ['name' => 'Edit User', 'description' => 'Permission to edit user'],
            ['name' => 'Delete User', 'description' => 'Permission to delete user'],
        ]);
    }
}