---
title: Pie Chart Widget
description: Pie and doughnut charts for proportion visualization
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: widgets
vue_component: PieChartWidget
vue_package: "@laravilt/widgets"
---

# Pie Chart Widget

Pie and doughnut charts for proportional data.

## Basic Usage

```php
<?php

use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(
    labels: ['Electronics', 'Furniture', 'Clothing'],
    data: [45, 30, 25]
);
```

## With Heading

```php
<?php

use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(...)
    ->heading('Sales Distribution')
    ->description('By category');
```

## Doughnut Chart

```php
<?php

use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(...)
    ->doughnut();
```

## Show Legend

```php
<?php

use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(...)
    ->showLegend();
```

## Show Percentage

```php
<?php

use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(...)
    ->showPercentage();
```

## Chart Height

```php
<?php

use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(...)
    ->height(300);
```

## Polling

```php
<?php

use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(...)
    ->polling(60);
```

## Dynamic Data

```php
<?php

use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(
    labels: ['Completed', 'Processing', 'Pending', 'Cancelled'],
    data: [
        Order::where('status', 'completed')->count(),
        Order::where('status', 'processing')->count(),
        Order::where('status', 'pending')->count(),
        Order::where('status', 'cancelled')->count(),
    ]
)
->heading('Order Status')
->doughnut();
```

## Chart Options

```php
<?php

use Laravilt\Widgets\PieChartWidget;

PieChartWidget::make(...)
    ->options([
        'plugins' => [
            'legend' => ['position' => 'right'],
        ],
    ]);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(labels, data)` | Create chart |
| `heading(string)` | Chart heading |
| `description(string)` | Chart description |
| `doughnut(bool)` | Doughnut variation |
| `showLegend(bool)` | Show legend |
| `showPercentage(bool)` | Show percentages |
| `height(int)` | Chart height (px) |
| `polling(?int)` | Refresh interval |
| `options(array)` | Chart.js options |

## Related

- [Line Chart](line-chart) - Line charts
- [Bar Chart](bar-chart) - Bar charts

