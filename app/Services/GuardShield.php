<?php

namespace App\Facades;

use App\Models\GuardShieldPermission;
use App\Models\GuardShieldRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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
            Gate::define($permission->name,
            fn (User $user, $inRole = null) => static::gateAllows($user, $permission->key, $inRole));
        }

    }

    public static function gateAllows(User $user, $permission, string|array $inRole = null)
    {
        $allow = false;

        $roles = $user->roles();

        if(!empty($inRole)){

            if($roles->whereIn('key', static::hasRoleKeyName($inRole))->doesntExist())
                return false;

        }

        foreach ($roles->get() as $role){

            $permission = $role->permissions()->where("key", $permission);

            if($permission->exists()) $allow = true;

        }

        return $allow;
    }

    public static function hasRoleKeyName(string|array $keyName)
    {
        if(is_string($keyName) && !empty(trim($keyName)))
            return [ Str::slug($keyName) ];

        return array_map( fn ($value) => Str::slug($value), $keyName );
    }

    public static function allows(string|array $abilities, $inRole = null)
    {
        if(is_string($abilities) && !empty(trim($abilities)))
            return Gate::allows($abilities, $inRole);

        foreach ($abilities as $ability) {
            if(!Gate::allows($ability, $inRole)) return false;
        }

        return true;
    }

    public static function allowsAtLeastOne(array $abilities, $inRole = null)
    {
        foreach ($abilities as $ability) {
            if(Gate::allows($ability, $inRole)) return true;
        }

        return false;
    }

    public static function denies(string|array $abilities, $inRole = null)
    {
        return !static::allows($abilities, $inRole);
    }

    public static function deniesAtLeastOne(array $abilities, $inRole = null)
    {
        return !static::allowsAtLeastOne($abilities, $inRole);
    }



}