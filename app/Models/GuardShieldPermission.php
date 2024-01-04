<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GuardShieldPermission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = ['id', 'pivot', "created_at", "updated_at"];


    public function roles()
    {
        return $this->belongsToMany(GuardShieldRole::class, "guard_shield_assigns");
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
        static::creating(fn (GuardShieldPermission $model) => $model->key = Str::slug($model->name));
    }



}
