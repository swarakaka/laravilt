---
title: PinInput
description: PIN/OTP code input
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: PinInput
vue_component: FormPinInput
vue_package: "radix-vue (PinInput)"
---

# PinInput

PIN/OTP input with individual character boxes.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\PinInput;

PinInput::make('otp')
    ->label('Verification Code')
    ->length(6);
```

## Mask Input

```php
<?php

use Laravilt\Forms\Components\PinInput;

PinInput::make('pin')
    ->length(4)
    ->mask();
```

## OTP Mode

```php
<?php

use Laravilt\Forms\Components\PinInput;

PinInput::make('verification_code')
    ->length(6)
    ->otp()
    ->autoSubmit();
```

## Vue Component

Uses Radix Vue PinInput:

```vue
<script setup>
import { PinInputRoot, PinInputInput } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `length()` | Number of digits |
| `mask()` | Hide input values |
| `alphanumeric()` | Allow letters + numbers |
| `autoSubmit()` | Submit when complete |
| `otp()` | OTP mode with autocomplete |
