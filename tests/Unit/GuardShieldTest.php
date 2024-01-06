<?php

namespace Larakeeps\GuardShield\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Larakeeps\GuardShield\Models\Permission;
use Larakeeps\GuardShield\Models\Role;
use Larakeeps\GuardShield\Tests\TestCase;

class GuardShieldTest extends TestCase
{
    public function testIfThereIsAnyRoleCreated()
    {
        $configRole = Config::get("role");

        $role = Role::getRole($configRole['name']);

        $this->assertContains($configRole['name'], $role->name);
    }

    public function testIfThereIsAnyPermissionCreated()
    {
        $configPermission = Config::get("permissions");

        $permission = Permission::getPermission($configPermission[0]['name']);

        $this->assertContains($configPermission[0]['name'], $permission->name);
    }

    public function testIfThePermissionIsActivating()
    {
        $configPermission = Config::get("permissions");

        $permission = Permission::setActive($configPermission[0]['name'], true);

        $this->assertTrue($permission);
    }

    public function testWhetherThePermissionIsDisabling()
    {
        $configPermission = Config::get("permissions");

        $permission = Permission::setActive($configPermission[0]['name'], false);

        $this->assertTrue($permission);
    }
}