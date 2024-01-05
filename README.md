**GuardShield**
> GuardShield é um repositório laravel com a função de aplicar regras de permissionamento, utilizando agrupamento de regras e permissões.
> segue abaixo o passo a passo para instalar o repositório.

### Este repositório é compativel apenas com laravel: `9.*` and `10.*`

## Instalação

Primeira etapa, copie todo os arquivos para a pasta raiz do seu projeto laravel e adicione o service provider. Abra `config/app.php` e adicione um novo item ao array de providers.

```php
'providers' => [
    // ...
    App\Providers\GuardShieldServiceProvider::class,
]
```

Segunda etapa, adicione o middleware. Abra `app/Http/Kernel.php` e adicione um novo item ao array de middlewareAliases.

```php
protected $middlewareAliases = [
    // ...
    'rolecan' => \App\Http\Middleware\GuardShieldTrustRole::class,
]
```

Terceira etapa adicione a trait e o parâmetro necessario a sua model. Abra `Models/User.php`

```php

use App\Traits\GuardShield;

class User extends Authenticatable
{
  use GuardShield, HasApiTokens, HasFactory;

  protected $with = ['roles'];

  //.... restanto do código da model
}
```

Quarta etapa, execute o migrate para criar as tabelas: ```guard_shield_roles, guard_shield_role_user, guard_shield_assigns, guard_shield_permissions```
```shell script
php artisan migrate
```


**Criando Grupo de Regras e Permissões**
```php
use \App\Models\GuardShieldRole;
use \App\Models\GuardShieldPermission;

$role = GuardShieldRole::new("Administrador", "Grupo de regra para administradores."); // Criando um novo grupo de permissões
$permission = GuardShieldPermission::new("Editar Usuário", "Permissão para editar usuário"); // Criando uma nova permissão
$role->assignPermission($permission); // Vinculando a permissão a um grupo de permissões.



//Criando uma Regra, permissões e Vinculando as permissões criadas ao grupo de permissões.

$permissions = [
    ["Visualizar Usuário", "Permissão para visualizar usuário"],
    ["Criar Usuário", "Permissão para criar usuário"],
    ["Editar Usuário", "Permissão para editar usuário"],
    ["Deletar Usuário", "Permissão para deletar usuário"],
];

GuardShieldRole::newRoleAndPermissions("Administrador", "Grupo de regra para administradores.", $permissions);



//Criando uma Regra e Vinculando as permissões já existente ao grupo de permissões criado.

$permissions = ["Visualizar Usuário", "Criar Usuário", "Editar Usuário", "Deletar Usuário"];

GuardShieldRole::newRoleAndAssignPermissions("Administrador", "Grupo de regra para administradores.", $permissions);

// Ativando e Desativando uma permissão

GuardShieldPermission::setActive("Visualizar Usuário", false);


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
use App\Facades\GuardShieldService;

// Usando Gates
if(Gate::allows('Editar Usuário')){
    return "Usuário contem a permissão necessária para executar a ação."
}

// Verificar se o usuário tem a permissão e se a permissão faz parte de um grupo de permissões
if(Gate::allows('Editar Usuário')){
    return "Usuário contem a permissão necessária para executar a ação."
}

//====================================================

// Usando GuardShield
if(GuardShieldService::allows('Editar Usuário')){
    return "Usuário contem a permissão necessária para executar a ação."
}

// Verificar se o usuário tem a permissão e se a permissão faz parte de um grupo de permissões
if(GuardShieldService::allows('Editar Usuário', "Administrador")){
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

