---
title: TextInput
description: Single-line text input with multiple variants
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: inputs
vue_component: Input
vue_package: "@/components/ui/input"
---

# TextInput

Single-line text input supporting text, email, password, tel, url, and search types.

## Vue Component

Uses `Input` from **shadcn/ui** (Radix Vue based).

```vue
<script setup>
import { Input } from '@/components/ui/input'
</script>
```

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\TextInput;

TextInput::make('name')
    ->label('Full Name')
    ->required();
```

## Input Types

```php
TextInput::make('email')->email();
TextInput::make('password')->password()->revealable();
TextInput::make('phone')->tel();
TextInput::make('website')->url();
TextInput::make('search')->search();
```

## Prefix & Suffix

```php
TextInput::make('price')
    ->prefix('$')
    ->suffix('.00');

TextInput::make('email')
    ->prefixIcon('Mail')
    ->suffixIcon('Check');
```

## Character Limits

```php
TextInput::make('username')
    ->minLength(3)
    ->maxLength(20)
    ->characterCount();
```

## Input Masking

```php
TextInput::make('phone')
    ->mask('(999) 999-9999');

TextInput::make('credit_card')
    ->mask('9999 9999 9999 9999');
```

## Copyable

```php
TextInput::make('api_key')
    ->copyable()
    ->copyMessage('Copied!');
```

## API Reference

| Method | Description |
|--------|-------------|
| `email()` | Email type with validation |
| `password()` | Password with optional reveal |
| `tel()` | Telephone input |
| `url()` | URL input |
| `mask()` | Input mask pattern |
| `prefix()` / `suffix()` | Text decorations |
| `prefixIcon()` / `suffixIcon()` | Icon decorations |
| `copyable()` | Copy button |
| `characterCount()` | Show counter |

## Related

- [Textarea](textarea) - Multi-line text
- [NumberField](number-field) - Numeric input
