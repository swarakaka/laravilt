---
title: Post-Migration
description: Checklist after migrating from Filament
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Post-Migration Checklist

## 1. Review Generated Files

```bash
ls -la app/Laravilt/Admin/Resources/
```

## 2. Update Panel Provider

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
            ->resources([
                \App\Laravilt\Admin\Resources\User\UserResource::class,
                \App\Laravilt\Admin\Resources\Post\PostResource::class,
            ]);
    }
}
```

## 3. Build Frontend Assets

```bash
npm run build
```

## 4. Test CRUD Operations

Test all create, read, update, delete operations.

## 5. Remove Filament (Optional)

```bash
composer remove filament/filament
```

## Manual Adjustments

### Custom Livewire Components

Rewrite as Vue components for Laravilt.

### Complex Relationships

Review and configure nested relationships manually.

### Custom Actions

Review actions with complex logic.

### Plugins

Filament plugins are not auto-converted. Check for Laravilt equivalents.

## Troubleshooting

### Source directory does not exist

```bash
ls app/Filament/Resources/
```

Use `--source` option if in different location.

### Namespace Conflicts

Use `--force` to overwrite or merge manually.

### Missing Icon Mappings

```php
// Update manually
protected static ?string $navigationIcon = 'Star';
```

## Next Steps

- [Overview](overview) - Migration basics
- [Namespace Mappings](namespace-mappings) - Class mappings
