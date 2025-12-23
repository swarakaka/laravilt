---
title: DateTimePicker
description: Date and time selection
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: DateTimePicker
vue_component: FormDateTimePicker
vue_package: "v-calendar"
---

# DateTimePicker

Combined date and time selection.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\DateTimePicker;

DateTimePicker::make('scheduled_at')
    ->label('Schedule Date & Time');
```

## Time Steps

```php
<?php

use Laravilt\Forms\Components\DateTimePicker;

DateTimePicker::make('meeting_time')
    ->minutesStep(15);
```

## Date and Time Formats

```php
<?php

use Laravilt\Forms\Components\DateTimePicker;

DateTimePicker::make('event_start')
    ->format('Y-m-d H:i:s')
    ->displayFormat('M j, Y g:i A');
```

## Vue Component

Uses v-calendar with time:

```vue
<script setup>
import { DatePicker } from 'v-calendar'
// mode="dateTime" enables time selection
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `minutesStep()` | Set minute intervals |
| `seconds()` | Show/hide seconds |
| `format()` | Set storage format |
| `displayFormat()` | Set display format |
| `minDate()` | Set minimum date |
| `maxDate()` | Set maximum date |
