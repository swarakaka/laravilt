---
title: Branding
description: Customize your panel's appearance
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Branding

Customize the look and feel of your Laravilt panel.

## Brand Name & Logo

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->brandName('My Admin Panel')
            ->brandLogo('/images/logo.svg')
            ->brandLogoHeight('2rem')
            ->favicon('/favicon.ico');
    }
}
```

## Colors

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->colors([
                'primary' => '#3b82f6',    // Blue - main actions
                'secondary' => '#64748b',  // Gray - secondary elements
                'success' => '#22c55e',    // Green - success states
                'warning' => '#f59e0b',    // Orange - warnings
                'danger' => '#ef4444',     // Red - errors, delete
                'info' => '#06b6d4',       // Cyan - information
            ]);
    }
}
```

### Using Tailwind Colors

```php
use Laravilt\Panel\Panel;
use Laravilt\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->colors([
                'primary' => Color::Blue,
                'secondary' => Color::Slate,
                'success' => Color::Green,
            ]);
    }
}
```

## Typography

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\FontProviders\GoogleFontProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->font(
                GoogleFontProvider::make('Inter')
                    ->weights([400, 500, 600, 700])
            );
    }
}
```

## Dark Mode

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Enable with toggle
        $panel->darkMode();
        
        // Default to dark
        $panel->darkMode(default: 'dark');
        
        // Force dark mode (no toggle)
        $panel->darkMode(enabled: true, toggle: false);
        
        return $panel;
    }
}
```

## Next Steps

- [Layout](layout) - Layout configuration
- [Custom Assets](custom-assets) - CSS and JavaScript
- [Theme Presets](theme-presets) - Create theme presets
