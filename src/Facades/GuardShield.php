<?php

namespace Larakeeps\GuardShield\Facades;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;
use Larakeeps\GuardShield\Models\Module;
use Larakeeps\GuardShield\Models\Permission;
use Larakeeps\GuardShield\Models\Role;

/**
 * @method static array abilities()
 * @method static Role role()
 * @method static Module module()
 * @method static Permission permission()
 * @method static Collection allRoles(bool $withPermissions = false)
 * @method static Collection getRole(string|array $role, bool $withPermissions = false)
 * @method static bool hasRole(string|array $role)
 * @method static Collection allPermissions(bool $withRole = false)
 * @method static Collection getPermission(string|array $permission, bool $withRole = false)
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
 * @method static Role newRoleAndPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions, ?Module $module = null)
 * @method static Role|null newRoleAndPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions, ?Module $module = null)
 * @method static Role newRoleAndAssignPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static Role|null newRoleAndAssignPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions)
 * @method static void setActivePermission(string $namePermission, bool $status)
 * @method static void setActivePermissionUnless($condition, string $namePermission, bool $status)
 * @method static Role newRole(string $name, string $description)
 * @method static void newRoles(array $roles, array $permissions)
 * @method static Role|null newRoleUnless($condition, string $name, string $description)
 * @method static Module newModule(string $name, string $description)
 * @method static Module getModule(string $name)
 * @method static Collection allModules(bool $withPermissions = false)
 * @method static Permission getAllPermissionByModule(string $name)
 * @method static Permission newPermission(string $name, string $description, ?Module $module = null)
 * @method static void newPermissions(array $permissions, ?Module $module = null)
 * @method static Permission|null newPermissionUnless($condition, string $name, string $description, ?Module $module = null)
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
