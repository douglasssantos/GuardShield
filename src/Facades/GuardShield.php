<?php

namespace Larakeeps\GuardShield\Facades;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;
use Larakeeps\GuardShield\Models\Permission;
use Larakeeps\GuardShield\Models\Role;

/**
 * @method static array abilities()
 * @method static Collection allRoles()
 * @method static Collection getRole(string|array $role)
 * @method static bool hasRole(string|array $role)
 * @method static Collection allPermissions()
 * @method static Collection getPermission(string|array $permission)
 * @method static bool hasPermission(string|array $permission)
 * @method static Exception|null generateGates()
 * @method static bool hasRoleAndPermission(string|array $role, string|array $permission)
 * @method static bool gateHasPermission($user, string|array $permission, string|array $inRole)
 * @method static bool gateAllows($user, $permission, string|array $inRole)
 * @method static bool gateAllowsUnless($condition, $user, $permission, string|array $inRole)
 * @method static string|array checkIfPassedValueIsArrayOrString(string|array $keyName)
 * @method static bool allows(string|array $abilities, $inRole)
 * @method static bool allowsUnless($condition, string|array $abilities, $inRole)
 * @method static bool allowsAtLeastOne(array $abilities, $inRole)
 * @method static bool allowsAtLeastOneUnless($condition, array $abilities, $inRole)
 * @method static bool denies(string|array $abilities, $inRole)
 * @method static bool deniesUnless($condition, string|array $abilities, $inRole)
 * @method static bool deniesAtLeastOne(array $abilities, $inRole)
 * @method static bool deniesAtLeastOneUnless($condition, array $abilities, $inRole)
 * @method static Role newRoleAndPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static Role|null newRoleAndPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static Role newRoleAndAssignPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static Role|null newRoleAndAssignPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static void setActivePermission(string $namePermission, bool $status)
 * @method static void setActivePermissionUnless($condition, string $namePermission, bool $status)
 * @method static Role newRole(string $name, string $description)
 * @method static Role|null newRoleUnless($condition, string $name, string $description)
 * @method static Permission newPermission(string $name, string $description)
 * @method static Permission|null newPermissionUnless($condition, string $name, string $description)
 * @method static bool assignPermission(Role $role, Permission $permission)
 * @method static bool assignPermissionUnless($condition, Role $role, Permission $permission)
 * @method static bool unassignPermission(Role $role, Permission $permission)
 * @method static bool unassignPermissionUnless($condition, Role $role, Permission $permission)
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
