---
title: Chart Components
description: Vue 3 chart components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_package: "@laravilt/schemas"
---

# Chart Components

Vue 3 chart components for dashboards.

## Installation

```bash
npm install @laravilt/schemas
```

## Available Charts

| Component | Description | Import |
|-----------|-------------|--------|
| LineChart | Line/area charts | `@laravilt/schemas` |
| BarChart | Bar charts | `@laravilt/schemas` |
| PieChart | Pie/doughnut | `@laravilt/schemas` |
| StatsCard | Statistics card | `@laravilt/schemas` |

## Quick Example

```vue
<script setup lang="ts">
import { LineChart } from '@laravilt/schemas'

const data = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    datasets: [
        {
            label: 'Revenue',
            data: [4500, 5200, 4800, 6100, 5900],
            borderColor: 'rgb(34, 197, 94)',
        }
    ]
}
</script>

<template>
    <LineChart :data="data" />
</template>
```

## Line Chart

```vue
<script setup>
import { LineChart } from '@laravilt/schemas'

const chartData = {
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
    datasets: [
        {
            label: 'Sales',
            data: [120, 150, 180, 90, 200],
            borderColor: 'rgb(59, 130, 246)',
            fill: true,
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
        }
    ]
}
</script>

<template>
    <LineChart :data="chartData" :curved="true" />
</template>
```

## Bar Chart

```vue
<script setup>
import { BarChart } from '@laravilt/schemas'

const chartData = {
    labels: ['Q1', 'Q2', 'Q3', 'Q4'],
    datasets: [
        {
            label: '2023',
            data: [100, 120, 90, 150],
            backgroundColor: 'rgb(156, 163, 175)',
        },
        {
            label: '2024',
            data: [140, 160, 130, 180],
            backgroundColor: 'rgb(59, 130, 246)',
        }
    ]
}
</script>

<template>
    <BarChart :data="chartData" />
</template>
```

## Pie Chart

```vue
<script setup>
import { PieChart } from '@laravilt/schemas'

const chartData = {
    labels: ['Desktop', 'Mobile', 'Tablet'],
    datasets: [
        {
            data: [60, 30, 10],
            backgroundColor: [
                'rgb(59, 130, 246)',
                'rgb(34, 197, 94)',
                'rgb(234, 179, 8)',
            ],
        }
    ]
}
</script>

<template>
    <PieChart :data="chartData" :doughnut="true" />
</template>
```

## Stats Card

```vue
<script setup>
import { StatsCard } from '@laravilt/schemas'
</script>

<template>
    <StatsCard
        label="Total Revenue"
        value="$45,231"
        description="+20% from last month"
        icon="DollarSign"
        color="success"
    />
</template>
```

## Related

- [Widgets Documentation](../../widgets/introduction)
- [Card](../ui/card) - Content cards

