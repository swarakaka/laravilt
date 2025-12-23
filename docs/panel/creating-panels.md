---
title: Creating Panels
description: Create and configure admin panels
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Creating Panels

## Using Artisan Command

```bash
php artisan laravilt:panel admin
```

This launches an interactive wizard:

```
┌ What features do you want to enable? ─────────────┐
│ ◼ Login                                           │
│ ◼ Registration                                    │
│ ◻ Two-Factor Authentication                       │
│ ◻ Social Authentication                           │
│ ◻ Passkeys (WebAuthn)                            │
└───────────────────────────────────────────────────┘
```

### Command Options

```bash
# Specify path
php artisan laravilt:panel admin --path=dashboard

# Quick creation (skip prompts)
php artisan laravilt:panel admin --quick
```

## Manual Creation

```php
namespace App\Laravilt\Admin;

use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors(['primary' => '#3b82f6'])
            ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
            ->discoverPages(in: app_path('Laravilt/Admin/Pages'));
    }
}
```

Register in `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Laravilt\Admin\AdminPanelProvider::class,
];
```

## Basic Settings

```php
use Laravilt\Panel\Panel;
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')           // Unique identifier
            ->path('admin')         // URL path prefix
            ->middleware(['web', 'auth'])
            ->maxContentWidth('7xl');
    }
}
```

## Next Steps

- [Branding](branding) - Customize appearance
- [Panel Auth](panel-auth) - Authentication settings
- [Discovery](discovery) - Auto-discovery configuration
