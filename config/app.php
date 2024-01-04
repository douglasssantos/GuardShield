<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

   
    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
		App\Providers\BindServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
        Yajra\DataTables\DataTablesServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
        App\Providers\GuardShieldServiceProvider::class,
    ])->toArray(),
    'Debugbar' => Barryvdh\Debugbar\Facades\Debugbar::class,

];
