<?php

namespace App\Facades;

use App\Models\GuardShieldPermission;
use App\Models\GuardShieldRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class GuardShield
{

    public static function allRoles()
    {
        return GuardShieldRole::get();
    }

    public static function allPermissions()
    {
        return DB::table("guard_shield_permissions")->get();
    }

    public static function generateGates()
    {
        foreach (static::allPermissions() as $permission){
            Gate::define($permission->name, fn (User $user) => static::gateAllows($user, $permission->key));
        }

    }

    public static function gateAllows(User $user, $permission)
    {
        $allow = false;

        foreach ($user->roles()->get() as $role){

            $permission = $role->permissions()->where("key", $permission);

            if($permission->exists()) $allow = true;

        }

        return $allow;
    }

    public static function allows(string|array $abilities)
    {
        if(is_string($abilities) && !empty(trim($abilities)))
            return Gate::allows($abilities);

        foreach ($abilities as $ability) {
            if(!Gate::allows($ability)) return false;
        }

        return true;
    }

    public static function allowsAtLeastOne(array $abilities)
    {
        foreach ($abilities as $ability) {
            if(Gate::allows($ability)) return true;
        }

        return false;
    }

    public static function denies(string|array $abilities)
    {
        return !static::allows($abilities);
    }

    public static function deniesAtLeastOne(array $abilities)
    {
        return !static::allowsAtLeastOne($abilities);
    }



}