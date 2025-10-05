<?php

namespace Larakeeps\GuardShield\Services;

use Exception;
use http\Params;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Larakeeps\GuardShield\Models\Module;
use Larakeeps\GuardShield\Models\Permission;
use Larakeeps\GuardShield\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\AssignOp\Mod;

class GuardShieldService implements GuardShieldServiceInterface
{
    public function abilities(): array
    {
        return Gate::abilities();
    }

    public function allRoles(): Collection
    {
        return Role::get();
    }

    public function checkIfPassedValueIsArrayOrString(string|array $keyName): string | array
    {
        return is_array($keyName) ? array_map([new Str, "slug"], $keyName) : [Str::slug($keyName)];
    }

    public function getRole(string|array $role): Collection
    {
        return Role::whereIn("key", $this->checkIfPassedValueIsArrayOrString($role))->get();
    }

    public function hasRole($role): bool
    {
        return Role::whereIn("key", $this->checkIfPassedValueIsArrayOrString($role))->exists();
    }

    public function allPermissions(): Collection
    {
        return Permission::get();
    }

    public function getPermission(string|array $permission): Collection
    {
        return Permission::whereIn("key", $this->checkIfPassedValueIsArrayOrString($permission))->get();
    }

    public function hasPermission(string|array $permission): bool
    {
        return Permission::whereIn("key", $this->checkIfPassedValueIsArrayOrString($permission))->exists();
    }

    public function hasRoleAndPermission(string|array $role, string|array $permission): bool
    {
        return $this->gateHasPermission(null, $permission, $role, false);
    }

    public function generateGates(): ?Exception
    {
        try {
            foreach (Permission::all() as $permission) {
                Gate::define($permission->name,
                    fn($user, $inRole = null) => $this->gateHasPermission($user, $permission->key, $inRole));
            }

            return null;

        } catch(Exception $e) {
            return $e;
        }
    }

    public function gateHasPermission($user, string|array $permission, string|array $inRole = [], $checkUser = true): bool
    {

        $roles = match ($checkUser){
            true => $user->roles(),
            false => Role::with("permissions")
        };

        if(!empty($inRole)){

            if($roles->whereIn('key', $this->checkIfPassedValueIsArrayOrString($inRole))->doesntExist())
                return false;

        }

        return $roles->whereHas('permissions',
            fn ($builder) => $builder->whereIn('key', $this->checkIfPassedValueIsArrayOrString($permission))
        )->exists();
    }

    public function gateAllows($user, $permission, string|array $inRole = null): bool
    {
        $allow = false;

        $roles = $user->roles();

        if(!empty($inRole)){

            if($roles->whereIn('key', $this->checkIfPassedValueIsArrayOrString($inRole))->doesntExist())
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

    public function newRoleAndPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions, ?Module $module = null): Role
    {
        return Role::newRoleAndPermissions($nameRole, $descriptionRole, $arrayWithPermissions, $module);
    }

    public function newRoleAndPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions, ?Module $module = null): ?Role
    {
        if($condition)
            return $this->newRoleAndPermissions($nameRole, $descriptionRole, $arrayWithPermissions, $module);

        return null;
    }

    public function newRoleAndAssignPermissions(string $nameRole, string $descriptionRole, array $arrayWithPermissions): Role
    {
        return Role::newRoleAndAssignPermissions($nameRole, $descriptionRole, $arrayWithPermissions);
    }

    public function newRoleAndAssignPermissionsUnless($condition, string $nameRole, string $descriptionRole, array $arrayWithPermissions): ?Role
    {
        if($condition)
            return $this->newRoleAndAssignPermissions($nameRole, $descriptionRole, $arrayWithPermissions);

        return null;
    }

    public function setActivePermission(string $namePermission, bool $status)
    {
        return Permission::setActive($namePermission, $status);
    }

    public function setActivePermissionUnless($condition, string $namePermission, bool $status)
    {
        if($condition)
            return $this->setActivePermission($namePermission, $status);
    }

    public function newRole(string $name, string $description): Role
    {
        return Role::new($name, $description);
    }

    public function newRoles(array $roles, array $permissions): void
    {
        $permissionsIds = Arr::map($permissions, fn($permission) => Permission::where('key', Str::slug($permission[0]))->first()->id);
        foreach ($roles as [$name, $description]) {
            $role = Role::create(['name' => $name, 'description' => $description]);
            $role->assignPermission($permissionsIds);
        }
    }

    public function newRoleUnless($condition, string $name, string $description): ?Role
    {
        if($condition)
            return $this->newRole($name, $description);

        return null;
    }

    public function newModule(string $name, string $description): Module
    {
        return Module::new($name, $description);
    }

    public function getModule(string $name): Module
    {
        return Module::getModule($name);
    }

    public function getAllPermissionByModule(string $name): Permission
    {
        return Module::whereName(Str::slug($name))->first()->permissions()->get();
    }

    public function newPermission(string $name, string $description, Module|int|null $module = null): Permission
    {
        return Permission::new($name, $description, $module);;
    }
    public function newPermissions(array $permissions, ?Module $module = null): void
    {
        foreach ($permissions as [$name, $description]) {
            Permission::create(['module_id' => $module?->id ?? $module, 'name' => $name, 'description' => $description]);
        }
    }

    public function newPermissionUnless($condition, string $name, string $description, ?Module $module = null): ?Permission
    {
        if($condition)
            return $this->newPermission($name, $description, $module);;

        return null;
    }

    public function assignPermission(Role $role, Permission $permission): bool
    {
        return $role->assignPermission($permission);
    }

    public function assignPermissionUnless($condition, Role $role, Permission $permission): bool
    {
        if($condition)
            return $this->assignPermission($role, $permission);

        return false;
    }

    public function unassignPermission(Role $role, Permission $permission): bool
    {
        return $role->unassignPermission($permission);
    }

    public function unassignPermissionUnless($condition, Role $role, Permission $permission): bool
    {
        if($condition)
            return $role->unassignPermission($permission);

        return false;
    }

    public function userHasRole($user)
    {
        return $user->hasRole();
    }

}
