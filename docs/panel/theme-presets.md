---
title: Theme Presets
description: Create reusable theme presets
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Theme Presets

Create reusable theme configurations.

## Creating a Preset

```php
namespace App\Laravilt\Themes;

use Laravilt\Panel\Panel;

class DarkBlueTheme
{
    public static function apply(Panel $panel): Panel
    {
        return $panel
            ->colors([
                'primary' => '#3b82f6',
                'secondary' => '#1e293b',
            ])
            ->font('Inter')
            ->darkMode(default: 'dark')
            ->css(['css/themes/dark-blue.css']);
    }
}
```

## Applying a Preset

```php
namespace App\Laravilt\Admin;

use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use App\Laravilt\Themes\DarkBlueTheme;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return DarkBlueTheme::apply($panel)
            ->id('admin')
            ->path('admin');
    }
}
```

## CSS Variables

Override CSS custom properties:

```css
:root {
    /* Colors */
    --color-primary-500: #6366f1;
    --color-secondary-500: #64748b;

    /* Typography */
    --font-family: 'Inter', sans-serif;
    --font-size-base: 0.875rem;

    /* Layout */
    --sidebar-width: 280px;
    --header-height: 64px;

    /* Spacing */
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;

    /* Border radius */
    --radius-md: 0.375rem;
    --radius-lg: 0.5rem;
}

/* Dark mode overrides */
.dark {
    --color-primary-500: #818cf8;
}
```

## Next Steps

- [Branding](branding) - Colors and fonts
- [Custom Assets](custom-assets) - CSS and JavaScript
- [Layout](layout) - Layout options
