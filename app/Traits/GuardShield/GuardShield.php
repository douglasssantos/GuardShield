<?php

namespace App\Traits\GuardShield;

use App\Models\GuardShieldRole;
use Illuminate\Support\Str;

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

        return $user->roles()->syncWithoutDetaching($role);

    }


    public function roles()
    {
        return $this->belongsToMany(GuardShieldRole::class)
            ->with("permissions");
    }

}