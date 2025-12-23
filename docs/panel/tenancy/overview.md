---
title: Multi-Tenancy Overview
description: Build SaaS applications with Laravilt
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Multi-Tenancy Overview

Build SaaS applications with tenant isolation.

## Tenancy Modes

| Mode | Description | Routing |
|------|-------------|---------|
| **Single Database** | Shared database with `tenant_id` scoping | Path: `/panel/{tenant}/...` |
| **Multi-Database** | Isolated database per tenant | Subdomain: `tenant.domain.com` |

## Installation

```bash
php artisan vendor:publish --tag=laravilt-tenancy-config
php artisan vendor:publish --tag=laravilt-tenancy-migrations
php artisan migrate
```

## Single Database Mode

```php
use Laravilt\Panel\Panel;
use App\Models\Team;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->tenant(Team::class, 'team', 'slug')
            ->tenantProfile()
            ->tenantRegistration();
    }
}
```

Routing: `/admin/{team}/dashboard`

## Multi-Database Mode

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\Models\Tenant;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->multiDatabaseTenancy(Tenant::class, 'myapp.com');
    }
}
```

Routing: `acme.myapp.com/admin/dashboard`

## When to Use Each Mode

**Single Database:**
- Small to medium apps
- Minimal database overhead
- Tenants may share some data

**Multi-Database:**
- Enterprise SaaS
- Strict data isolation
- Compliance (HIPAA, SOC2)

## Next Steps

- [Teams Tenancy](teams) - Using teams as tenants
- [Configuration](configuration) - Detailed configuration
- [Models](models) - Tenant and Domain models
