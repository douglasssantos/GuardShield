**GuardShield**
> GuardShield é um repositório laravel com a função de aplicar regras de permissionamento, utilizando agrupamento de regras e permissões.
> segue abaixo o passo a passo para instalar o repositório.
> 
> GuardShield is a laravel repository with the function of applying permission rules, using grouping of rules and permissions.
> follow the step-by-step instructions below to install the repository.

### Este repositório é compativel apenas com laravel: `8.*` à `10.*`



## Instalação


Primeira Etapa, execute o comando.

```shell script
composer require larakeeps/guard-shield
```

Segunda etapa, adicione o service provider. Abra `app/Providers/AuthServiceProvider.php` o método `GuardShield::generateGates()` no `public function boot()` do Service Provider.

```php
use Larakeeps\GuardShield\Facades\GuardShield;

class AuthServiceProvider extends ServiceProvider
{
    
        
    public function boot(): void
    {
        GuardShield::generateGates();
        
        //restante do seu código......
    }
}
```

Terceira etapa, adicione o middleware. Abra `app/Http/Kernel.php` e adicione um novo item ao array de middlewareAliases.

```php
protected $middlewareAliases = [
    // ...
    'rolecan' => \Larakeeps\GuardShield\Http\Middleware\GuardShieldTrustRole::class,
]
```

Quarta etapa adicione a trait e o parâmetro necessario a sua model. Abra `Models/User.php`

```php

use Larakeeps\GuardShield\Traits\GuardShield;

class User extends Authenticatable
{
  use GuardShield, HasApiTokens, HasFactory;

  protected $with = ['roles'];

  //.... restanto do código da model
}
```

Quinta etapa, execute o migrate para criar as tabelas: ```guard_shield_roles, guard_shield_role_user, guard_shield_assigns, guard_shield_permissions```
```shell script
php artisan migrate
```


**Criando Grupo de Regras e Permissões Utilizando Model**

```php
use \Larakeeps\GuardShield\Models\Role;
use \Larakeeps\GuardShield\Models\Permission;

$role = Role::new("Administrador", "Grupo de regra para administradores."); // Criando um novo grupo de permissões
$permission = Permission::new("Editar Usuário", "Permissão para editar usuário"); // Criando uma nova permissão
$role->assignPermission($permission); // Vinculando a permissão a um grupo de permissões.



//Criando uma Regra, permissões e Vinculando as permissões criadas ao grupo de permissões.

$permissions = [
    ["Visualizar Usuário", "Permissão para visualizar usuário"],
    ["Criar Usuário", "Permissão para criar usuário"],
    ["Editar Usuário", "Permissão para editar usuário"],
    ["Deletar Usuário", "Permissão para deletar usuário"],
];

Role::newRoleAndPermissions("Administrador", "Grupo de regra para administradores.", $permissions);



//Criando uma Regra e Vinculando as permissões já existente ao grupo de permissões criado.

$permissions = ["Visualizar Usuário", "Criar Usuário", "Editar Usuário", "Deletar Usuário"];

Role::newRoleAndAssignPermissions("Administrador", "Grupo de regra para administradores.", $permissions);

// Ativando e Desativando uma permissão

Permission::setActive("Visualizar Usuário", false);


```

**Criando Grupo de Regras e Permissões Utilizando Facade**
```php
use Larakeeps\GuardShield\Facades\GuardShield;

$role = GuardShield::newRole("Administrador", "Grupo de regra para administradores."); // Criando um novo grupo de permissões
$permission = GuardShield::newPermission("Editar Usuário", "Permissão para editar usuário"); // Criando uma nova permissão
$role->assignPermission($permission); // Vinculando a permissão a um grupo de permissões.

// OU

GuardShield::assignPermission($role, $permission);



//Criando uma Regra, permissões e Vinculando as permissões criadas ao grupo de permissões.

$permissions = [
    ["Visualizar Usuário", "Permissão para visualizar usuário"],
    ["Criar Usuário", "Permissão para criar usuário"],
    ["Editar Usuário", "Permissão para editar usuário"],
    ["Deletar Usuário", "Permissão para deletar usuário"],
];

GuardShield::newRoleAndPermissions("Administrador", "Grupo de regra para administradores.", $permissions);



//Criando uma Regra e Vinculando as permissões já existente ao grupo de permissões criado.

$permissions = ["Visualizar Usuário", "Criar Usuário", "Editar Usuário", "Deletar Usuário"];

GuardShield::newRoleAndAssignPermissions("Administrador", "Grupo de regra para administradores.", $permissions);

// Ativando e Desativando uma permissão

GuardShield::setActivePermission("Visualizar Usuário", false);


```

**Verificando a existencia dos grupos de regras e permissões criadas.**
```php
use Larakeeps\GuardShield\Facades\GuardShield;

$hasPermission = ["view.user", "create.user", "update.user", "delete.user"];

/** 
 * 
 * Poder um ou mais regras passando um array como paramêtro 
 * O mesmo vale para as permissões
 * @method static bool hasRoleAndPermission(string|array $role, string|array $permission)
 * 
 * */
$hasRolesAndPermissions = !GuardShield::hasRoleAndPermission('user' , $hasPermission);

if($hasRolesAndPermissions){
    return "O Grupo de regras e as permissão existem."
}


/** 
 * 
 * Verifique se uma ou mais grupos de regras existem. 
 * @method static bool hasRole(string|array $role)
 * 
 * */
$hasRoles = !GuardShield::hasRole(['administrator', 'user']);

if($hasRoles){
    return "Os Grupos de regras existem."
}


/** 
 * 
 * Verifique se uma ou mais grupos de regras existem. 
 * @method static bool hasPermission(string|array $role)
 * 
 * */
 
$permissions = ["view.user", "create.user", "update.user", "delete.user"];
$hasPermission = !GuardShield::hasPermission($permissions);

if($hasPermission){
    return "As permissões existem."
}

//Metodos Unless para validação.




```

**Visualizando as regras e permissões criadas**
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
                    "name": "view.user",
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
                    "name": "view.user",
                    "description": "Permission to view user.",
                    "params": null,
                    "active": true
                },.....
            ]
        }
    ]
 */
 
// @method getRole(array|string $role): Collection
return GuardShield::getRole();

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
                    "name": "view.user",
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
                    "name": "view.user",
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
        "name": "view.user",
        "description": "Permission to view user.",
        "params": null,
        "active": true
        },
        {
        "key": "createuser",
        "name": "create.user",
        "description": "Permission to create user.",
        "params": null,
        "active": true
        },....
    ]
 */
 
//@method getPermission(array|string $permission): Collection 
return GuardShield::getPermission(['view.user', 'create.user']);

/**
 * Returned array: 
 * [
        {
        "key": "viewuser",
        "name": "view.user",
        "description": "Permission to view user.",
        "params": null,
        "active": true
        },
        {
        "key": "createuser",
        "name": "create.user",
        "description": "Permission to create user.",
        "params": null,
        "active": true
        }
    ]
 */

```

**Atribuir um grupo de regras a usuário**
```php

User::whereId($request->user_id)->assignRole("Administrador");

// OU

Auth::user()->assignRole("Administrador");

// OU

$request->user()->assignRole("Administrador");

```

**Como Usar o GuardShield**

```php
use Illuminate\Support\Facades\Gate;
use Larakeeps\GuardShield\Facades\GuardShield;

// Usando Gates
if(Gate::allows('Editar Usuário')){
    return "Usuário contem a permissão necessária para executar a ação."
}

// Verificar se o usuário tem a permissão e se a permissão faz parte de um grupo de permissões
if(Gate::allows('Editar Usuário', "Administrador")){
    return "Usuário contem a permissão necessária para executar a ação."
}

//====================================================

// Usando GuardShield
if(GuardShield::allows('Editar Usuário')){
    return "Usuário contem a permissão necessária para executar a ação."
}

// Verificar se o usuário tem a permissão e se a permissão faz parte de um grupo de permissões
if(GuardShield::allows('Editar Usuário', "Administrador")){
    return "Usuário contem a permissão necessária para executar a ação."
}

//====================================================

// Usando o Model
if(Auth::user()->hasRole("Administrador"))){
    return "Usuário faz parte do grupo de permissões."
}

//====================================================

// Usando Middleware para verificar as permissões

Route::post("edit-user", function (\Illuminate\Http\Request $request){
    
     return "Usuário contem a permissão necessária para executar a ação."

})->middleware(['auth:sanctum', "can:Editar Usuário,Deletar Usuário"]);


// Usando Middleware para verificar o grupo de permissões

Route::post("edit-user", function (\Illuminate\Http\Request $request){
    
     return "Usuário faz parte do grupo de permissões";

})->middleware(['auth:sanctum', "rolecan:admin,user"]);



```

#### Não esqueça de me seguir github e marcar uma estrela no projeto.

<br>

>### Meus Contatos</kbd>
> >E-mail: douglassantos2127@gmail.com
> >
> >Linkedin: <a href='https://www.linkedin.com/in/douglas-da-silva-santos/' target='_blank'>Acessa Perfil</a>&nbsp;&nbsp;<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/linkedin/linkedin-original.svg" width="24">
> >
> >GeekHunter: <a href='https://www.linkedin.com/in/douglas-da-silva-santos/' target='_blank'>Acessa Perfil</a>&nbsp;&nbsp;<img src="https://www.geekhunter.com.br/_next/static/media/geek-logo.5e162598.svg" width="120">

