---
title: Stats Overview Widget
description: Display multiple statistics in responsive grid layout
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: widgets
vue_component: StatsOverviewWidget
vue_package: "@laravilt/widgets"
---

# Stats Overview Widget

Display multiple statistics in a grid.

## Basic Usage

```php
<?php

use Laravilt\Widgets\StatsOverviewWidget;
use Laravilt\Widgets\Stat;

StatsOverviewWidget::make()
    ->stats([
        Stat::make('Total Users', User::count()),
        Stat::make('Total Orders', Order::count()),
        Stat::make('Revenue', '$' . number_format(Order::sum('total'), 2)),
    ]);
```

## With Heading

```php
<?php

use Laravilt\Widgets\StatsOverviewWidget;

StatsOverviewWidget::make()
    ->heading('Business Metrics')
    ->description('Real-time dashboard statistics')
    ->stats([...]);
```

## Column Layout

```php
<?php

use Laravilt\Widgets\StatsOverviewWidget;

StatsOverviewWidget::make()
    ->columns(4)
    ->stats([...]);
```

## Stat Configuration

### With Icon

```php
<?php

use Laravilt\Widgets\Stat;

Stat::make('Users', User::count())
    ->icon('Users')
    ->color('primary');
```

### With Description

```php
<?php

use Laravilt\Widgets\Stat;

Stat::make('Revenue', '$12,500')
    ->description('+12% from last month')
    ->descriptionIcon('TrendingUp', 'success');
```

### With Mini Chart

```php
<?php

use Laravilt\Widgets\Stat;

Stat::make('Sales', '$8,200')
    ->chart([100, 150, 120, 180, 160, 200], 'line', 'success');

Stat::make('Visitors', 1234)
    ->chart([50, 80, 60, 90, 70, 100], 'bar', 'primary');
```

### Dynamic Values

```php
<?php

use Laravilt\Widgets\Stat;

Stat::make('Revenue', fn () => '$' . number_format(Order::sum('total'), 2))
    ->icon('DollarSign')
    ->color('success');
```

## Polling

```php
<?php

use Laravilt\Widgets\StatsOverviewWidget;

StatsOverviewWidget::make()
    ->polling(30)
    ->stats([...]);
```

## StatsOverviewWidget Methods

| Method | Description |
|--------|-------------|
| `make()` | Create widget |
| `heading(string)` | Widget heading |
| `description(string)` | Widget description |
| `stats(array)` | Stat components |
| `columns(int)` | Grid columns |
| `polling(?int)` | Refresh interval |

## Stat Methods

| Method | Description |
|--------|-------------|
| `make(label, value)` | Create stat |
| `description(string)` | Description text |
| `descriptionIcon(icon, ?color)` | Trend icon |
| `icon(string)` | Lucide icon |
| `color(string)` | Stat color |
| `chart(data, ?type, ?color)` | Mini chart |
| `url(string)` | Clickable link |

## Related

- [Stat](../stat) - Individual stat
- [Line Chart](line-chart) - Trend charts

