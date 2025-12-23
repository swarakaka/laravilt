---
title: Users Plugin Example
description: Complete RBAC plugin example
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
type: example
repository: https://github.com/laravilt/users
---

# Users Plugin Example

Production-ready user management plugin.

## Features

- Full RBAC with Spatie Permission
- User Management CRUD
- Role Management
- Impersonation
- Multi-language (EN/AR)
- Avatar Support

## Installation

```bash
composer require laravilt/users
php artisan migrate
php artisan users:install
```

## Registration

```php
<?php

use Laravilt\Users\UsersPlugin;

$panel->plugins([
    UsersPlugin::make()
        ->avatar()
        ->impersonation()
        ->emailVerification(),
]);
```

## Plugin Class

```php
<?php

namespace Laravilt\Users;

use Laravilt\Plugins\PluginProvider;
use Laravilt\Plugins\Contracts\Plugin;
use Laravilt\Plugins\Concerns\HasMigrations;
use Laravilt\Plugins\Concerns\HasTranslations;
use Laravilt\Panel\Panel;

class UsersPlugin extends PluginProvider implements Plugin
{
    use HasMigrations;
    use HasTranslations;

    protected static string $id = 'users';
    protected static string $name = 'Users';

    protected bool $hasAvatar = false;
    protected bool $hasImpersonation = false;

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\UserResource::class,
            Resources\RoleResource::class,
        ]);
    }

    public function avatar(bool $enabled = true): static
    {
        $this->hasAvatar = $enabled;
        return $this;
    }

    public function impersonation(bool $enabled = true): static
    {
        $this->hasImpersonation = $enabled;
        return $this;
    }
}
```

## User Traits

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravilt\Users\Concerns\HasRolesAndPermissions;
use Laravilt\Users\Concerns\HasAvatar;

class User extends Authenticatable
{
    use HasRolesAndPermissions;
    use HasAvatar;
}
```

## Related

- [Creating a Plugin](../tutorials/creating-a-plugin) - Tutorial
- [Plugin Traits](../concepts/traits) - Available concerns

