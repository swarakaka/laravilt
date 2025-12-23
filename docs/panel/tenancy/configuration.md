---
title: Tenancy Configuration
description: Configure multi-tenancy settings
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Tenancy Configuration

## Panel Configuration

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\Models\Tenant;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel
            ->multiDatabaseTenancy(Tenant::class, 'myapp.com')
            ->tenantModels([
                \App\Models\Customer::class,
                \App\Models\Product::class,
            ])
            ->centralModels([
                \App\Models\User::class,
                \App\Models\Plan::class,
            ])
            ->tenantRegistration()
            ->tenantProfile()
            ->tenantMenu();
    }
}
```

## Configuration File

`config/laravilt-tenancy.php`:

```php
return [
    'mode' => env('TENANCY_MODE', 'single'),

    'central' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
        'domains' => ['localhost', env('APP_CENTRAL_DOMAIN')],
    ],

    'tenant' => [
        'database_prefix' => env('TENANT_DB_PREFIX', 'tenant_'),
        'migrations_path' => database_path('migrations/tenant'),
    ],

    'subdomain' => [
        'domain' => env('APP_DOMAIN', 'localhost'),
        'reserved' => ['www', 'api', 'admin', 'app', 'mail'],
    ],

    'cache' => [
        'enabled' => true,
        'ttl' => 3600,
    ],
];
```

## Environment Variables

```env
TENANCY_MODE=multi
APP_DOMAIN=myapp.com
TENANT_DB_PREFIX=tenant_
TENANT_DB_CONNECTION=mysql
```

## Panel Methods

| Method | Description |
|--------|-------------|
| `tenant(Model, ?relationship, ?slug)` | Single-database tenancy |
| `multiDatabaseTenancy(Model, domain)` | Multi-database tenancy |
| `tenantModels(array)` | Models using tenant database |
| `centralModels(array)` | Models using central database |
| `tenantRegistration()` | Enable tenant signup |
| `tenantProfile()` | Enable team settings |
| `tenantMenu()` | Show tenant switcher |

## Next Steps

- [Models](models) - Tenant and Domain models
- [Middleware](middleware) - Tenancy middleware
- [Best Practices](best-practices) - Tips and troubleshooting
