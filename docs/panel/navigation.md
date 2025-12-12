# Navigation

Laravilt provides a flexible navigation system that automatically generates sidebar navigation from your resources and pages. You can also fully customize the navigation structure.

## Auto-Generated Navigation

By default, navigation is automatically generated from:
- **Resources**: Each resource becomes a navigation item
- **Pages**: Pages with navigation enabled
- **Clusters**: Group related pages

### Navigation Properties

Resources and pages use these properties:

```php
class UserResource extends Resource
{
    // Lucide icon name
    protected static ?string $navigationIcon = 'Users';

    // Group in sidebar
    protected static ?string $navigationGroup = 'User Management';

    // Sort order (lower = higher)
    protected static ?int $navigationSort = 1;

    // Custom label (defaults to resource name)
    protected static ?string $navigationLabel = 'All Users';
}
```

---

## Navigation Builder

For complete control, use the `NavigationBuilder`:

```php
use Laravilt\Panel\Navigation\NavigationBuilder;
use Laravilt\Panel\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->navigation(function (NavigationBuilder $builder) {
                return $builder
                    ->item(
                        NavigationItem::make()
                            ->label('Dashboard')
                            ->icon('LayoutDashboard')
                            ->url('/admin')
                            ->active(fn () => request()->is('admin'))
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
                        NavigationItem::make()
                            ->label('Media')
                            ->icon('Image')
                            ->url('/admin/media'),
                    ])
                    ->group('Shop', [
                        NavigationItem::make()
                            ->label('Products')
                            ->icon('Package')
                            ->url('/admin/products')
                            ->badge(fn () => Product::count()),
                        NavigationItem::make()
                            ->label('Orders')
                            ->icon('ShoppingCart')
                            ->url('/admin/orders')
                            ->badge(fn () => Order::pending()->count(), 'warning'),
                        NavigationItem::make()
                            ->label('Customers')
                            ->icon('Users')
                            ->url('/admin/customers'),
                    ])
                    ->group('Settings', [
                        NavigationItem::make()
                            ->label('General')
                            ->icon('Settings')
                            ->url('/admin/settings'),
                        NavigationItem::make()
                            ->label('Users')
                            ->icon('UserCog')
                            ->url('/admin/users'),
                    ]);
            });
    }
}
```

---

## Navigation Item

### Basic Configuration

```php
NavigationItem::make()
    // Display label
    ->label('Dashboard')

    // Lucide icon
    ->icon('LayoutDashboard')

    // URL to navigate to
    ->url('/admin/dashboard')

    // Or use route name
    ->route('admin.dashboard')

    // Active state condition
    ->active(fn () => request()->routeIs('admin.dashboard*'));
```

### Badges

```php
NavigationItem::make()
    ->label('Orders')
    ->icon('ShoppingCart')
    ->url('/admin/orders')

    // Simple badge
    ->badge(fn () => Order::pending()->count())

    // Badge with color
    ->badge(fn () => Order::pending()->count(), 'warning')

    // Dynamic badge color
    ->badge(
        fn () => Order::pending()->count(),
        fn () => Order::pending()->count() > 10 ? 'danger' : 'warning'
    );
```

Available badge colors: `primary`, `secondary`, `success`, `warning`, `danger`, `info`

### Sorting

```php
NavigationItem::make()
    ->label('Dashboard')
    ->sort(0)  // Lower numbers appear first

NavigationItem::make()
    ->label('Settings')
    ->sort(100)  // Appears at the bottom
```

### Conditional Visibility

```php
NavigationItem::make()
    ->label('Admin Settings')
    ->icon('Shield')
    ->url('/admin/admin-settings')
    ->visible(fn () => auth()->user()?->isAdmin());
```

### External Links

```php
NavigationItem::make()
    ->label('Documentation')
    ->icon('ExternalLink')
    ->url('https://docs.example.com')
    ->openInNewTab();
```

### Translation Support

```php
NavigationItem::make()
    ->translationKey('navigation.dashboard')
    ->icon('LayoutDashboard')
    ->url('/admin');
```

---

## Navigation Groups

### Creating Groups

```php
$builder->group('Content', [
    NavigationItem::make()->label('Posts')->url('/admin/posts'),
    NavigationItem::make()->label('Pages')->url('/admin/pages'),
]);
```

### Group Configuration

```php
$builder->group('Content', function () {
    return [
        NavigationItem::make()->label('Posts'),
        NavigationItem::make()->label('Pages'),
    ];
})
->icon('Folder')
->collapsible()
->collapsed();  // Start collapsed
```

### Nested Groups (Clusters)

For deeper nesting, use Clusters:

```php
// app/Laravilt/Admin/Clusters/Settings.php
class Settings extends Cluster
{
    protected static ?string $navigationIcon = 'Settings';
    protected static ?string $navigationLabel = 'Settings';
}

// Pages within the cluster
class GeneralSettings extends Page
{
    protected static ?string $cluster = Settings::class;
}

class EmailSettings extends Page
{
    protected static ?string $cluster = Settings::class;
}
```

---

## Conditional Navigation

### Hide from Navigation

```php
class HiddenResource extends Resource
{
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
```

### Role-Based Navigation

```php
class AdminResource extends Resource
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->hasRole('admin');
    }
}
```

### Permission-Based Navigation

```php
class UserResource extends Resource
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('viewAny', User::class);
    }
}
```

---

## User Menu

Configure the user dropdown menu:

```php
use Laravilt\Panel\Navigation\UserMenu;

$panel->userMenu(function (UserMenu $menu) {
    return $menu
        // Profile link
        ->item('Profile', '/admin/profile', 'User')

        // Settings link
        ->item('Settings', '/admin/settings', 'Settings')

        // Divider
        ->divider()

        // Help link (external)
        ->item('Help', 'https://help.example.com', 'HelpCircle', openInNewTab: true)

        // Divider before logout
        ->divider();

    // Logout is added automatically
});
```

### User Menu Item Options

```php
$menu->item(
    label: 'Profile',
    url: '/admin/profile',
    icon: 'User',
    openInNewTab: false,
    visible: fn () => true
);
```

---

## Resource Navigation

### Navigation Badge

```php
class OrderResource extends Resource
{
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();

        return match (true) {
            $count > 10 => 'danger',
            $count > 5 => 'warning',
            default => 'success',
        };
    }
}
```

### Active State

The navigation automatically highlights the active item based on the current URL. For custom logic:

```php
class DashboardPage extends Page
{
    public static function getNavigationItemActiveIndicator(): bool|Closure
    {
        return fn () => request()->routeIs('admin.dashboard*');
    }
}
```

---

## Page Navigation

### Hiding Pages from Navigation

```php
class HiddenPage extends Page
{
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
```

### Sub-Navigation in Pages

Create a settings page with tabs:

```php
class SettingsPage extends Page
{
    protected static string $view = 'admin/Settings';

    public function getSubNavigation(): array
    {
        return [
            NavigationItem::make()
                ->label('General')
                ->url('/admin/settings/general')
                ->active(fn () => request()->is('*/general')),
            NavigationItem::make()
                ->label('Email')
                ->url('/admin/settings/email')
                ->active(fn () => request()->is('*/email')),
            NavigationItem::make()
                ->label('Security')
                ->url('/admin/settings/security')
                ->active(fn () => request()->is('*/security')),
        ];
    }
}
```

---

## Complete Navigation Example

```php
<?php

namespace App\Laravilt\Admin;

use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Navigation\NavigationBuilder;
use Laravilt\Panel\Navigation\NavigationItem;
use Laravilt\Panel\Navigation\UserMenu;
use App\Models\Order;
use App\Models\User;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->navigation(function (NavigationBuilder $builder) {
                return $builder
                    // Dashboard (top level)
                    ->item(
                        NavigationItem::make()
                            ->label('Dashboard')
                            ->icon('LayoutDashboard')
                            ->url('/admin')
                            ->sort(0)
                    )

                    // Content group
                    ->group('Content', [
                        NavigationItem::make()
                            ->label('Posts')
                            ->icon('FileText')
                            ->url('/admin/posts')
                            ->sort(1),
                        NavigationItem::make()
                            ->label('Categories')
                            ->icon('FolderTree')
                            ->url('/admin/categories')
                            ->sort(2),
                        NavigationItem::make()
                            ->label('Tags')
                            ->icon('Tags')
                            ->url('/admin/tags')
                            ->sort(3),
                    ])

                    // E-commerce group
                    ->group('Shop', [
                        NavigationItem::make()
                            ->label('Products')
                            ->icon('Package')
                            ->url('/admin/products')
                            ->badge(fn () => \App\Models\Product::count(), 'info'),
                        NavigationItem::make()
                            ->label('Orders')
                            ->icon('ShoppingCart')
                            ->url('/admin/orders')
                            ->badge(
                                fn () => Order::where('status', 'pending')->count(),
                                fn () => Order::where('status', 'pending')->count() > 5
                                    ? 'danger'
                                    : 'warning'
                            ),
                        NavigationItem::make()
                            ->label('Customers')
                            ->icon('Users')
                            ->url('/admin/customers'),
                    ])

                    // Settings group (bottom)
                    ->group('System', [
                        NavigationItem::make()
                            ->label('Users')
                            ->icon('UserCog')
                            ->url('/admin/users')
                            ->visible(fn () => auth()->user()?->isAdmin()),
                        NavigationItem::make()
                            ->label('Settings')
                            ->icon('Settings')
                            ->url('/admin/settings')
                            ->sort(99),
                    ]);
            })
            ->userMenu(function (UserMenu $menu) {
                return $menu
                    ->item('My Profile', '/admin/profile', 'User')
                    ->item('Account Settings', '/admin/settings/account', 'Settings')
                    ->divider()
                    ->item('API Tokens', '/admin/api-tokens', 'Key')
                    ->divider()
                    ->item('Help & Support', 'https://support.example.com', 'HelpCircle', openInNewTab: true);
            });
    }
}
```

---

## Navigation Icons

Laravilt uses [Lucide Icons](https://lucide.dev/icons). Common icons:

| Icon | Name |
|------|------|
| Dashboard | `LayoutDashboard` |
| Users | `Users` |
| Settings | `Settings` |
| Products | `Package` |
| Orders | `ShoppingCart` |
| Posts | `FileText` |
| Pages | `File` |
| Categories | `FolderTree` |
| Tags | `Tags` |
| Media | `Image` |
| Comments | `MessageSquare` |
| Analytics | `BarChart` |
| Reports | `PieChart` |
| Mail | `Mail` |
| Notifications | `Bell` |
| Search | `Search` |
| Plus | `Plus` |
| Edit | `Pencil` |
| Delete | `Trash` |
| External | `ExternalLink` |
| Help | `HelpCircle` |

---

## Next Steps

- [Themes & Branding](themes.md) - Customize appearance
- [Resources](resources.md) - Configure resource navigation
- [Pages](pages.md) - Configure page navigation
