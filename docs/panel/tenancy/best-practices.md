---
title: Tenancy Best Practices
description: Tips and troubleshooting for tenancy
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Tenancy Best Practices

## Environment Configuration

```env
# Development
TENANCY_MODE=single
APP_DOMAIN=localhost

# Production
TENANCY_MODE=multi
APP_DOMAIN=myapp.com
```

## Reserved Subdomains

```php
'subdomain' => [
    'reserved' => [
        'www', 'api', 'admin', 'app',
        'mail', 'ftp', 'webmail', 'cpanel',
        'support', 'help', 'docs', 'status',
    ],
],
```

## Tenant-Aware Queues

```php
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravilt\Panel\Facades\Laravilt;
use Laravilt\Panel\Models\Tenant;

class ProcessOrder implements ShouldQueue
{
    public function __construct(
        public string $tenantId,
        public int $orderId,
    ) {}

    public function handle(): void
    {
        $tenant = Tenant::find($this->tenantId);
        Laravilt::setTenant($tenant);
        // Process in tenant context
    }
}
```

## Troubleshooting

### User Has No Teams

1. Check User implements `HasTenants`, `HasDefaultTenant`
2. Check User uses `HasTeams` trait
3. Check `current_team_id` is fillable
4. Verify `team_user` pivot table exists

### Tenant Not Found

1. Check domain configuration
2. Verify DNS for subdomains
3. Clear cache: `php artisan cache:clear`
4. Check `domains` table entries

### Database Connection Issues

1. Verify tenant database credentials
2. Check database exists
3. Verify user permissions
4. Check connection template

## Next Steps

- [Overview](overview) - Tenancy overview
- [Configuration](configuration) - Configuration options
- [Models](models) - Tenant and Domain models
