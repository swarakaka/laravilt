---
title: Layout
description: Configure panel layout options
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Layout

Configure the layout of your Laravilt panel.

## Max Content Width

```php
use Laravilt\Panel\Panel;

// Tailwind width classes
$panel->maxContentWidth('7xl');  // Default

// Options: sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, full
$panel->maxContentWidth('full');  // Full width
```

## Sidebar

```php
use Laravilt\Panel\Panel;

// Custom width
$panel->sidebarWidth('280px');

// Enable collapse
$panel->sidebarCollapsibleOnDesktop();

// Start collapsed
$panel->sidebarCollapsibleOnDesktop(collapsed: true);
```

## Localization

```php
use Laravilt\Panel\Panel;

$panel
    ->locales([
        'en' => 'English',
        'ar' => 'العربية',
        'es' => 'Español',
        'fr' => 'Français',
    ])
    ->defaultLocale('en')
    ->localeDetection(true);  // Detect from browser
```

## Locale & Timezone

```php
use Laravilt\Panel\Panel;

$panel->localeTimezone();  // Enable user locale/timezone settings
```

## RTL Support

RTL is auto-detected for Arabic, Hebrew, Persian:

```php
use Laravilt\Panel\Panel;

$panel->locales([
    'en' => 'English',
    'ar' => 'Arabic',      // RTL
    'he' => 'Hebrew',      // RTL
]);
```

## Next Steps

- [Branding](branding) - Colors and fonts
- [Custom Assets](custom-assets) - CSS and JavaScript
- [Creating Panels](creating-panels) - Panel basics
