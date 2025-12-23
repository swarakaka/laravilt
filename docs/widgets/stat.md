---
title: Stat
description: Individual statistic component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: widgets
vue_component: Stat
vue_package: "@laravilt/widgets"
---

# Stat

Individual statistic for StatsOverviewWidget.

## Basic Usage

```php
<?php

use Laravilt\Widgets\Stat;

Stat::make('Revenue', '$45,231')
    ->description('+20% from last month')
    ->icon('DollarSign')
    ->color('success');
```

## With Closure

```php
<?php

use Laravilt\Widgets\Stat;

Stat::make('Active Users', fn () => User::where('active', true)->count())
    ->description('Currently online')
    ->icon('Users')
    ->color('primary');
```

## With Trend Icon

```php
<?php

Stat::make('Sales', '$12,234')
    ->description('+12.5%')
    ->descriptionIcon('TrendingUp', 'success')
    ->icon('ShoppingCart')
    ->color('success');
```

## With Mini Chart

```php
<?php

Stat::make('Revenue', '$45,231')
    ->chart([65, 59, 80, 81, 56, 55, 70], 'line', 'primary')
    ->description('+8% increase')
    ->icon('DollarSign');
```

## With URL

```php
<?php

Stat::make('Orders', '156')
    ->description('Pending orders')
    ->icon('ShoppingBag')
    ->url('/orders?status=pending');
```

## Methods

| Method | Description |
|--------|-------------|
| `make(label, value)` | Create stat |
| `description(string)` | Sub-text |
| `descriptionIcon(icon, color)` | Trend icon |
| `icon(string)` | Main icon |
| `color(string)` | Theme color |
| `chart(data, type, color)` | Mini chart |
| `url(string)` | Clickable link |

## Related

- [Stats Overview](types/stats-overview) - Parent widget

