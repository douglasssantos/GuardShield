**GuardShield**
> GuardShield is a laravel repository with the function of applying permission rules, using grouping of rules and permissions.
> follow the step-by-step instructions below to install the repository.

### This repository is only compatible with laravel: `8.*` to `10.*`


## Installation


First Step, execute the command.

```shell script
composer require larakeeps/guard-shield
```

Second step, add the service provider. Open `app/Providers/AuthServiceProvider.php` or the `GuardShield::generateGates()` method in the Service Provider's `public function boot()`.

```php
use Larakeeps\GuardShield\Facades\GuardShield;

class AuthServiceProvider extends ServiceProvider
{    
        
    public function boot(): void
    {
        GuardShield::generateGates();
        
        //rest of your code......
    }
}
```

Third step, add the middleware. Open `app/Http/Kernel.php` and add a new item to the middlewareAliases array.

```php
protected $middlewareAliases = [
    // ...
    'rolecan' => \Larakeeps\GuardShield\Http\Middleware\GuardShieldTrustRole::class,
]
```

Fourth step add the trait and the necessary parameter to your model. Open `Models/User.php`

```php

use Larakeeps\GuardShield\Traits\GuardShield;

class User extends Authenticatable
{
  use GuardShield, HasApiTokens, HasFactory;

  protected $with = ['roles'];

  //.... rest of the model code
}
```

Fifth step, run the migration to create the tables: ```guard_shield_roles, guard_shield_role_user, guard_shield_assigns, guard_shield_permissions```
```shell script
php artisan migrate
```


**Creating Group of Rules and Permissions Using Model**

```php
use \Larakeeps\GuardShield\Models\Role;
use \Larakeeps\GuardShield\Models\Permission;

$role = Role::new("Administrator", "Rule group for administrators."); // Creating a new permission group.
$permission = Permission::new("Edit User", "Permission to edit user."); // Creating a new permission.
$role->assignPermission($permission); // Linking the permission to a permission group.



//Creating a Rule, permissions and Linking the created permissions to the permission group.

$permissions = [
    ["View User", "Permission to view user"],
    ["Create User", "Permission to create user"],
    ["Edit User", "Permission to edit user"],
    ["Delete User", "Permission to delete user"]
];

Role::newRoleAndPermissions("Administrator", "Rule group for administrators.", $permissions);



//Creating a Rule and Linking existing permissions to the created permission group.

$permissions = ["View User", "Create User", "Edit User", "Delete User"];

Role::newRoleAndAssignPermissions("Administrator", "Rule group for administrators.", $permissions);

// Activating and Deactivating a permission.

Permission::setActive("View User", false);


```

**Creating Rules and Permissions Groups Using Facade**
```php
use Larakeeps\GuardShield\Facades\GuardShield;

$role = GuardShield::newRole("Administrator", "Rule group for administrators."); // Creating a new permission group
$permission = GuardShield::newPermission("Edit User", "Permission to edit user"); // Creating a new permission
$role->assignPermission($permission); // Linking the permission to a permission group.

// OR

GuardShield::assignPermission($role, $permission);


//Creating a Rule, permissions and Linking the created permissions to the permission group.

$permissions = [
     ["View User", "Permission to view user"],
     ["Create User", "Permission to create user"],
     ["Edit User", "Permission to edit user"],
     ["Delete User", "Permission to delete user"],
];

GuardShield::newRoleAndPermissions("Administrator", "Rule group for administrators.", $permissions);



//Creating a Rule and Linking existing permissions to the created permission group.

$permissions = ["View User", "Create User", "Edit User", "Delete User"];

GuardShield::newRoleAndAssignPermissions("Administrator", "Rule group for administrators.", $permissions);

// Activating and Deactivating a permission

GuardShield::setActivePermission("View User", false);


```

**Checking the existence of rule groups and permissions created.**
```php
use Larakeeps\GuardShield\Facades\GuardShield;

$hasPermission = ["View User", "Create User", "Update User", "Delete User"];

/** 
 * 
 * Power one or more rules by passing an array as a parameter
 * The same goes for permissions
 * @method static bool hasRoleAndPermission(string|array $role, string|array $permission)
 * 
 * */

$hasRolesAndPermissions = GuardShield::hasRoleAndPermission('user' , $hasPermission);

if($hasRolesAndPermissions){
    return "The Rule Group and permissions exist."
}


/** 
 * 
 * Check whether one or more rule groups exist.
 * @method static bool hasRole(string|array $role)
 * 
 * */
$hasRoles = GuardShield::hasRole(['administrator', 'user']);

if($hasRoles){
    return "Rule Groups exist."
}


/** 
 * 
 * Check whether one or more rule groups exist.
 * @method static bool hasPermission(string|array $role)
 * 
 * */
 
$permissions = ["View User", "Create User", "Update User", "Delete User"];
$hasPermission = GuardShield::hasPermission($permissions);

if($hasPermission){
    return "Permissions exist."
}


//Unless methods for validation.

```

**Viewing the created rules and permissions.**
```php
use Larakeeps\GuardShield\Facades\GuardShield;




//@method allRoles(): Collection
return GuardShield::allRoles();

/**
 * Returned array: 
 * [
        {
            "key": "administrator",
            "name": "Administrator",
            "description": "Role to administrator",
            "permissions": [
                {
                    "key": "viewuser",
                    "name": "View User",
                    "description": "Permission to view user.",
                    "params": null,
                    "active": true
                },..
            ]
        },
        {
            "key": "user",
            "name": "user",
            "description": "Role to user",
            "permissions": [
                {
                    "key": "viewuser",
                    "name": "View User",
                    "description": "Permission to view user.",
                    "params": null,
                    "active": true
                },.....
            ]
        }
    ]
 */
 
// @method getRole(array|string $role): Collection
return GuardShield::getRole(['administrator', 'user']);

/**
 * Returned array: 
 * [
        {
            "key": "administrator",
            "name": "Administrator",
            "description": "Role to administrator",
            "permissions": [
                {
                    "key": "viewuser",
                    "name": "View User",
                    "description": "Permission to view user.",
                    "params": null,
                    "active": true
                },...
            ]
        },
        {
            "key": "user",
            "name": "user",
            "description": "Role to user",
            "permissions": [
                {
                    "key": "viewuser",
                    "name": "View User",
                    "description": "Permission to view user.",
                    "params": null,
                    "active": true
                },...
            ]
        }
    ]
 */
 
//@method allPermissions(): Collection 
return GuardShield::allPermissions();

/**
 * Returned array: 
 * [
        {
        "key": "viewuser",
        "name": "View User",
        "description": "Permission to view user.",
        "params": null,
        "active": true
        },
        {
        "key": "createuser",
        "name": "Create User",
        "description": "Permission to create user.",
        "params": null,
        "active": true
        },....
    ]
 */
 
//@method getPermission(array|string $permission): Collection 
return GuardShield::getPermission(['View User', 'Create User']);

/**
 * Returned array: 
 * [
        {
        "key": "viewuser",
        "name": "View User",
        "description": "Permission to view user.",
        "params": null,
        "active": true
        },
        {
        "key": "createuser",
        "name": "Create User",
        "description": "Permission to create user.",
        "params": null,
        "active": true
        }
    ]
 */

```

**Assign a rule group to a user**
```php

User::whereId($request->user_id)->assignRole("Administrator");

// OR

Auth::user()->assignRole("Administrator");

// OR

$request->user()->assignRole("Administrator");

```

**How to Use GuardShield**

```php
use Illuminate\Support\Facades\Gate;
use Larakeeps\GuardShield\Facades\GuardShield;

// Using Gates
if(Gate::allows('Edit User')){
    return "User contains the necessary permission to perform the action.";
}

// Check whether the user has the permission and whether the permission is part of a permission group.
if(Gate::allows('Edit User', "Administrator")){
    return "User contains the necessary permission to perform the action.";
}

//====================================================

// Using GuardShield
if(GuardShield::allows('Edit User')){
    return "User contains the necessary permission to perform the action.";
}

// Check if the user has the permission and if the permission is part of a permission group.
if(GuardShield::allows('Edit User', "Administrator")){
     return "User has the necessary permission to perform the action.";
}

//====================================================

// Using the Model
if(Auth::user()->hasRole("Administrator"))){
     return "User is part of the permission group.";
}

//====================================================

// Using Middleware to check permissions

Route::post("edit-user", function (\Illuminate\Http\Request $request){
    
      return "User has the necessary permission to perform the action."

})->middleware(['auth:sanctum', "can:Edit User,Delete User"]);


// Using Middleware to check permission group

Route::post("edit-user", function (\Illuminate\Http\Request $request){
    
      return "User is part of the permission group";

})->middleware(['auth:sanctum', "rolecan:admin,user"]);


```

#### Don't forget to follow me on github and star the project.

<br>

>### My contacts</kbd>
> >E-mail: douglassantos2127@gmail.com
> >
> >Linkedin: <a href='https://www.linkedin.com/in/douglas-da-silva-santos/' target='_blank'>Acessa Perfil</a>&nbsp;&nbsp;<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/linkedin/linkedin-original.svg" width="24">

