---
title: Checkbox
description: Single checkbox field
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: Checkbox
vue_component: FormCheckbox
vue_package: "radix-vue (Checkbox)"
---

# Checkbox

Single checkbox for boolean values.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\Checkbox;

Checkbox::make('is_active')
    ->label('Active');
```

## Agreement Checkbox

```php
<?php

use Laravilt\Forms\Components\Checkbox;

Checkbox::make('terms_accepted')
    ->label('I accept the terms and conditions')
    ->required()
    ->accepted();
```

## Default Value

```php
<?php

use Laravilt\Forms\Components\Checkbox;

Checkbox::make('newsletter')
    ->label('Subscribe to newsletter')
    ->default(true);
```

## Vue Component

Uses Radix Vue Checkbox:

```vue
<script setup>
import { CheckboxRoot, CheckboxIndicator } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `label()` | Set label |
| `default()` | Set default |
| `accepted()` | Must be checked |
| `inline()` | Display inline |
| `helperText()` | Add helper text |
