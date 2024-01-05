<?php

namespace Larakeeps\GuardShield\Services;

use Larakeeps\GuardShield\Models\GuardShieldPermission;
use Larakeeps\GuardShield\Models\GuardShieldRole;

interface GuardShieldServiceInterface
{
    public function allRoles();
    public function allPermissions();
    public function generateGates(): void;
    public function gateAllows($user, $permission, string|array $inRole = null): bool;
    public function gateAllowsUnless($condition, $user, $permission, string|array $inRole = null): bool;
    public function hasRoleKeyName(string|array $keyName): array;
    public function allows(string|array $abilities, $inRole = null): bool;
    public function allowsUnless($condition, string|array $abilities, $inRole = null): bool;
    public function allowsAtLeastOne(array $abilities, $inRole = null): bool;
    public function allowsAtLeastOneUnless($condition, array $abilities, $inRole = null): bool;
    public function denies(string|array $abilities, $inRole = null): bool;
    public function deniesUnless($condition, string|array $abilities, $inRole = null): bool;
    public function deniesAtLeastOne(array $abilities, $inRole = null): bool;
    public function deniesAtLeastOneUnless($condition, array $abilities, $inRole = null): bool;
    public function newRoleAndPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions);
    public function newRoleAndPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions);
    public function newRoleAndAssignPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions);
    public function newRoleAndAssignPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions);
    public function setActivePermission(string $namePermission, bool $status);
    public function setActivePermissionUnless($condition, string $namePermission, bool $status);
    public function newRole(string $name, string $description);
    public function newRoleUnless($condition, string $name, string $description);
    public function newPermission(string $name, string $description);
    public function newPermissionUnless($condition, string $name, string $description);
    public function assignPermission(GuardShieldRole $role, GuardShieldPermission $permission);
    public function assignPermissionUnless($condition, GuardShieldRole $role, GuardShieldPermission $permission);
    public function unassignPermission(GuardShieldRole $role, GuardShieldPermission $permission);
    public function unassignPermissionUnless($condition, GuardShieldRole $role, GuardShieldPermission $permission);
    public function userHasRole($user);
}