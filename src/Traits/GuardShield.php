<?php

namespace Larakeeps\GuardShield\Traits;

use Illuminate\Support\Str;
use Larakeeps\GuardShield\Models\GuardShieldRole;

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
        $role = GuardShieldRole::where('key', Str::slug($roleName));

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
        return $this->belongsToMany(GuardShieldRole::class)
            ->with("permissions");
    }

}