---
title: Widgets
description: Dashboard widgets for Laravilt
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: widgets
vue_package: "@laravilt/widgets"
---

# Widgets

Dashboard widgets for displaying metrics and charts.

## Installation

```bash
composer require laravilt/widgets
```

## Documentation

- [Stats Overview](types/stats-overview) - Statistics grid
- [Line Chart](types/line-chart) - Trend charts
- [Bar Chart](types/bar-chart) - Bar charts
- [Pie Chart](types/pie-chart) - Pie/doughnut charts
- [Custom Widgets](custom-widgets) - Create widgets

## Quick Example

```php
<?php

use Laravilt\Widgets\StatsOverviewWidget;
use Laravilt\Widgets\Stat;

StatsOverviewWidget::make()
    ->heading('Overview')
    ->columns(3)
    ->stats([
        Stat::make('Users', fn () => User::count())
            ->icon('Users')
            ->color('primary'),
        Stat::make('Revenue', '$12,345')
            ->description('+12%')
            ->color('success'),
    ])
    ->polling(30);
```

## Widget Base Class

| Method | Description |
|--------|-------------|
| `make()` | Create instance |
| `heading(string)` | Widget title |
| `description(string)` | Description text |
| `icon(string)` | Widget icon |
| `color(string)` | Theme color |
| `polling(?int)` | Auto-refresh interval |

## Colors

```php
<?php

->color('primary')  // Blue
->color('success')  // Green
->color('danger')   // Red
->color('warning')  // Yellow
->color('info')     // Sky
```

## Related

- [Stat Component](stat) - Individual stats
- [Panel](../panel/introduction) - Dashboard integration

