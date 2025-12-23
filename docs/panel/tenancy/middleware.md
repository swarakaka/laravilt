---
title: Tenancy Middleware
description: Middleware and routing for tenancy
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Tenancy Middleware

## Middleware Stack

### InitializeTenancyBySubdomain

For multi-database mode:

1. Extract subdomain from host
2. Check if reserved
3. Find tenant by domain/slug
4. Initialize tenant database
5. Set tenant context

### IdentifyTenant

For single-database mode:

1. Read tenant from route parameter
2. Set tenant context (no database switch)

## Route Naming

| Context | Prefix | Example |
|---------|--------|---------|
| Subdomain routes | `{panel}.subdomain.` | `admin.subdomain.dashboard` |
| Tenant settings | `{panel}.tenant.settings.` | `admin.tenant.settings.profile` |
| Central routes | `{panel}.` | `admin.dashboard` |

## Multi-Panel Support

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\Models\Tenant;
use App\Models\Team;

// Admin: multi-database
$adminPanel->multiDatabaseTenancy(Tenant::class, 'admin.myapp.com');

// Portal: single-database
$portalPanel->tenant(Team::class);

// Marketing: no tenancy
$marketingPanel->path('');
```

## Checking State

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel->hasTenancy();
        $panel->isMultiDatabaseTenancy();
        $panel->isSingleDatabaseTenancy();
        
        return  $panel;
    }
}
```

## Next Steps

- [Models](models) - Tenant and Domain models
- [Configuration](configuration) - Configuration options
- [Best Practices](best-practices) - Tips and troubleshooting
