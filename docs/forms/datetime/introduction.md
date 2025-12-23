---
title: DateTime Fields
description: Date and time picker components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: datetime
---

# DateTime Fields

Components for date and time selection.

## Available Components

| Component | Description | Vue Package |
|-----------|-------------|-------------|
| `DatePicker` | Date selection | v-calendar |
| `DateTimePicker` | Date and time | v-calendar |
| `TimePicker` | Time only | Custom component |
| `DateRangePicker` | Date range | v-calendar |

## Required Package

```bash
npm install v-calendar@next
```

## Vue Component

```vue
<script setup>
import { DatePicker } from 'v-calendar'
import 'v-calendar/style.css'
</script>
```

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\DatePicker;
use Laravilt\Forms\Components\DateTimePicker;
use Laravilt\Forms\Components\TimePicker;

DatePicker::make('birth_date')
    ->label('Date of Birth')
    ->required();

DateTimePicker::make('published_at')
    ->label('Publish Date');

TimePicker::make('start_time')
    ->label('Start Time');
```

## Date Formats

```php
DatePicker::make('date')
    ->format('Y-m-d')
    ->displayFormat('M d, Y');
```

## Min/Max Dates

```php
DatePicker::make('event_date')
    ->minDate(now())
    ->maxDate(now()->addYear());
```

## Date Range

```php
DateRangePicker::make('period')
    ->startDate('start_date')
    ->endDate('end_date');
```

## Related

- [DatePicker](date-picker) - Date selection
- [DateTimePicker](date-time-picker) - Date and time
- [TimePicker](time-picker) - Time only
