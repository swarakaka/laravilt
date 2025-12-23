---
title: Widgets FAQ
description: Dashboard widget questions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: faq
---

# Widgets FAQ

Common questions about dashboard widgets.

## Stats Widgets

### How do I create a stats widget?

```php
<?php

use Laravilt\Widgets\StatsOverviewWidget;
use Laravilt\Widgets\Stat;

StatsOverviewWidget::make()
    ->columns(3)
    ->stats([
        Stat::make('Users', User::count())
            ->icon('Users')
            ->color('primary'),
        Stat::make('Revenue', '$12,345')
            ->description('+12%')
            ->color('success'),
    ]);
```

### How do I add a trend indicator?

```php
<?php

use Laravilt\Widgets\Stat;

Stat::make('Sales', '$8,200')
    ->description('+15%')
    ->descriptionIcon('TrendingUp', 'success');
```

### How do I add a mini chart?

```php
<?php

use Laravilt\Widgets\Stat;

Stat::make('Revenue', '$45,231')
    ->chart([65, 59, 80, 81, 56, 55, 70], 'line', 'primary');
```

## Chart Widgets

### How do I create a line chart?

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(
    labels: ['Jan', 'Feb', 'Mar', 'Apr'],
    datasets: [
        [
            'label' => 'Revenue',
            'data' => [4500, 5200, 4800, 6100],
            'borderColor' => 'rgb(34, 197, 94)',
        ]
    ]
)
->heading('Revenue Trend')
->curved()
->fill();
```

### How do I create a bar chart?

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(
    labels: ['Q1', 'Q2', 'Q3', 'Q4'],
    datasets: [
        [
            'label' => 'Sales',
            'data' => [150, 200, 180, 250],
        ]
    ]
)
->stacked();
```

## Auto-Refresh

### How do I enable auto-refresh?

```php
<?php

use Laravilt\Widgets\StatsOverviewWidget;

StatsOverviewWidget::make()
    ->polling(30)  // Refresh every 30 seconds
    ->stats([...]);
```

## Related

- [Widgets Documentation](../widgets/introduction)
- [Stats Overview](../widgets/types/stats-overview)

