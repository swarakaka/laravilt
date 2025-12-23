---
title: DatePicker
description: Date selection with calendar
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: DatePicker
vue_component: FormDatePicker
vue_package: "v-calendar"
---

# DatePicker

Date selection with calendar popup.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\DatePicker;

DatePicker::make('birth_date')
    ->label('Date of Birth');
```

## Date Formats

```php
<?php

use Laravilt\Forms\Components\DatePicker;

DatePicker::make('event_date')
    ->format('Y-m-d')
    ->displayFormat('F j, Y');
```

## Date Constraints

```php
<?php

use Laravilt\Forms\Components\DatePicker;

DatePicker::make('start_date')
    ->minDate(now())
    ->maxDate(now()->addYear());
```

## Disable Specific Dates

```php
<?php

use Laravilt\Forms\Components\DatePicker;

DatePicker::make('appointment_date')
    ->disabledDates(['2025-12-25', '2025-01-01']);
```

## Vue Component

Uses v-calendar:

```vue
<script setup>
import { DatePicker } from 'v-calendar'
import 'v-calendar/style.css'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `format()` | Set storage format |
| `displayFormat()` | Set display format |
| `minDate()` | Set minimum date |
| `maxDate()` | Set maximum date |
| `disabledDates()` | Disable dates |
| `native()` | Use native input |
