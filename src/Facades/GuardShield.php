<?php

namespace Larakeeps\GuardShield\Facades;

use Exception;
use Illuminate\Support\Facades\Facade;
use Larakeeps\GuardShield\Models\Permission;
use Larakeeps\GuardShield\Models\Role;

/**
 * @method static void allRoles()
 * @method static void allPermissions()
 * @method static Exception|null generateGates()
 * @method static bool gateHasPermission($user, $permission, string|array $inRole)
 * @method static bool gateAllows($user, $permission, string|array $inRole)
 * @method static bool gateAllowsUnless($condition, $user, $permission, string|array $inRole)
 * @method static array hasRoleKeyName(string|array $keyName)
 * @method static bool allows(string|array $abilities, $inRole)
 * @method static bool allowsUnless($condition, string|array $abilities, $inRole)
 * @method static bool allowsAtLeastOne(array $abilities, $inRole)
 * @method static bool allowsAtLeastOneUnless($condition, array $abilities, $inRole)
 * @method static bool denies(string|array $abilities, $inRole)
 * @method static bool deniesUnless($condition, string|array $abilities, $inRole)
 * @method static bool deniesAtLeastOne(array $abilities, $inRole)
 * @method static bool deniesAtLeastOneUnless($condition, array $abilities, $inRole)
 * @method static void newRoleAndPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static void newRoleAndPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static void newRoleAndAssignPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static void newRoleAndAssignPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static void setActivePermission(string $namePermission, bool $status)
 * @method static void setActivePermissionUnless($condition, string $namePermission, bool $status)
 * @method static void newRole(string $name, string $description)
 * @method static void newRoleUnless($condition, string $name, string $description)
 * @method static void newPermission(string $name, string $description)
 * @method static void newPermissionUnless($condition, string $name, string $description)
 * @method static void assignPermission(Role $role, Permission $permission)
 * @method static void assignPermissionUnless($condition, Role $role, Permission $permission)
 * @method static void unassignPermission(Role $role, Permission $permission)
 * @method static void unassignPermissionUnless($condition, Role $role, Permission $permission)
 * @method static void userHasRole($user)
 *
 * @see \Larakeeps\GuardShield\Services\LocationsServiceInterface
 */

class GuardShield extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'GuardShield';
    }
}