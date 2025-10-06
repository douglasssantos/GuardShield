<?php

namespace Larakeeps\GuardShield\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Module extends Model
{
    use HasFactory;

    protected $table = "guard_shield_permissions_modules";

    protected $guarded = ['id'];

    protected $hidden = ["created_at", "updated_at"];


    public function permissions()
    {
        return $this->hasMany(Permission::class, "module_id", "id");
    }

    public function scopeGetModule(Builder $query, string $name): static
    {
        return $query->where('key', Str::slug($name))->first();
    }

    public function scopeGetPermission(Builder $query, string $name)
    {
        return $query->pemissions()->where('key', Str::slug($name))->first();
    }

    public function scopeGetAllPermissions(Builder $query)
    {
        return $query->permission();
    }

    public function scopeNew(Builder $query, string $name, string$description)
    {
        return $query->firstOrCreate(compact('name', 'description'));
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn(Module $model) => $model->key = Str::slug($model->name));
    }


}
