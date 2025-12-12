# Creating Panels

This guide covers creating and configuring admin panels in Laravilt.

## Creating a New Panel

### Using Artisan Command

The easiest way to create a panel is using the Artisan command:

```bash
php artisan laravilt:panel admin
```

This launches an interactive wizard that prompts for:

```
┌ What features do you want to enable? ───────────────────────────┐
│ ◼ Login                                                          │
│ ◼ Registration                                                   │
│ ◻ Two-Factor Authentication                                      │
│ ◻ Social Authentication                                          │
│ ◻ Passkeys (WebAuthn)                                           │
│ ◻ API Tokens                                                     │
│ ◻ AI Integration                                                 │
└──────────────────────────────────────────────────────────────────┘
```

### Command Options

```bash
# Specify path
php artisan laravilt:panel admin --path=dashboard

# Quick creation (skip interactive prompts)
php artisan laravilt:panel admin --quick
```

### Manual Creation

Create the panel provider manually:

```php
// app/Laravilt/Admin/AdminPanelProvider.php
<?php

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

Register the provider in `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Laravilt\Admin\AdminPanelProvider::class,
];
```

---

## Panel Configuration

### Basic Settings

```php
public function panel(Panel $panel): Panel
{
    return $panel
        // Required: Unique panel identifier
        ->id('admin')

        // Required: URL path prefix
        ->path('admin')

        // Panel middleware stack
        ->middleware(['web', 'auth'])

        // Max content width
        ->maxContentWidth('7xl');
}
```

### Branding

```php
$panel
    // Brand name shown in sidebar
    ->brandName('My Admin')

    // Brand logo (URL or path)
    ->brandLogo('/images/logo.svg')

    // Dark mode logo variant
    ->darkModeBrandLogo('/images/logo-dark.svg')

    // Favicon
    ->favicon('/favicon.ico');
```

### Colors

```php
$panel
    ->colors([
        'primary' => '#3b82f6',
        'secondary' => '#64748b',
        'success' => '#22c55e',
        'warning' => '#f59e0b',
        'danger' => '#ef4444',
        'info' => '#06b6d4',
    ]);
```

### Font Configuration

```php
use Laravilt\Panel\FontProviders\GoogleFontProvider;

$panel
    ->font('Inter')
    ->fontProvider(GoogleFontProvider::class);
```

### Dark Mode

```php
$panel
    // Enable dark mode toggle
    ->darkMode()

    // Force dark mode
    ->darkMode(enabled: true, toggle: false);
```

---

## Authentication Configuration

### Basic Authentication

```php
$panel
    // Enable login page
    ->login()

    // Enable registration
    ->register()

    // Password reset
    ->passwordReset()

    // Email verification
    ->emailVerification();
```

### Two-Factor Authentication

```php
$panel
    // Enable 2FA setup in profile
    ->twoFactorAuthentication()

    // Require 2FA for all users
    ->requireTwoFactorAuthentication();
```

### Social Authentication

```php
$panel
    ->socialAuth([
        'google' => [
            'label' => 'Google',
            'icon' => 'Google',
        ],
        'github' => [
            'label' => 'GitHub',
            'icon' => 'Github',
        ],
    ]);
```

### Passkeys (WebAuthn)

```php
$panel
    // Enable passkey registration in profile
    ->passkeys()

    // Allow passwordless login with passkeys
    ->passwordlessLogin();
```

### Magic Links

```php
$panel
    ->magicLinks();
```

### API Tokens

```php
$panel
    // Enable API token management
    ->apiTokens()

    // Configure Sanctum abilities
    ->apiTokenAbilities([
        'read' => 'Read resources',
        'create' => 'Create resources',
        'update' => 'Update resources',
        'delete' => 'Delete resources',
    ]);
```

---

## Discovery Configuration

### Auto-Discovery

```php
$panel
    // Discover pages in directory
    ->discoverPages(
        in: app_path('Laravilt/Admin/Pages'),
        for: 'App\\Laravilt\\Admin\\Pages'
    )

    // Discover resources
    ->discoverResources(
        in: app_path('Laravilt/Admin/Resources'),
        for: 'App\\Laravilt\\Admin\\Resources'
    )

    // Discover clusters
    ->discoverClusters(
        in: app_path('Laravilt/Admin/Clusters'),
        for: 'App\\Laravilt\\Admin\\Clusters'
    )

    // Discover widgets
    ->discoverWidgets(
        in: app_path('Laravilt/Admin/Widgets'),
        for: 'App\\Laravilt\\Admin\\Widgets'
    );
```

### Manual Registration

```php
use App\Laravilt\Admin\Pages\Dashboard;
use App\Laravilt\Admin\Resources\UserResource;

$panel
    ->pages([
        Dashboard::class,
    ])
    ->resources([
        UserResource::class,
    ]);
```

---

## Navigation Configuration

### Custom Navigation

```php
use Laravilt\Panel\Navigation\NavigationBuilder;
use Laravilt\Panel\Navigation\NavigationItem;

$panel
    ->navigation(function (NavigationBuilder $builder) {
        return $builder
            ->item(
                NavigationItem::make()
                    ->label('Dashboard')
                    ->icon('LayoutDashboard')
                    ->url('/admin')
            )
            ->group('Content', [
                NavigationItem::make()
                    ->label('Posts')
                    ->icon('FileText')
                    ->url('/admin/posts'),
                NavigationItem::make()
                    ->label('Pages')
                    ->icon('File')
                    ->url('/admin/pages'),
            ])
            ->group('Settings', [
                NavigationItem::make()
                    ->label('Users')
                    ->icon('Users')
                    ->url('/admin/users')
                    ->badge(fn () => User::count(), 'primary'),
            ]);
    });
```

### User Menu

```php
use Laravilt\Panel\Navigation\UserMenu;

$panel
    ->userMenu(function (UserMenu $menu) {
        return $menu
            ->item('Profile', '/admin/profile', 'User')
            ->item('Settings', '/admin/settings', 'Settings')
            ->divider()
            ->item('Help', '/help', 'HelpCircle');
    });
```

---

## Advanced Features

### Database Notifications

```php
$panel
    // Enable notification center
    ->databaseNotifications()

    // Polling interval (seconds)
    ->databaseNotificationsPolling('30s');
```

### Global Search

```php
$panel
    // Enable global search
    ->globalSearch()

    // Keyboard shortcut
    ->globalSearchKeyBindings(['command+k', 'ctrl+k']);
```

### AI Integration

```php
$panel
    // Enable AI features
    ->ai()

    // Configure AI provider
    ->aiProvider('anthropic')
    ->aiModel('claude-3-sonnet');
```

### Multi-Tenancy

```php
$panel
    ->tenant(Team::class)
    ->tenantRoutePrefix('team')
    ->tenantMenu(function (Team $tenant) {
        return $tenant->name;
    });
```

### Custom CSS/JS

```php
$panel
    // Add custom CSS
    ->css([
        'css/custom.css',
    ])

    // Add custom JavaScript
    ->js([
        'js/custom.js',
    ]);
```

---

## Multiple Panels

### Creating Additional Panels

```bash
php artisan laravilt:panel portal --path=portal
php artisan laravilt:panel vendor --path=vendor
```

### Panel-Specific Resources

Each panel has isolated resources:

```
app/Laravilt/
├── Admin/
│   ├── AdminPanelProvider.php
│   └── Resources/
│       └── UserResource.php
├── Portal/
│   ├── PortalPanelProvider.php
│   └── Resources/
│       └── OrderResource.php
└── Vendor/
    ├── VendorPanelProvider.php
    └── Resources/
        └── ProductResource.php
```

### Setting Default Panel

```php
use Laravilt\Panel\Facades\Panel;

// In AppServiceProvider
public function boot(): void
{
    Panel::setDefault('admin');
}
```

---

## Complete Example

```php
<?php

namespace App\Laravilt\Admin;

use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Navigation\NavigationBuilder;
use Laravilt\Panel\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // Identity
            ->id('admin')
            ->path('admin')

            // Branding
            ->brandName(config('app.name'))
            ->brandLogo('/images/logo.svg')
            ->favicon('/favicon.ico')

            // Colors & Theme
            ->colors(['primary' => '#3b82f6'])
            ->font('Inter')
            ->darkMode()

            // Authentication
            ->login()
            ->register()
            ->passwordReset()
            ->emailVerification()
            ->twoFactorAuthentication()
            ->passkeys()

            // Features
            ->databaseNotifications()
            ->globalSearch()

            // Discovery
            ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
            ->discoverPages(in: app_path('Laravilt/Admin/Pages'))
            ->discoverWidgets(in: app_path('Laravilt/Admin/Widgets'))

            // Custom navigation
            ->navigation(function (NavigationBuilder $builder) {
                return $builder
                    ->item(
                        NavigationItem::make()
                            ->label('Dashboard')
                            ->icon('LayoutDashboard')
                            ->url('/admin')
                    );
            })

            // Middleware
            ->middleware(['web', 'auth']);
    }
}
```

---

## Next Steps

- [Resources](resources.md) - Create CRUD resources
- [Pages](pages.md) - Build custom pages
- [Navigation](navigation.md) - Customize navigation structure
