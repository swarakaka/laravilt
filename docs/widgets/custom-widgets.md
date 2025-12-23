---
title: Custom Widgets
description: Create your own widgets with custom content
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: widgets
vue_package: "@laravilt/widgets"
---

# Custom Widgets

Create custom widgets with your own content.

## Generating a Widget

```bash
php artisan laravilt:widget RecentOrdersWidget

php artisan laravilt:widget DashboardStats --type=stats

php artisan laravilt:widget SalesChart --type=chart --chart=line
```

## Basic Widget

```php
<?php

namespace App\Widgets;

use Laravilt\Widgets\Widget;

class RecentOrdersWidget extends Widget
{
    public function toInertiaProps(): array
    {
        return [
            'component' => 'RecentOrdersWidget',
            'heading' => 'Recent Orders',
            'orders' => Order::with('customer')
                ->latest()
                ->limit(5)
                ->get()
                ->map(fn ($order) => [
                    'id' => $order->id,
                    'customer' => $order->customer->name,
                    'total' => '$' . number_format($order->total, 2),
                ]),
            'polling' => [
                'enabled' => $this->pollingEnabled,
                'interval' => $this->pollingInterval,
            ],
        ];
    }
}
```

## Stats Widget

```php
<?php

namespace App\Widgets;

use Laravilt\Widgets\StatsOverviewWidget;
use Laravilt\Widgets\Stat;

class DashboardStatsWidget extends StatsOverviewWidget
{
    public function getStats(): array
    {
        return [
            Stat::make('Revenue', fn() => '$' . number_format(Order::sum('total'), 2))
                ->icon('DollarSign')
                ->color('success'),

            Stat::make('Users', User::count())
                ->icon('Users')
                ->color('primary'),
        ];
    }
}
```

## Chart Widget

```php
<?php

namespace App\Widgets;

use Laravilt\Widgets\LineChartWidget;

class SalesChartWidget extends LineChartWidget
{
    protected function getData(): array
    {
        $sales = Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->get();

        return [
            'labels' => $sales->pluck('date')->toArray(),
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $sales->pluck('total')->toArray(),
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
            ],
        ];
    }

    public function toInertiaProps(): array
    {
        $this->data($this->getData());
        $this->curved();
        $this->fill();

        return parent::toInertiaProps();
    }
}
```

## Registering Widgets

```php
<?php

use App\Widgets\DashboardStatsWidget;
use App\Widgets\SalesChartWidget;

class DashboardPage extends Page
{
    public function getWidgets(): array
    {
        return [
            DashboardStatsWidget::make()
                ->columns(4)
                ->polling(30),

            SalesChartWidget::make()
                ->heading('Sales Trend')
                ->height(350),
        ];
    }
}
```

## Widget Base Methods

| Method | Description |
|--------|-------------|
| `make()` | Create instance |
| `heading(string)` | Set heading |
| `description(string)` | Set description |
| `icon(string)` | Set Lucide icon |
| `color(string)` | Set color theme |
| `polling(?int)` | Enable auto-refresh |
| `extraAttributes(string)` | Add HTML attributes |
| `toInertiaProps()` | Serialize to props |

## Related

- [Stats Overview](types/stats-overview) - Stats widget
- [Line Chart](types/line-chart) - Chart widget

