---
title: Discovery
description: Auto-discovery of resources, pages, and widgets
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Discovery

Laravilt automatically discovers your resources, pages, and widgets.

## Auto-Discovery

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->discoverPages(
                in: app_path('Laravilt/Admin/Pages'),
                for: 'App\\Laravilt\\Admin\\Pages'
            )
            ->discoverResources(
                in: app_path('Laravilt/Admin/Resources'),
                for: 'App\\Laravilt\\Admin\\Resources'
            )
            ->discoverClusters(
                in: app_path('Laravilt/Admin/Clusters'),
                for: 'App\\Laravilt\\Admin\\Clusters'
            )
            ->discoverWidgets(
                in: app_path('Laravilt/Admin/Widgets'),
                for: 'App\\Laravilt\\Admin\\Widgets'
            );
    }
}
```

## Automatic Discovery

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Discovers all in default locations
        return $panel->discoverAutomatically();
    }
}
```

## Manual Registration

```php
use Laravilt\Panel\Panel;
use App\Laravilt\Admin\Pages\Dashboard;
use App\Laravilt\Admin\Resources\UserResource;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->pages([
                Dashboard::class,
            ])
            ->resources([
                UserResource::class,
            ]);
    }
}
```

## Directory Structure

```
app/Laravilt/{PanelId}/
├── {PanelId}PanelProvider.php
├── Pages/
│   └── Dashboard.php
├── Resources/
│   └── UserResource/
│       ├── UserResource.php
│       ├── Form/UserForm.php
│       ├── Table/UserTable.php
│       └── Pages/
├── Clusters/
└── Widgets/
```

## Next Steps

- [Resources](concepts/resources) - CRUD resources
- [Pages](concepts/pages) - Custom pages
- [Navigation](concepts/navigation) - Navigation config
