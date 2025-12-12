# Widgets Introduction

The Widgets package provides a comprehensive dashboard widget system for displaying key metrics, charts, and statistics in your Laravilt applications.

## Overview

Laravilt Widgets offers:

- **Stats Overview** - Display multiple statistics in responsive grids
- **Line Charts** - Area and line charts with multiple datasets
- **Bar Charts** - Vertical and horizontal bar charts with stacking
- **Pie Charts** - Pie and doughnut charts with legends
- **Auto-polling** - Real-time data updates
- **Fluent Builder API** - Intuitive configuration
- **Vue Components** - Responsive, dark-mode ready UI

---

## Widget Types

### Stats Overview Widget

Display multiple statistics in a responsive grid layout.

```php
use Laravilt\Widgets\StatsOverviewWidget;
use Laravilt\Widgets\Stat;

StatsOverviewWidget::make()
    ->heading('Business Metrics')
    ->description('Today\'s performance')
    ->columns(4)
    ->stats([
        Stat::make('Revenue', fn() => '$' . number_format(Order::sum('total') / 100, 2))
            ->description('+12% from yesterday')
            ->descriptionIcon('TrendingUp', 'success')
            ->icon('DollarSign')
            ->color('success'),

        Stat::make('Orders', fn() => Order::count())
            ->description('Completed today')
            ->icon('ShoppingCart')
            ->color('primary')
            ->chart('bar', [8, 12, 15, 18, 22], 'primary'),

        Stat::make('Customers', fn() => User::count())
            ->description('Total users')
            ->icon('Users')
            ->color('info'),

        Stat::make('Conversion', '3.2%')
            ->description('-0.5% from last week')
            ->descriptionIcon('TrendingDown', 'danger')
            ->icon('Percent')
            ->color('warning'),
    ])
    ->polling(30); // Refresh every 30 seconds
```

### Line Chart Widget

Display line and area charts with multiple datasets.

```php
use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [
        [
            'label' => 'Revenue',
            'data' => [4500, 5200, 4800, 6100, 5900, 6800],
            'borderColor' => 'rgb(34, 197, 94)',
            'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
        ]
    ]
)
    ->heading('Revenue Trend')
    ->description('Last 6 months')
    ->curved()
    ->fill()
    ->height(350)
    ->polling(60);
```

### Bar Chart Widget

Display vertical or horizontal bar charts with stacking support.

```php
use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(
    labels: ['Electronics', 'Furniture', 'Fitness'],
    datasets: [
        [
            'label' => 'Sales',
            'data' => [150, 89, 45],
            'backgroundColor' => 'rgb(59, 130, 246)',
        ]
    ]
)
    ->heading('Products by Category')
    ->horizontal()
    ->height(300);
```

### Pie Chart Widget

Display pie or doughnut charts with percentage legends.

```php
use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(
    labels: ['Featured', 'Regular'],
    data: [150, 350]
)
    ->heading('Product Distribution')
    ->doughnut()
    ->showLegend()
    ->showPercentage()
    ->height(300);
```

---

## Dashboard Integration

### Step 1: Create Widget Class

```php
<?php

namespace App\Laravilt\Admin\Widgets;

use Laravilt\Widgets\StatsOverviewWidget;
use Laravilt\Widgets\Stat;
use App\Models\User;
use App\Models\Order;

class UserCounter extends StatsOverviewWidget
{
    protected ?string $heading = 'User Statistics';
    protected bool $pollingEnabled = true;
    protected ?int $pollingInterval = 10;

    public function __construct()
    {
        $this->stats($this->getStats());
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', fn() => User::count())
                ->description('Active users')
                ->icon('Users')
                ->color('success'),

            Stat::make('New Users', fn() => User::where('created_at', '>=', now()->subDays(30))->count())
                ->description('Last 30 days')
                ->icon('UserPlus')
                ->color('primary'),
        ];
    }
}
```

### Step 2: Register in Dashboard Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use App\Laravilt\Admin\Widgets\UserCounter;
use Laravilt\Panel\Pages\Dashboard;

class Dashboard extends \Laravilt\Panel\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            UserCounter::class,
        ];
    }
}
```

---

## Stat Component

Individual statistic item within a StatsOverviewWidget.

### Basic Stat

```php
Stat::make('Revenue', '$45,231.89')
    ->description('+20.1% from last month')
    ->icon('DollarSign')
    ->color('success');
```

### With Closure Value

```php
Stat::make('Active Users', fn() => User::where('status', 'active')->count())
    ->description('Currently online')
    ->icon('Users')
    ->color('primary');
```

### With Trend Icon

```php
Stat::make('Sales', '$12,234')
    ->description('+12.5%')
    ->descriptionIcon('TrendingUp', 'success')
    ->icon('ShoppingCart')
    ->color('success');
```

### With Mini Chart

```php
Stat::make('Revenue', '$45,231')
    ->description('+8% increase')
    ->icon('DollarSign')
    ->color('success')
    ->chart('line', [65, 59, 80, 81, 56, 55, 70], 'primary');
```

### With URL

```php
Stat::make('Orders', '156')
    ->description('Pending orders')
    ->icon('ShoppingBag')
    ->color('warning')
    ->url('/orders?status=pending');
```

---

## Chart Configuration

### Line Chart Options

```php
LineChartWidget::make($labels, $datasets)
    ->curved()          // Curved lines (tension: 0.4)
    ->fill()            // Fill area under line
    ->showPoints(true)  // Display data points
    ->showGrid(true)    // Display background grid
    ->height(350);      // Chart height in pixels
```

### Bar Chart Options

```php
BarChartWidget::make($labels, $datasets)
    ->horizontal()      // Horizontal bars
    ->stacked()         // Stacked mode
    ->showGrid()        // Display background grid
    ->barThickness(20)  // Bar width in pixels
    ->height(300);
```

### Pie Chart Options

```php
PieChartWidget::make($labels, $data)
    ->doughnut()        // Doughnut style (hollow center)
    ->showLegend()      // Display legend
    ->showPercentage()  // Show percentage in legend
    ->height(300);
```

---

## Widget Colors

All widgets support color themes:

```php
->color('primary')   // Primary brand color
->color('success')   // Green (#10b981)
->color('danger')    // Red (#ef4444)
->color('warning')   // Yellow (#eab308)
->color('info')      // Blue (#0ea5e9)
->color('gray')      // Gray (#6b7280)
```

---

## Auto-Polling

Enable automatic data refresh for real-time updates:

```php
// Enable polling with default interval (10 seconds)
->polling()

// Custom interval (30 seconds)
->polling(30)

// Disable polling
->polling(null)
```

**Polling Configuration:**

```php
class RevenueWidget extends StatsOverviewWidget
{
    protected bool $pollingEnabled = true;
    protected ?int $pollingInterval = 30; // Refresh every 30 seconds

    // ...
}
```

---

## Creating Widgets

### Artisan Command

```bash
# Interactive mode
php artisan laravilt:widget

# Quick create
php artisan laravilt:widget UserStats --type=stats
php artisan laravilt:widget SalesChart --type=chart --chart=line
php artisan laravilt:widget CategoryChart --type=chart --chart=bar --panel=Admin
```

**Options:**
- `--type=basic|stats|chart` - Widget type
- `--chart=line|bar|pie|doughnut` - Chart type (for chart widgets)
- `--panel=PanelName` - Specific panel (optional)

---

## Complete Examples

### Multi-Stat Dashboard

```php
use Laravilt\Widgets\StatsOverviewWidget;
use Laravilt\Widgets\Stat;
use App\Models\Order;
use App\Models\Product;

StatsOverviewWidget::make()
    ->heading('Overview Statistics')
    ->description('Key performance indicators')
    ->columns(4)
    ->stats([
        Stat::make('Total Revenue', fn() => '$' . number_format(Order::sum('amount') / 100, 2))
            ->description('+8% from yesterday')
            ->descriptionIcon('TrendingUp', 'success')
            ->icon('DollarSign')
            ->color('success'),

        Stat::make('Orders', fn() => Order::today()->count())
            ->description('Completed')
            ->icon('ShoppingCart')
            ->color('primary')
            ->chart('bar', [8, 12, 15, 18, 22], 'primary'),

        Stat::make('Customers', fn() => User::today()->count())
            ->description('New users')
            ->icon('Users')
            ->color('info'),

        Stat::make('Conversion', '3.2%')
            ->description('-0.5% from last week')
            ->descriptionIcon('TrendingDown', 'danger')
            ->icon('Percent')
            ->color('warning'),
    ])
    ->polling(30);
```

### Sales Trend Chart

```php
use Laravilt\Widgets\LineChartWidget;
use App\Models\Order;
use Carbon\CarbonPeriod;

class SalesChart extends LineChartWidget
{
    protected ?string $heading = 'Sales Trends';
    protected bool $pollingEnabled = true;
    protected ?int $pollingInterval = 60;

    public function __construct()
    {
        $this->height(350)
            ->curved()
            ->fill()
            ->data($this->generateData());
    }

    protected function generateData(): array
    {
        $period = CarbonPeriod::create(now()->subDays(30), now());
        $labels = [];
        $data = [];

        foreach ($period as $date) {
            $labels[] = $date->format('M d');
            $data[] = Order::whereDate('created_at', $date)->sum('total') / 100;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Sales',
                    'data' => $data,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ]
            ]
        ];
    }
}
```

### Category Breakdown

```php
use Laravilt\Widgets\PieChartWidget;
use App\Models\Product;

class FeaturedBreakdown extends PieChartWidget
{
    protected ?string $heading = 'Featured Status Breakdown';

    public function __construct()
    {
        $this->doughnut()
            ->showLegend()
            ->showPercentage()
            ->data($this->generateData());
    }

    protected function generateData(): array
    {
        return [
            'labels' => ['Featured', 'Regular'],
            'datasets' => [
                [
                    'data' => [
                        Product::where('is_featured', true)->count(),
                        Product::where('is_featured', false)->count(),
                    ],
                    'backgroundColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(156, 163, 175)',
                    ]
                ]
            ]
        ];
    }
}
```

---

## Widget Columns

Configure responsive grid columns for StatsOverviewWidget:

```php
->columns(1)  // Single column
->columns(2)  // 2 columns
->columns(3)  // 3 columns (default)
->columns(4)  // 4 columns
->columns(5)  // 5 columns
->columns(6)  // 6 columns
```

**Responsive Behavior:**
- 1 column: Single column on all screens
- 2 columns: 1 column on mobile, 2 on tablet+
- 3 columns: 1 column on mobile, 2 on tablet, 3 on desktop
- 4-6 columns: 1 column on mobile, 2 on tablet, 4-6 on desktop

---

## Best Practices

### 1. Use Closures for Dynamic Data

```php
// Good: Data evaluated at render time
Stat::make('Users', fn() => User::count())

// Avoid: Data cached at widget instantiation
Stat::make('Users', User::count())
```

### 2. Enable Polling for Real-time Data

```php
class LiveMetrics extends StatsOverviewWidget
{
    protected bool $pollingEnabled = true;
    protected ?int $pollingInterval = 15; // Refresh every 15 seconds
}
```

### 3. Use Semantic Colors

```php
Stat::make('Revenue', 45000)->color('success')  // Positive metric
Stat::make('Errors', 12)->color('danger')       // Negative metric
Stat::make('Warnings', 8)->color('warning')     // Caution metric
```

### 4. Optimize Data Queries

```php
protected function getStats(): array
{
    // Use aggregations instead of counting in loops
    $stats = User::selectRaw('
        COUNT(*) as total,
        SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active
    ')->first();

    return [
        Stat::make('Total', $stats->total),
        Stat::make('Active', $stats->active),
    ];
}
```

### 5. Choose Appropriate Polling Intervals

```php
->polling(60)  // Refresh every 60 seconds for non-critical data
->polling(10)  // Refresh every 10 seconds for critical metrics

// Avoid excessive polling
->polling(1)   // Too frequent, high server load
```

### 6. Keep Chart Data Manageable

- Limit datasets to under 500 data points
- Use aggregation for large datasets
- Consider date ranges for historical data

---

## Widget API Reference

### StatsOverviewWidget

```php
StatsOverviewWidget::make()
    ->heading(string $heading)
    ->description(string $description)
    ->icon(string $icon)
    ->color(string $color)
    ->columns(int $columns)  // 1-6
    ->stats(array $stats)
    ->polling(?int $interval)
```

### Stat

```php
Stat::make(string $label, string|int|float|Closure $value)
    ->description(string $description)
    ->icon(string $icon)
    ->color(string $color)
    ->chart(string $type, array $data, string $color)  // line|bar
    ->url(string $url)
    ->descriptionIcon(string $icon, string $color)
```

### LineChartWidget

```php
LineChartWidget::make(array $labels, array $datasets)
    ->heading(string $heading)
    ->description(string $description)
    ->curved()
    ->fill()
    ->showPoints(bool $show)
    ->showGrid(bool $show)
    ->height(int $height)
    ->polling(?int $interval)
```

### BarChartWidget

```php
BarChartWidget::make(array $labels, array $datasets)
    ->heading(string $heading)
    ->description(string $description)
    ->horizontal()
    ->stacked()
    ->showGrid(bool $show)
    ->barThickness(int $thickness)
    ->height(int $height)
    ->polling(?int $interval)
```

### PieChartWidget

```php
PieChartWidget::make(array $labels, array $data)
    ->heading(string $heading)
    ->description(string $description)
    ->doughnut()
    ->showLegend(bool $show)
    ->showPercentage(bool $show)
    ->height(int $height)
    ->polling(?int $interval)
```

---

## Next Steps

- [Panel](../panel/introduction.md) - Panel configuration
- [Tables](../tables/introduction.md) - Table widgets integration
