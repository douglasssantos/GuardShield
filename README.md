**GuardShield**
> GuardShield é um repositório laravel com a função de aplicar regras de permissionamento, utilizando agrupamento de regras e permissões.
> segue abaixo o passo a passo para instalar o repositório.

> > Passo 1: Copie todo os arquivos para a pasta raiz do seu projeto laravel,
> > 
> > Passo 2: adicione a classe ```GuardShieldServiceProvider::class``` ao app.php que fica localizado em config/app.php.
> > 
> > Passo 3: adicione a trait ( GuardShield ) e o parâmetro ( protected $with = ['roles']; ) a model User.php localizado em Models/User.php
> > 
> > Passo 4: execute o comando php artisan migrate, para criar as tabelas: guard_shield_roles, guard_shield_role_user, guard_shield_assigns, guard_shield_permissions

**Como Usar o GuardShield**
> segue abaixo as formas de utilização.
> > Use Auth::user()->hasRole('Administrador') para verificar se o usuário logado faz parte do grupo de regras: Administrador.
> > Use GuardShield::Allows("Delete User") para verificar se o **usuário logado** tem a **permissão** necessária para **executar a ação**.
> > Use GuardShield::Allows("Delete User", "Administrador") para verificar se o **usuário logado** tem a **permissão** necessária para executar a ação e se esta permissão faz parte do grupo de regras: **Administrador**.
