# Panel Introduction

The Panel package is the core integration layer of Laravilt. It orchestrates all other packages to provide a complete admin dashboard framework built on Laravel 12 and Vue 3 (via Inertia.js v2).

## Overview

A Panel is a self-contained admin interface that includes:

- **Resources**: CRUD entities with forms, tables, and infolists
- **Pages**: Custom standalone pages
- **Navigation**: Auto-generated sidebar navigation
- **Authentication**: Login, registration, 2FA, social auth, passkeys
- **API Access**: Auto-generated REST APIs
- **Widgets**: Dashboard statistics and charts

## Key Features

### Multi-Panel Support

Run multiple independent admin panels in a single Laravel application:

```php
// Admin panel at /admin
App\Laravilt\Admin\AdminPanelProvider::class

// Customer portal at /portal
App\Laravilt\Portal\PortalPanelProvider::class

// Vendor dashboard at /vendor
App\Laravilt\Vendor\VendorPanelProvider::class
```

### Auto-Discovery

Laravilt automatically discovers your resources, pages, clusters, and widgets:

```
app/Laravilt/Admin/
├── Pages/           # Auto-discovered
├── Resources/       # Auto-discovered
├── Clusters/        # Auto-discovered
└── Widgets/         # Auto-discovered
```

### Comprehensive Authentication

Built-in support for:
- Email/password login
- User registration
- Password reset
- Email verification
- Two-factor authentication (TOTP)
- Social authentication (OAuth)
- Passkeys (WebAuthn)
- Magic links
- Session management

### API Generation

Every resource automatically gets REST API endpoints:

```
GET    /admin/api/users          # List
POST   /admin/api/users          # Create
GET    /admin/api/users/{id}     # Show
PUT    /admin/api/users/{id}     # Update
DELETE /admin/api/users/{id}     # Delete
```

---

## Core Concepts

### Panel

The `Panel` class is the main configuration object:

```php
use Laravilt\Panel\Panel;

Panel::make()
    ->id('admin')
    ->path('admin')
    ->login()
    ->colors(['primary' => '#3b82f6'])
    ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
    ->discoverPages(in: app_path('Laravilt/Admin/Pages'));
```

### Panel Provider

Each panel has a provider that configures it:

```php
namespace App\Laravilt\Admin;

use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->register()
            ->colors(['primary' => '#3b82f6'])
            ->brandName('My Admin')
            ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
            ->discoverPages(in: app_path('Laravilt/Admin/Pages'))
            ->discoverWidgets(in: app_path('Laravilt/Admin/Widgets'));
    }
}
```

### Panel Registry

The `PanelRegistry` manages multiple panel instances:

```php
use Laravilt\Panel\Facades\Panel;

// Get current panel
$panel = Panel::getCurrent();

// Get specific panel
$adminPanel = Panel::get('admin');

// Get all panels
$allPanels = Panel::all();

// Set default panel
Panel::setDefault('admin');
```

---

## Architecture

### Package Dependencies

The Panel package integrates with:

| Package | Purpose |
|---------|---------|
| **Support** | Base components and traits |
| **Auth** | Authentication features |
| **Forms** | Form building |
| **Tables** | Table configuration |
| **Infolists** | Data display |
| **Actions** | Interactive actions |
| **Widgets** | Dashboard widgets |
| **Notifications** | Toast and database notifications |

### Middleware Stack

```
1. IdentifyPanel     → Determines current panel from URL
2. Authenticate      → Verifies user authentication
3. HandleLocalization → Sets locale, timezone, RTL
4. SharePanelData    → Shares config with frontend
```

### Request Lifecycle

```
HTTP Request
    ↓
Laravel Router
    ↓
Panel Middleware Stack
    ↓
Panel Controller (Resource/Page/API)
    ↓
Inertia Response (JSON for Vue)
    ↓
Vue Component (renders HTML)
```

---

## Directory Structure

After creating a panel, your application will have:

```
app/Laravilt/{PanelId}/
├── {PanelId}PanelProvider.php    # Panel configuration
├── Pages/
│   └── Dashboard.php              # Default dashboard
├── Resources/
│   └── UserResource.php           # Example resource
├── Clusters/                      # Page groupings
└── Widgets/                       # Dashboard widgets
```

---

## Configuration

### Panel Configuration File

Publish and customize `config/laravilt-panel.php`:

```php
return [
    'path' => env('LARAVILT_PANEL_PATH', 'admin'),
    'middleware' => ['web', 'auth'],
    'colors' => [
        'primary' => '#6366f1',
    ],
    'brand_name' => env('APP_NAME', 'Laravilt'),
    'brand_logo' => null,
    'favicon' => null,
    'max_content_width' => '7xl',
];
```

### Publishing Assets

```bash
# Publish all panel assets
php artisan vendor:publish --tag=laravilt-panel-config
php artisan vendor:publish --tag=laravilt-panel-views
php artisan vendor:publish --tag=laravilt-panel-lang
```

---

## Next Steps

- [Migrating from Filament](migration.md) - Migrate existing Filament PHP projects
- [Creating Panels](creating-panels.md) - Create and configure panels
- [Resources](resources.md) - Build CRUD resources
- [Pages](pages.md) - Create custom pages
- [Navigation](navigation.md) - Customize navigation
- [Themes & Branding](themes.md) - Style your panel
- [Multi-Tenancy](tenancy.md) - Build SaaS applications
