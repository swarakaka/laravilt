---
title: TimePicker
description: Time-only selection
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: TimePicker
vue_component: FormTimePicker
vue_package: "v-calendar"
---

# TimePicker

Time-only selection field.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\TimePicker;

TimePicker::make('start_time')
    ->label('Start Time');
```

## Time Format

```php
<?php

use Laravilt\Forms\Components\TimePicker;

TimePicker::make('opening_time')
    ->format('H:i');
```

## 12-Hour Format

```php
<?php

use Laravilt\Forms\Components\TimePicker;

TimePicker::make('appointment_time')
    ->format('h:i A');
```

## Vue Component

Uses v-calendar time mode:

```vue
<script setup>
import { DatePicker } from 'v-calendar'
// mode="time" for time-only
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `format()` | Set time format |
| `seconds()` | Show/hide seconds |
