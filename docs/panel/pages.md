# Pages

Pages are standalone screens in your panel that aren't tied to a specific resource. Use them for dashboards, settings, reports, and other custom views.

## Creating Pages

### Using Artisan Command

```bash
php artisan laravilt:make-page Dashboard --panel=admin
```

Options:
- `--panel=`: Target panel (default: admin)
- `--resource=`: Associate with a resource
- `--cluster=`: Associate with a cluster

### Generated File

```php
// app/Laravilt/Admin/Pages/Dashboard.php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'LayoutDashboard';

    protected static string $view = 'laravilt/Dashboard';
}
```

---

## Page Structure

### Basic Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;

class Dashboard extends Page
{
    // Navigation icon (Lucide icon name)
    protected static ?string $navigationIcon = 'LayoutDashboard';

    // Page title
    protected static ?string $title = 'Dashboard';

    // Navigation label (defaults to title)
    protected static ?string $navigationLabel = 'Dashboard';

    // Navigation group
    protected static ?string $navigationGroup = null;

    // Navigation sort order
    protected static ?int $navigationSort = 0;

    // URL slug
    protected static ?string $slug = 'dashboard';

    // Vue component to render
    protected static string $view = 'laravilt/Dashboard';
}
```

### Page with Data

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use App\Models\User;
use App\Models\Order;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'LayoutDashboard';
    protected static string $view = 'laravilt/Dashboard';

    // Data passed to the Vue component
    public function getViewData(): array
    {
        return [
            'stats' => [
                'users' => User::count(),
                'orders' => Order::count(),
                'revenue' => Order::sum('total'),
            ],
            'recentOrders' => Order::with('customer')
                ->latest()
                ->take(5)
                ->get(),
        ];
    }
}
```

---

## Lifecycle Methods

### Mount

Called when the page is first loaded:

```php
class Settings extends Page
{
    public array $settings = [];

    public function mount(): void
    {
        $this->settings = config('app.settings', []);
    }
}
```

### Boot

Called every request (before mount):

```php
class Dashboard extends Page
{
    public function boot(): void
    {
        // Authorization check
        if (!auth()->user()->can('view-dashboard')) {
            abort(403);
        }
    }
}
```

---

## Actions

Add interactive buttons to pages:

### Header Actions

```php
use Laravilt\Actions\Action;

class Dashboard extends Page
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh Data')
                ->icon('RefreshCw')
                ->action(fn () => $this->refreshData()),

            Action::make('export')
                ->label('Export Report')
                ->icon('Download')
                ->color('secondary')
                ->action(fn () => $this->exportReport()),
        ];
    }

    public function refreshData(): void
    {
        // Refresh logic
    }

    public function exportReport()
    {
        return response()->download('report.pdf');
    }
}
```

### Actions with Forms

```php
use Laravilt\Actions\Action;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\DatePicker;

class Reports extends Page
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('generateReport')
                ->label('Generate Report')
                ->icon('FileText')
                ->form([
                    DatePicker::make('start_date')
                        ->required(),
                    DatePicker::make('end_date')
                        ->required()
                        ->afterOrEqual('start_date'),
                    TextInput::make('email')
                        ->email()
                        ->required(),
                ])
                ->action(function (array $data) {
                    // Generate and email report
                    $this->generateReport(
                        $data['start_date'],
                        $data['end_date'],
                        $data['email']
                    );
                }),
        ];
    }
}
```

---

## Widgets

Add widgets to pages for statistics and visualizations:

### Using Widgets

```php
use App\Laravilt\Admin\Widgets\StatsOverview;
use App\Laravilt\Admin\Widgets\RevenueChart;
use App\Laravilt\Admin\Widgets\RecentOrders;

class Dashboard extends Page
{
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            RevenueChart::class,
            RecentOrders::class,
        ];
    }

    // Widget columns (responsive grid)
    public function getHeaderWidgetsColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 2,
            'lg' => 4,
        ];
    }
}
```

---

## Page Hooks

Add custom content above or below the main content:

```php
class Dashboard extends Page
{
    public function __construct()
    {
        parent::__construct();

        // Add content at the top
        $this->topHook('<div class="alert alert-info">Welcome back!</div>');

        // Add content at the bottom
        $this->bottomHook(function () {
            return view('partials.dashboard-footer');
        });
    }
}
```

---

## Dashboard Page

The built-in Dashboard page has special features:

### Auto-Generated Stats

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // Auto-generate stats for all resources
    protected bool $shouldGenerateResourceStats = true;

    // Stats columns layout
    protected int $statsColumns = 4;
}
```

### Custom Dashboard

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Dashboard as BaseDashboard;
use App\Laravilt\Admin\Widgets\StatsOverview;
use App\Laravilt\Admin\Widgets\SalesChart;
use App\Laravilt\Admin\Widgets\LatestOrders;
use App\Laravilt\Admin\Widgets\TopProducts;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'LayoutDashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            SalesChart::make()->columnSpan(2),
            LatestOrders::make()->columnSpan(1),
            TopProducts::make()->columnSpan(1),
        ];
    }

    public function getFooterWidgetsColumns(): int
    {
        return 4;
    }
}
```

---

## Settings Page

Create settings pages with forms:

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use Laravilt\Forms\Form;
use Laravilt\Forms\Components\Section;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Forms\Concerns\InteractsWithForms;

class Settings extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static string $view = 'laravilt/SettingsPage';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => config('app.name'),
            'site_url' => config('app.url'),
            'maintenance_mode' => app()->isDownForMaintenance(),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Settings')
                    ->schema([
                        TextInput::make('site_name')
                            ->required(),
                        TextInput::make('site_url')
                            ->url()
                            ->required(),
                        Toggle::make('maintenance_mode')
                            ->label('Maintenance Mode'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Save settings logic
        // ...

        $this->notify('success', 'Settings saved successfully.');
    }

    protected function getFormActions(): array
    {
        return [
            \Laravilt\Actions\Action::make('save')
                ->label('Save Settings')
                ->action('save'),
        ];
    }
}
```

---

## Clusters

Group related pages together:

### Creating a Cluster

```bash
php artisan laravilt:make-cluster Settings --panel=admin
```

```php
<?php

namespace App\Laravilt\Admin\Clusters;

use Laravilt\Panel\Cluster;

class Settings extends Cluster
{
    protected static ?string $navigationIcon = 'Settings';
    protected static ?string $navigationLabel = 'Settings';
    protected static ?int $navigationSort = 100;
}
```

### Adding Pages to Cluster

```php
<?php

namespace App\Laravilt\Admin\Pages\Settings;

use Laravilt\Panel\Pages\Page;
use App\Laravilt\Admin\Clusters\Settings;

class GeneralSettings extends Page
{
    protected static ?string $cluster = Settings::class;
    protected static ?string $navigationIcon = 'Sliders';
    protected static ?string $title = 'General';
}

class EmailSettings extends Page
{
    protected static ?string $cluster = Settings::class;
    protected static ?string $navigationIcon = 'Mail';
    protected static ?string $title = 'Email';
}
```

### Cluster Structure

```
Settings (Cluster)
├── General Settings
├── Email Settings
├── Security Settings
└── API Settings
```

---

## Navigation Configuration

### Hiding from Navigation

```php
class HiddenPage extends Page
{
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
```

### Conditional Navigation

```php
class AdminOnlyPage extends Page
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin();
    }
}
```

### Custom URL

```php
class ExternalLink extends Page
{
    protected static ?string $navigationIcon = 'ExternalLink';

    public static function getNavigationUrl(): string
    {
        return 'https://docs.example.com';
    }

    // Open in new tab
    public static function shouldOpenNavigationInNewTab(): bool
    {
        return true;
    }
}
```

---

## Breadcrumbs

### Auto-Generated Breadcrumbs

Breadcrumbs are automatically generated based on:
- Panel name
- Cluster (if any)
- Page title

### Custom Breadcrumbs

```php
class ProductDetails extends Page
{
    public function getBreadcrumbs(): array
    {
        return [
            route('admin.dashboard') => 'Dashboard',
            route('admin.products.index') => 'Products',
            null => 'Product Details',
        ];
    }
}
```

---

## Page Layouts

### Default Panel Layout

```php
class Dashboard extends Page
{
    // Uses PanelLayout.vue by default
    protected static string $view = 'laravilt/Dashboard';
}
```

### Custom Layout

```php
class LoginPage extends Page
{
    // Use a different layout
    protected static ?string $layout = 'guest';
    protected static string $view = 'auth/Login';
}
```

---

## Complete Page Example

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;
use Laravilt\Actions\Action;
use Laravilt\Forms\Components\DatePicker;
use App\Models\Order;
use App\Models\User;
use App\Laravilt\Admin\Widgets\StatsOverview;
use App\Laravilt\Admin\Widgets\RevenueChart;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'LayoutDashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?int $navigationSort = 0;
    protected static string $view = 'laravilt/Dashboard';

    public function boot(): void
    {
        // Verify access
        abort_unless(auth()->check(), 403);
    }

    public function getViewData(): array
    {
        return [
            'stats' => $this->getStats(),
            'recentOrders' => $this->getRecentOrders(),
            'topCustomers' => $this->getTopCustomers(),
        ];
    }

    protected function getStats(): array
    {
        return [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'revenue' => Order::sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];
    }

    protected function getRecentOrders(): \Illuminate\Support\Collection
    {
        return Order::with('customer')
            ->latest()
            ->take(5)
            ->get();
    }

    protected function getTopCustomers(): \Illuminate\Support\Collection
    {
        return User::withCount('orders')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh')
                ->icon('RefreshCw')
                ->action(fn () => $this->redirect(request()->url())),

            Action::make('export')
                ->label('Export Report')
                ->icon('Download')
                ->color('secondary')
                ->form([
                    DatePicker::make('start_date')->required(),
                    DatePicker::make('end_date')->required(),
                ])
                ->action(fn (array $data) => $this->exportReport($data)),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            RevenueChart::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int
    {
        return 4;
    }

    protected function exportReport(array $data)
    {
        // Export logic
    }
}
```

---

## Next Steps

- [Navigation](navigation.md) - Customize navigation structure
- [Themes & Branding](themes.md) - Style your panel
- [Widgets](../widgets/introduction.md) - Create dashboard widgets
