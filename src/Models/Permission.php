<?php

namespace Larakeeps\GuardShield\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory;

    protected $table = "guard_shield_permissions";

    protected $guarded = ['id'];

    protected $hidden = ['id', 'pivot', "created_at", "updated_at"];


    public function roles()
    {
        return $this->belongsToMany(Role::class, "guard_shield_assigns");
    }

    public function scopeGetPermission($query, $name)
    {
        return $query->where('key', Str::slug($name))->first();
    }


    public function scopeNew($query, $name, $description)
    {
        return $query->firstOrCreate(compact('name', 'description'));
    }

    public function scopeSetActive($query, $permissionName, $active)
    {
        return $query->where('key', Str::slug($permissionName))
            ->update(['active' => $active]);
    }

    protected static function boot ()
    {
        parent::boot();
        static::creating(fn (Permission $model) => $model->key = Str::slug($model->name));
    }



}
