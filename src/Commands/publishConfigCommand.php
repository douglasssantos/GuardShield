<?php

namespace Larakeeps\GuardShield\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class publishConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guard-shield:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for publish configs of Guard Shield';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        Artisan::call("vendor:publish --tag=guard-shield-config");

        echo Artisan::output();

        $this->optimize();

    }
    public function optimize()
    {
        Artisan::call("optimize:clear");

        echo Artisan::output();

        Artisan::call("optimize");

        echo Artisan::output();

    }
}
