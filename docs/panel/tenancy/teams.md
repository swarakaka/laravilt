---
title: Teams Tenancy
description: Using teams as tenants
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Teams Tenancy

Use your existing Team model as tenants.

## Quick Start

```bash
php artisan vendor:publish --tag=laravilt-teams-migration
php artisan vendor:publish --tag=laravilt-teams-model
php artisan vendor:publish --tag=laravilt-teams-trait
php artisan migrate
```

## User Model Setup

```php
namespace App\Models;

use App\Concerns\HasTeams;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravilt\Panel\Contracts\HasDefaultTenant;
use Laravilt\Panel\Contracts\HasTenants;

class User extends Authenticatable implements HasTenants, HasDefaultTenant
{
    use HasTeams;

    protected $fillable = [
        'name',
        'email',
        'password',
        'current_team_id',
    ];
}
```

## Team Model Setup

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravilt\Panel\Contracts\HasTenantName;

class Team extends Model implements HasTenantName
{
    public function getTenantName(): string
    {
        return $this->name;
    }

    public function getTenantAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}
```

## Panel Configuration

```php
use Laravilt\Panel\Panel;
use App\Models\Team;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->tenant(Team::class, 'team', 'slug')
            ->tenantRegistration()
            ->tenantProfile();
    }
}
```

## Required Interfaces

- `HasTenants` - provides `getTenants()` and `canAccessTenant()`
- `HasDefaultTenant` - provides `getDefaultTenant()`
- `HasTenantName` - provides `getTenantName()`

## Next Steps

- [Configuration](configuration) - Detailed configuration
- [Models](models) - Tenant and Domain models
- [Best Practices](best-practices) - Tips and troubleshooting
