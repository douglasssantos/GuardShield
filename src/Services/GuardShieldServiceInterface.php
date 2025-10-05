<?php

namespace Larakeeps\GuardShield\Services;

use Exception;
use http\Message\Body;
use Illuminate\Database\Eloquent\Collection;
use Larakeeps\GuardShield\Models\Module;
use Larakeeps\GuardShield\Models\Permission;
use Larakeeps\GuardShield\Models\Role;

interface GuardShieldServiceInterface
{
    public function abilities(): array;
    public function allRoles(): Collection;
    public function getRole(string|array $role): Collection;
    public function hasRole(string|array $role): bool;
    public function allPermissions(): Collection;
    public function getPermission(string|array $permission): Collection;
    public function hasPermission(string|array $permission): bool;
    public function generateGates(): ?Exception;
    public function hasRoleAndPermission(string|array $role, string|array $permission): bool;
    public function gateHasPermission($user, string|array $permission, string|array $inRole = []): bool;
    public function gateAllows($user, $permission, string|array $inRole = null): bool;
    public function gateAllowsUnless($condition, $user, $permission, string|array $inRole = null): bool;
    public function checkIfPassedValueIsArrayOrString(string|array $keyName): string|array;
    public function allows(string|array $abilities, $inRole = null): bool;
    public function allowsUnless($condition, string|array $abilities, $inRole = null): bool;
    public function allowsAtLeastOne(array $abilities, $inRole = null): bool;
    public function allowsAtLeastOneUnless($condition, array $abilities, $inRole = null): bool;
    public function denies(string|array $abilities, $inRole = null): bool;
    public function deniesUnless($condition, string|array $abilities, $inRole = null): bool;
    public function deniesAtLeastOne(array $abilities, $inRole = null): bool;
    public function deniesAtLeastOneUnless($condition, array $abilities, $inRole = null): bool;
    public function newRoleAndPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions, ?Module $module = null): Role;
    public function newRoleAndPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions, ?Module $module = null): ?Role;
    public function newRoleAndAssignPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions): Role;
    public function newRoleAndAssignPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions): ?Role;
    public function setActivePermission(string $namePermission, bool $status);
    public function setActivePermissionUnless($condition, string $namePermission, bool $status);
    public function newRole(string $name, string $description): Role;
    public function newRoles(array $roles, array $permissions): void;
    public function newRoleUnless($condition, string $name, string $description): ?Role;
    public function newModule(string $name, string $description): Module;
    public function getModule(string $name): Module;
    public function getAllPermissionByModule(string $name): Permission;
    public function newPermission(string $name, string $description, ?Module $module = null): Permission;
    public function newPermissions(array $permissions, ?Module $module = null): void;
    public function newPermissionUnless($condition, string $name, string $description, ?Module $module = null): ?Permission;
    public function assignPermission(Role $role, Permission $permission): bool;
    public function assignPermissionUnless($condition, Role $role, Permission $permission): bool;
    public function unassignPermission(Role $role, Permission $permission): bool;
    public function unassignPermissionUnless($condition, Role $role, Permission $permission): bool;
    public function userHasRole($user);
}
