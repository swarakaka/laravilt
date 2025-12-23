---
title: Custom Assets
description: Add custom CSS and JavaScript to your panel
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Custom Assets

Add custom CSS and JavaScript to your panel.

## Custom CSS

```php
use Laravilt\Panel\Panel;

$panel->css([
    'css/admin-custom.css',
]);
```

### Multiple Files

```php
use Laravilt\Panel\Panel;

$panel->css([
    'css/admin-theme.css',
    'css/admin-overrides.css',
]);
```

## Custom JavaScript

```php
use Laravilt\Panel\Panel;

$panel->js([
    'js/admin-custom.js',
]);
```

### Scripts with Defer

```php
use Laravilt\Panel\Panel;

$panel->js([
    'js/analytics.js' => ['defer' => true],
]);
```

## Render Hooks

```php
use Laravilt\Panel\Panel;

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
```

### Conditional Hooks

```php
use Laravilt\Panel\Panel;

$panel->renderHook('content.start', function () {
    if (auth()->user()?->isAdmin()) {
        return '<div class="admin-notice">Admin Mode</div>';
    }
    return '';
});
```

## Next Steps

- [Theme Presets](theme-presets) - Create reusable themes
- [Branding](branding) - Colors and fonts
- [Layout](layout) - Layout options
