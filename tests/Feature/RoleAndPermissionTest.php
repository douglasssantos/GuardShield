<?php

namespace Larakeeps\GuardShield\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Larakeeps\GuardShield\Models\GuardShieldPermission;
use Larakeeps\GuardShield\Models\GuardShieldRole;
use Larakeeps\GuardShield\Models\User;
use Larakeeps\GuardShield\Tests\TestCase;

class RoleAndPermissionTest extends TestCase
{

    use RefreshDatabase;


    private $service;


    public function testCreateRoleInDatabase()
    {

        $configRole = Config::get("role");

        $role = GuardShieldRole::new($configRole['name'], $configRole['description']);

        $this->assertContains($configRole['name'], $role->name);

    }

    public function testCreatePermissionInDatabase()
    {

        $configPermissions = Config::get("permissions");

        $count = 0;

        foreach ($configPermissions as $permission) {

            $createdPermission = GuardShieldPermission::new($permission['name'], $permission['description']);

            if($createdPermission && $permission['name'] = $createdPermission->name){

                $count +=1;

            }

        }

        $this->assertEquals(count($configPermissions), $count);

    }

    public function testCreateRoleAndPermissionAndAssignInDatabase()
    {

        $configRole = Config::get("role");
        $configPermissions = Config::get("permissions");

        $role = GuardShieldRole::new($configRole['name'], $configRole['description']);

        $createdPermission = GuardShieldPermission::new($configPermissions[0]['name'], $configPermissions[0]['description']);

        $this->assertTrue($role->assignPermission($createdPermission));

    }

    public function testUserAssignRole()
    {
        $user = User::firstOrCreate(Config::get("user"));
        $this->assertTrue($user->assignRole("Administrador"));
    }

}