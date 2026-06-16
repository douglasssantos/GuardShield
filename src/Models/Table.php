<?php

namespace Larakeeps\GuardShield\Models;

class Table {


    public static function AssignsPermissions(){

        $table = config("guard-shield.provider.models.assigns.permissions.database");

        if (!$table)
            $table = 'guard_shield_assigns';

        return $table;
    }
    public static function AssignsRoles(){

        $table = config("guard-shield.provider.models.assigns.roles.database");

        if (!$table)
            $table = 'guard_shield_assigns_roles';

        return $table;
    }
    
    public static function Users(){

        $table = config("guard-shield.provider.users.database");

        if (!$table)
            $table = 'users';

        return $table;
    }
    
    public static function Permissions(){

        $table = config("guard-shield.provider.models.permissions.database");

        if (!$table)
            $table = 'guard_shield_permissions';

        return $table;
    }

    public static function Roles(){

        $table = config("guard-shield.provider.models.roles.database");

        if (!$table)
            $table = 'guard_shield_roles';

        return $table;
    }

    public static function Modules(){

        $table = config("guard-shield.provider.models.modules.database");

        if (!$table)
            $table = 'guard_shield_permissions_modules';

        return $table;
    }
    

}
