---
title: Tenant Models
description: Tenant and Domain models
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Tenant Models

## Tenant Model

```php
use Laravilt\Panel\Models\Tenant;

$tenant = Tenant::create([
    'name' => 'Acme Corp',
    'slug' => 'acme',
    'email' => 'admin@acme.com',
    'owner_id' => $user->id,
]);
```

### Key Attributes

| Attribute | Type | Description |
|-----------|------|-------------|
| `id` | ULID | Primary key |
| `name` | string | Display name |
| `slug` | string | URL identifier |
| `database` | string | Database name |
| `owner_id` | int | Owner user ID |
| `settings` | array | Tenant settings |

### Methods

```php
use Laravilt\Panel\Models\Tenant;

// Relationships
$tenant->owner;
$tenant->users();
$tenant->domains();

// User management
$tenant->addUser($user, 'admin');
$tenant->removeUser($user);
$tenant->isOwner($user);

// Settings
$tenant->getSetting('feature.enabled', false);
$tenant->setSetting('feature.enabled', true);
```

## Domain Model

```php
use Laravilt\Panel\Models\Domain;

$domain = Domain::createSubdomain(
    tenant: $tenant,
    subdomain: 'acme',
    baseDomain: 'myapp.com',
    isPrimary: true
);

$tenant = Domain::findTenantByDomain('acme.myapp.com');
```

## Getting Current Tenant

```php
use Laravilt\Panel\Facades\Laravilt;

$tenant = Laravilt::getTenant();

if (Laravilt::hasTenant()) {
    $name = Laravilt::getTenant()->name;
}
```

## Next Steps

- [Middleware](middleware) - Tenancy middleware
- [Configuration](configuration) - Configuration options
- [Best Practices](best-practices) - Tips and troubleshooting
