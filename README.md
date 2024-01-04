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

Segunda etapa adicione a trait e o parâmetro necessario a sua model. Abra `Models/User.php`
```php

use App\Traits\GuardShield\GuardShield;

class User extends Authenticatable
{
  use GuardShield, HasApiTokens, HasFactory;

  protected $with = ['roles'];

  //.... restanto do código da model
}
```

Terceira etapa, execute o migrate para criar as tabelas: ```guard_shield_roles, guard_shield_role_user, guard_shield_assigns, guard_shield_permissions```
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
```

**Como Usar o GuardShield**
```php


```

> segue abaixo as formas de utilização.
> > Use Auth::user()->hasRole('Administrador') para verificar se o usuário logado faz parte do grupo de regras: Administrador.
> > Use GuardShield::Allows("Delete User") para verificar se o **usuário logado** tem a **permissão** necessária para **executar a ação**.
> > Use GuardShield::Allows("Delete User", "Administrador") para verificar se o **usuário logado** tem a **permissão** necessária para executar a ação e se esta permissão faz parte do grupo de regras: **Administrador**.
