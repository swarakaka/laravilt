---
title: Bar Chart Widget
description: Vertical and horizontal bar charts with stacking
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: widgets
vue_component: BarChartWidget
vue_package: "@laravilt/widgets"
---

# Bar Chart Widget

Bar charts for categorical data.

## Basic Usage

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(
    labels: ['Electronics', 'Furniture', 'Clothing', 'Sports'],
    datasets: [
        [
            'label' => 'Sales',
            'data' => [150, 89, 120, 65],
            'backgroundColor' => 'rgb(59, 130, 246)',
        ]
    ]
);
```

## With Heading

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(...)
    ->heading('Sales by Category')
    ->description('Units sold this quarter');
```

## Horizontal Bars

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(...)
    ->horizontal();
```

## Stacked Bars

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(
    labels: ['Q1', 'Q2', 'Q3', 'Q4'],
    datasets: [
        [
            'label' => 'Product A',
            'data' => [100, 120, 90, 150],
            'backgroundColor' => 'rgb(59, 130, 246)',
        ],
        [
            'label' => 'Product B',
            'data' => [80, 100, 110, 95],
            'backgroundColor' => 'rgb(34, 197, 94)',
        ],
    ]
)
->stacked();
```

## Show Grid

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(...)
    ->showGrid();
```

## Bar Thickness

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(...)
    ->barThickness(20);
```

## Chart Height

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(...)
    ->height(300);
```

## Polling

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(...)
    ->polling(60);
```

## Chart Options

```php
<?php

use Laravilt\Widgets\BarChartWidget;

BarChartWidget::make(...)
    ->options([
        'plugins' => [
            'legend' => ['position' => 'top'],
        ],
    ]);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(labels, datasets)` | Create chart |
| `heading(string)` | Chart heading |
| `description(string)` | Chart description |
| `horizontal(bool)` | Horizontal bars |
| `stacked(bool)` | Stack datasets |
| `showGrid(bool)` | Show grid lines |
| `barThickness(int)` | Bar thickness (px) |
| `height(int)` | Chart height (px) |
| `polling(?int)` | Refresh interval |
| `options(array)` | Chart.js options |

## Related

- [Line Chart](line-chart) - Line charts
- [Pie Chart](pie-chart) - Pie charts

