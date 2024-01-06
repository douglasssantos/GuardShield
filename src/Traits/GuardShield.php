<?php

namespace Larakeeps\GuardShield\Traits;

use Illuminate\Support\Str;
use Larakeeps\GuardShield\Models\Role;

trait GuardShield
{
    public function scopeHasRole($query, $roleName)
    {
        $user = $this;

        if(empty($this->id)) $user = $query->first();

        return $user->roles()->where('key', Str::slug($roleName))->exists();

    }

    public function scopeAssignRole($query, $roleName)
    {
        $role = Role::where('key', Str::slug($roleName));

        if($role->doesntExist()) return false;

        $role = $role->first();

        $user = $this;

        if(empty($this->id)) $user = $query->first();

        if($user->roles()->syncWithoutDetaching($role))
            return true;

        return false;

    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->with("permissions");
    }

}