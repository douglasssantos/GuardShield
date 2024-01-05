<?php

namespace Larakeeps\GuardShield\Services;

use Illuminate\Support\Facades\Auth;
use Larakeeps\GuardShield\Models\GuardShieldPermission;
use Larakeeps\GuardShield\Models\GuardShieldRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class GuardShieldService implements GuardShieldServiceInterface
{

    public function allRoles()
    {
        return GuardShieldRole::get();
    }

    public function allPermissions(): \Illuminate\Support\Collection
    {
        return GuardShieldPermission::get();
    }

    public function generateGates(): void
    {
        foreach ($this->allPermissions() as $permission){
            Gate::define($permission->name,
            fn ($user, $inRole = null) => $this->gateAllows($user, $permission->key, $inRole));
        }

    }

    public function gateAllows($user, $permission, string|array $inRole = null): bool
    {
        $allow = false;

        $roles = $user->roles();

        if(!empty($inRole)){

            if($roles->whereIn('key', $this->hasRoleKeyName($inRole))->doesntExist())
                return false;

        }

        foreach ($roles->get() as $role){

            $permission = $role->permissions()->where("key", $permission);

            if($permission->exists()) $allow = true;

        }

        return $allow;
    }
    public function gateAllowsUnless($condition, $user, $permission, string|array $inRole = null): bool
    {
        if($condition)
            return $this->gateAllows($user, $permission, $inRole);

        return false;
    }

    public function hasRoleKeyName(string|array $keyName): array
    {
        if(is_string($keyName) && !empty(trim($keyName)))
            return [ Str::slug($keyName) ];

        return array_map( fn ($value) => Str::slug($value), $keyName );
    }

    public function allows(string|array $abilities, $inRole = null): bool
    {
        if(is_string($abilities) && !empty(trim($abilities)))
            return Gate::allows($abilities, $inRole);

        foreach ($abilities as $ability) {
            if(!Gate::allows($ability, $inRole)) return false;
        }

        return true;
    }
    public function allowsUnless($condition, string|array $abilities, $inRole = null): bool
    {
        if($condition)
            return $this->allows($abilities, $inRole);

        return false;
    }

    public function allowsAtLeastOne(array $abilities, $inRole = null): bool
    {
        foreach ($abilities as $ability) {
            if(Gate::allows($ability, $inRole)) return true;
        }

        return false;
    }

    public function allowsAtLeastOneUnless($condition, array $abilities, $inRole = null): bool
    {
        if($condition)
            return $this->allowsAtLeastOne($abilities, $inRole);

        return false;
    }

    public function denies(string|array $abilities, $inRole = null): bool
    {
        return !$this->allows($abilities, $inRole);
    }

    public function deniesUnless($condition, string|array $abilities, $inRole = null): bool
    {
        if($condition)
            return !$this->allows($abilities, $inRole);

        return false;
    }

    public function deniesAtLeastOne(array $abilities, $inRole = null): bool
    {
        return !$this->allowsAtLeastOne($abilities, $inRole);
    }

    public function deniesAtLeastOneUnless($condition, array $abilities, $inRole = null): bool
    {
        if($condition)
            return !$this->deniesAtLeastOne($abilities, $inRole);

        return false;
    }

    public function newRoleAndPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions)
    {
        return GuardShieldRole::newRoleAndPermissions($nameRole, $descriptionRole, $arrayWithPermissions);
    }

    public function newRoleAndPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions)
    {
        if($condition)
            return $this->newRoleAndPermissions($nameRole, $descriptionRole, $arrayWithPermissions);
    }

    public function newRoleAndAssignPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions)
    {
        return GuardShieldRole::newRoleAndAssignPermissions($nameRole, $descriptionRole, $arrayWithPermissions);
    }

    public function newRoleAndAssignPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions)
    {
        if($condition)
            return $this->newRoleAndAssignPermissions($nameRole, $descriptionRole, $arrayWithPermissions);
    }

    public function setActivePermission(string $namePermission, bool $status)
    {
        return GuardShieldPermission::setActive($namePermission, $status);
    }

    public function setActivePermissionUnless($condition, string $namePermission, bool $status)
    {
        if($condition)
            return $this->setActivePermission($namePermission, $status);
    }

    public function newRole(string $name, string $description)
    {
        return GuardShieldRole::new($name, $description);
    }

    public function newRoleUnless($condition, string $name, string $description)
    {
        if($condition)
            return $this->newRole($name, $description);
    }

    public function newPermission(string $name, string $description)
    {
        return GuardShieldPermission::new($name, $description);
    }

    public function newPermissionUnless($condition, string $name, string $description)
    {
        if($condition)
            return $this->newPermission($name, $description);
    }

    public function assignPermission(GuardShieldRole $role, GuardShieldPermission $permission)
    {
        return $role->assignPermission($permission);
    }

    public function assignPermissionUnless($condition, GuardShieldRole $role, GuardShieldPermission $permission)
    {
        if($condition)
            return $this->assignPermission($role, $permission);
    }

    public function unassignPermission(GuardShieldRole $role, GuardShieldPermission $permission)
    {
        return $role->unassignPermission($permission);
    }

    public function unassignPermissionUnless($condition, GuardShieldRole $role, GuardShieldPermission $permission)
    {
        if($condition)
            return $role->unassignPermission($permission);
    }

    public function userHasRole($user)
    {
        return $user->hasRole();
    }

}