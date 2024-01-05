<?php

namespace Larakeeps\GuardShield\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GuardShieldRole extends Model
{
    use HasFactory;

    protected $with = ['permissions'];

    protected $guarded = ["id"];

    protected $hidden = ['id', 'pivot', "created_at", "updated_at"];

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
    public function scopeNewRoleAndPermissions($query, $nameRole, $descriptionRole, $arrayWithPermissions)
    {

        $role =  $query->new($nameRole, $descriptionRole);

        foreach ($arrayWithPermissions as $permission) {

            if(empty($permission[0]))
                throw new Exception('Permission name is empty.');

            $permission = GuardShieldPermission::new($permission[0], $permission[1]);

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

            $permission = GuardShieldPermission::where('key', $permission[0]);

            if($permission->exists())
                $role->assignPermission($permission->first());

        }

        return $role;

    }

    public function assignPermission(GuardShieldPermission $permission)
    {
        if($this->permissions()->syncWithoutDetaching($permission))
            return true;

        return false;
    }

    public function unassignPermission(GuardShieldPermission $permission)
    {
        if($this->permissions()->detach($permission))
            return true;

        return false;
    }

    public function permissions()
    {
        return $this->belongsToMany(GuardShieldPermission::class, "guard_shield_assigns");
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn (GuardShieldRole $model) => $model->key = Str::slug($model->name));
    }

}
