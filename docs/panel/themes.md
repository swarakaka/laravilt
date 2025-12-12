# Themes & Branding

Customize the look and feel of your Laravilt panel with colors, fonts, logos, and custom CSS.

## Branding

### Brand Name

```php
$panel->brandName('My Admin Panel');
```

### Logo

```php
// Light mode logo
$panel->brandLogo('/images/logo.svg');

// Dark mode logo
$panel->darkModeBrandLogo('/images/logo-dark.svg');

// Logo height
$panel->brandLogoHeight('2rem');
```

### Favicon

```php
$panel->favicon('/favicon.ico');

// Or use asset helper
$panel->favicon(asset('images/favicon.png'));
```

---

## Colors

### Primary Color

```php
// Single color
$panel->colors([
    'primary' => '#3b82f6',
]);
```

### Full Color Palette

```php
$panel->colors([
    'primary' => '#3b82f6',    // Blue - main actions, links
    'secondary' => '#64748b',  // Gray - secondary elements
    'success' => '#22c55e',    // Green - success states
    'warning' => '#f59e0b',    // Orange - warnings
    'danger' => '#ef4444',     // Red - errors, delete
    'info' => '#06b6d4',       // Cyan - information
]);
```

### Using Tailwind Colors

```php
use Laravilt\Support\Colors\Color;

$panel->colors([
    'primary' => Color::Blue,
    'secondary' => Color::Slate,
    'success' => Color::Green,
    'warning' => Color::Amber,
    'danger' => Color::Red,
]);
```

### Custom Color with Shades

```php
$panel->colors([
    'primary' => [
        50 => '#eff6ff',
        100 => '#dbeafe',
        200 => '#bfdbfe',
        300 => '#93c5fd',
        400 => '#60a5fa',
        500 => '#3b82f6',
        600 => '#2563eb',
        700 => '#1d4ed8',
        800 => '#1e40af',
        900 => '#1e3a8a',
        950 => '#172554',
    ],
]);
```

---

## Typography

### Font Family

```php
// Google Fonts
$panel->font('Inter');

// With font provider
use Laravilt\Panel\FontProviders\GoogleFontProvider;

$panel->font('Inter')
      ->fontProvider(GoogleFontProvider::class);
```

### Popular Font Choices

```php
// Modern sans-serif
$panel->font('Inter');
$panel->font('Nunito');
$panel->font('Poppins');

// Professional
$panel->font('IBM Plex Sans');
$panel->font('Source Sans Pro');

// Readable
$panel->font('Open Sans');
$panel->font('Roboto');
```

### Local Fonts

```php
use Laravilt\Panel\FontProviders\LocalFontProvider;

$panel->font('CustomFont')
      ->fontProvider(LocalFontProvider::class)
      ->fontUrl('/fonts/custom-font.woff2');
```

---

## Dark Mode

### Enable Dark Mode

```php
// Enable with toggle
$panel->darkMode();

// Enable with toggle, default to dark
$panel->darkMode(default: 'dark');

// Force dark mode (no toggle)
$panel->darkMode(enabled: true, toggle: false);

// Disable dark mode
$panel->darkMode(enabled: false);
```

### Dark Mode Options

```php
$panel->darkMode(
    enabled: true,      // Enable dark mode support
    toggle: true,       // Show toggle in UI
    default: 'system',  // 'light', 'dark', or 'system'
);
```

---

## Layout

### Max Content Width

```php
// Tailwind width classes
$panel->maxContentWidth('7xl');  // Default

// Options: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl', 'full'
$panel->maxContentWidth('full');  // Full width
```

### Sidebar Width

```php
// Custom sidebar width
$panel->sidebarWidth('280px');
```

### Sidebar Collapsibility

```php
// Collapsible sidebar
$panel->sidebarCollapsibleOnDesktop();

// Start collapsed
$panel->sidebarCollapsibleOnDesktop(collapsed: true);
```

---

## Custom CSS

### Adding Custom Styles

```php
$panel->css([
    'css/admin-custom.css',
]);
```

### Multiple CSS Files

```php
$panel->css([
    'css/admin-theme.css',
    'css/admin-overrides.css',
]);
```

### Inline Styles

```php
$panel->renderHook(
    'head.end',
    fn () => '<style>
        .panel-header { background: linear-gradient(to right, #3b82f6, #8b5cf6); }
    </style>'
);
```

---

## Custom JavaScript

### Adding Custom Scripts

```php
$panel->js([
    'js/admin-custom.js',
]);
```

### Scripts with Defer

```php
$panel->js([
    'js/analytics.js' => ['defer' => true],
]);
```

---

## Render Hooks

Insert custom content at specific locations:

### Available Hooks

```php
// Head section
$panel->renderHook('head.start', fn () => '<meta name="robots" content="noindex">');
$panel->renderHook('head.end', fn () => '<link rel="stylesheet" href="/custom.css">');

// Body section
$panel->renderHook('body.start', fn () => '<div id="loading-overlay"></div>');
$panel->renderHook('body.end', fn () => '<script src="/analytics.js"></script>');

// Sidebar
$panel->renderHook('sidebar.start', fn () => '<div class="sidebar-banner">Beta</div>');
$panel->renderHook('sidebar.end', fn () => view('partials.sidebar-footer'));

// Content area
$panel->renderHook('content.start', fn () => '<div class="announcement-bar">...</div>');
$panel->renderHook('content.end', fn () => '<div class="help-widget">...</div>');
```

### Using Views

```php
$panel->renderHook('sidebar.end', fn () => view('admin.partials.sidebar-footer'));
```

### Conditional Hooks

```php
$panel->renderHook('content.start', function () {
    if (auth()->user()?->isAdmin()) {
        return '<div class="admin-notice">Admin Mode</div>';
    }
    return '';
});
```

---

## Theme Presets

### Creating a Theme Preset

```php
// app/Laravilt/Themes/DarkBlueTheme.php
<?php

namespace App\Laravilt\Themes;

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

### Applying a Theme

```php
use App\Laravilt\Themes\DarkBlueTheme;

public function panel(Panel $panel): Panel
{
    return DarkBlueTheme::apply($panel)
        ->id('admin')
        ->path('admin');
}
```

---

## RTL Support

Laravilt automatically supports RTL (Right-to-Left) languages:

```php
// RTL is auto-detected based on locale
// Arabic, Hebrew, Persian, etc. automatically use RTL

// Supported RTL locales
$panel->locales([
    'en' => 'English',
    'ar' => 'Arabic',      // RTL
    'he' => 'Hebrew',      // RTL
    'fa' => 'Persian',     // RTL
]);
```

### RTL-Aware CSS

When writing custom CSS, use logical properties:

```css
/* Instead of left/right, use start/end */
.my-element {
    margin-inline-start: 1rem;  /* margin-left in LTR, margin-right in RTL */
    margin-inline-end: 0.5rem;  /* margin-right in LTR, margin-left in RTL */
    padding-inline: 1rem;       /* horizontal padding */
}

/* Instead of specific directions */
.my-element {
    text-align: start;  /* left in LTR, right in RTL */
    border-inline-start: 2px solid blue;
}
```

---

## Localization

### Available Locales

```php
$panel->locales([
    'en' => 'English',
    'ar' => 'العربية',
    'es' => 'Español',
    'fr' => 'Français',
    'de' => 'Deutsch',
]);
```

### Default Locale

```php
$panel->defaultLocale('en');
```

### Locale Detection

```php
$panel->localeDetection(true);  // Detect from browser
```

---

## Complete Theme Example

```php
<?php

namespace App\Laravilt\Admin;

use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use Laravilt\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')

            // Branding
            ->brandName('Acme Admin')
            ->brandLogo('/images/logo.svg')
            ->darkModeBrandLogo('/images/logo-white.svg')
            ->brandLogoHeight('2rem')
            ->favicon('/favicon.ico')

            // Colors
            ->colors([
                'primary' => Color::Indigo,
                'secondary' => Color::Slate,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Rose,
                'info' => Color::Sky,
            ])

            // Typography
            ->font('Inter')

            // Dark Mode
            ->darkMode(
                enabled: true,
                toggle: true,
                default: 'system'
            )

            // Layout
            ->maxContentWidth('7xl')
            ->sidebarCollapsibleOnDesktop()

            // Localization
            ->locales([
                'en' => 'English',
                'ar' => 'العربية',
            ])
            ->defaultLocale('en')

            // Custom Assets
            ->css([
                'css/admin.css',
            ])
            ->js([
                'js/admin.js',
            ])

            // Render Hooks
            ->renderHook('head.end', fn () => '
                <meta name="theme-color" content="#6366f1">
            ')
            ->renderHook('body.end', fn () => '
                <script>
                    console.log("Admin panel loaded");
                </script>
            ')

            // Other configuration...
            ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
            ->discoverPages(in: app_path('Laravilt/Admin/Pages'));
    }
}
```

---

## CSS Variables

Laravilt uses CSS custom properties that you can override:

```css
:root {
    /* Colors */
    --color-primary-500: #6366f1;
    --color-secondary-500: #64748b;
    --color-success-500: #22c55e;
    --color-warning-500: #f59e0b;
    --color-danger-500: #ef4444;

    /* Typography */
    --font-family: 'Inter', sans-serif;
    --font-size-base: 0.875rem;

    /* Layout */
    --sidebar-width: 280px;
    --header-height: 64px;
    --content-max-width: 80rem;

    /* Spacing */
    --spacing-xs: 0.25rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;

    /* Border radius */
    --radius-sm: 0.25rem;
    --radius-md: 0.375rem;
    --radius-lg: 0.5rem;
    --radius-xl: 0.75rem;

    /* Shadows */
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
}

/* Dark mode overrides */
.dark {
    --color-primary-500: #818cf8;
    /* ... */
}
```

---

## Next Steps

- [Panel Introduction](introduction.md) - Panel overview
- [Creating Panels](creating-panels.md) - Panel configuration
- [Navigation](navigation.md) - Navigation customization
