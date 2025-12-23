---
title: Fieldset
description: HTML fieldset grouping with legend
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: schemas
vue_component: Fieldset
vue_package: "@laravilt/schemas"
---

# Fieldset

Wraps fields in HTML fieldset with legend.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Fieldset;
use Laravilt\Forms\Components\TextInput;

Fieldset::make('Contact Information')
    ->schema([
        TextInput::make('email'),
        TextInput::make('phone'),
    ]);
```

## With Label

```php
<?php

Fieldset::make('shipping')
    ->label('Shipping Address')
    ->schema([
        TextInput::make('street'),
        TextInput::make('city'),
    ]);
```

## With Legend

```php
<?php

Fieldset::make('billing')
    ->legend('Billing Information')
    ->schema([
        TextInput::make('card_number'),
        TextInput::make('expiry'),
    ]);
```

## Without Legend

```php
<?php

Fieldset::make()
    ->schema([
        TextInput::make('field1'),
        TextInput::make('field2'),
    ]);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(?string)` | Create fieldset |
| `label(string\|Closure)` | Set label |
| `legend(string\|Closure)` | Set legend (alias) |
| `schema(array)` | Child components |
| `getLabel()` | Get label |
| `getLegend()` | Get legend |
| `getSchema()` | Get schema |

## Related

- [Section](section) - Grouped content
- [Grid](grid) - Multi-column layout

