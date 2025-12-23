---
title: Panel Provider
description: Configure your panel with the Panel Provider
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Panel Provider

Each panel has a provider that configures it.

## Basic Configuration

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
            ->registration()
            ->colors(['primary' => '#3b82f6'])
            ->brandName('My Admin')
            ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
            ->discoverPages(in: app_path('Laravilt/Admin/Pages'))
            ->discoverWidgets(in: app_path('Laravilt/Admin/Widgets'));
    }
}
```

## Panel Facade

```php
use Laravilt\Panel\Facades\Panel;

// Get current panel
$panel = Panel::getCurrent();

// Get specific panel
$adminPanel = Panel::get('admin');

// Get all panels
$allPanels = Panel::all();

// Check if panel exists
Panel::has('admin');
```

## Configuration File

Publish and customize `config/laravilt-panel.php`:

```php
return [
    'path' => env('LARAVILT_PANEL_PATH', 'admin'),
    'middleware' => ['web', 'auth'],
    'colors' => [
        'primary' => '#6366f1',
    ],
    'brand_name' => env('APP_NAME', 'Laravilt'),
    'max_content_width' => '7xl',
];
```

## Publishing Assets

```bash
php artisan vendor:publish --tag=laravilt-panel-config
php artisan vendor:publish --tag=laravilt-panel-views
php artisan vendor:publish --tag=laravilt-panel-lang
```

## Next Steps

- [Creating Panels](creating-panels) - Create new panels
- [Branding](branding) - Customize appearance
- [Panel Auth](panel-auth) - Configure auth
