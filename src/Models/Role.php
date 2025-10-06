<?php

namespace Larakeeps\GuardShield\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    protected $table = "guard_shield_roles";

    protected $with = ['permissions'];

    protected $guarded = ["id"];

    protected $hidden = ['pivot', "created_at", "updated_at"];

    public function scopeGetRole($query, $name)
    {
        return $query->where('key', Str::slug($name))->first();
    }

    public function scopeNew($query, $name, $description)
    {
        return $query->firstOrCreate(compact('name', 'description'));
    }

    /**
     * @throws Exception
     */
    public function scopeNewRoleAndPermissions($query, $nameRole, $descriptionRole, $arrayWithPermissions, ?Module $module = null)
    {

        $role =  $query->new($nameRole, $descriptionRole);

        foreach ($arrayWithPermissions as $permission) {

            if(empty($permission[0]))
                throw new Exception('Permission name is empty.');

            $permission = Permission::new($permission[0], $permission[1], $module?->id);

            $role->assignPermission($permission);

        }

        return $role;

    }

    /**
     * @throws Exception
     */
    public function scopeNewRoleAndAssignPermissions($query, $nameRole, $descriptionRole, $arrayWithPermissions)
    {

        $role =  $query->new($nameRole, $descriptionRole);

        foreach ($arrayWithPermissions as $permission) {

            if(empty($permission[0]))
                throw new Exception('Permission name is empty.');

            $permission = Permission::where('key', $permission[0]);

            if($permission->exists())
                $role->assignPermission($permission->first());

        }

        return $role;

    }

    public function assignPermission(array|Permission $permission)
    {
        if($this->permissions()->syncWithoutDetaching($permission))
            return true;

        return false;
    }

    public function unassignPermission(array|Permission $permission)
    {
        if($this->permissions()->detach($permission))
            return true;

        return false;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, "guard_shield_assigns");
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn (Role $model) => $model->key = Str::slug($model->name));
    }

}
