<?php

namespace Larakeeps\GuardShield\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Larakeeps\GuardShield\Models\Role;
use Random\Randomizer;

class seedTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guard-shield:make {--test}';

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

        if($this->option("test"))
            $this->makeTest();

        $this->optimize();

    }


    public function makeTest()
    {

        $randomizer = new \Random\Randomizer();

        $userModel = app(config("guard-shield.provider.users.model"));

        $users = Arr::map(config("guard-shield.make-test.users"),
        function ($user) use ($userModel) {

            $created = $userModel::create($user);

            return $created->id;

        });

        $permissions = config("guard-shield.make-test.permissions");

        foreach (config("guard-shield.make-test.role") as $role) {
            Role::newRoleAndPermissions(
                $role[0],
                $role[1],
                Arr::map(
                    $randomizer->pickArrayKeys($permissions, random_int(1,4)),
                    fn($id) => $permissions[$id]
                )
            );
            $userModel::where("id", $users[random_int(0,2)])->assignRole($role[0]);
        }

        $this->output->title("Return test created users, roles and permissions.");

        dd($userModel::whereIn("id", $users)->get()->toArray());

    }

    public function optimize()
    {
        Artisan::call("optimize:clear");

        echo Artisan::output();

        Artisan::call("optimize");

        echo Artisan::output();

    }
}
