---
title: Line Chart Widget
description: Line and area charts for trend visualization
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: widgets
vue_component: LineChartWidget
vue_package: "@laravilt/widgets"
---

# Line Chart Widget

Line charts for trend visualization.

## Basic Usage

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [
        [
            'label' => 'Revenue',
            'data' => [4500, 5200, 4800, 6100, 5900, 6800],
            'borderColor' => 'rgb(34, 197, 94)',
        ]
    ]
);
```

## With Heading

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(...)
    ->heading('Revenue Trend')
    ->description('Monthly revenue');
```

## Area Fill

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(...)
    ->fill();
```

## Curved Lines

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(...)
    ->curved();
```

## Show Points

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(...)
    ->showPoints();
```

## Show Grid

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(...)
    ->showGrid();
```

## Multiple Datasets

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
        ],
        [
            'label' => 'Expenses',
            'data' => [3000, 3500, 3200, 4000],
            'borderColor' => 'rgb(239, 68, 68)',
        ]
    ]
)
->fill()
->curved();
```

## Chart Height

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(...)
    ->height(350);
```

## Polling

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(...)
    ->polling(60);
```

## Chart Options

```php
<?php

use Laravilt\Widgets\LineChartWidget;

LineChartWidget::make(...)
    ->options([
        'scales' => [
            'y' => ['beginAtZero' => true],
        ],
    ]);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(labels, datasets)` | Create chart |
| `heading(string)` | Chart heading |
| `description(string)` | Chart description |
| `fill(bool)` | Enable area fill |
| `curved(bool)` | Curved lines |
| `showPoints(bool)` | Show data points |
| `showGrid(bool)` | Show grid lines |
| `height(int)` | Chart height (px) |
| `polling(?int)` | Refresh interval |
| `options(array)` | Chart.js options |

## Related

- [Bar Chart](bar-chart) - Bar charts
- [Pie Chart](pie-chart) - Pie charts

