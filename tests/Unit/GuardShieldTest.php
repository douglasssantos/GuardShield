<?php

namespace Larakeeps\GuardShield\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Larakeeps\GuardShield\Models\GuardShieldPermission;
use Larakeeps\GuardShield\Models\GuardShieldRole;
use Larakeeps\GuardShield\Tests\TestCase;

class GuardShieldTest extends TestCase
{
    public function testIfThereIsAnyRoleCreated()
    {
        $configRole = Config::get("role");

        $role = GuardShieldRole::getRole($configRole['name']);

        $this->assertContains($configRole['name'], $role->name);
    }

    public function testIfThereIsAnyPermissionCreated()
    {
        $configPermission = Config::get("permissions");

        $permission = GuardShieldPermission::getPermission($configPermission[0]['name']);

        $this->assertContains($configPermission[0]['name'], $permission->name);
    }

    public function testIfThePermissionIsActivating()
    {
        $configPermission = Config::get("permissions");

        $permission = GuardShieldPermission::setActive($configPermission[0]['name'], true);

        $this->assertTrue($permission);
    }

    public function testWhetherThePermissionIsDisabling()
    {
        $configPermission = Config::get("permissions");

        $permission = GuardShieldPermission::setActive($configPermission[0]['name'], false);

        $this->assertTrue($permission);
    }
}