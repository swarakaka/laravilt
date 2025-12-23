---
title: Schema Class
description: Base schema for layouts
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: schemas
vue_component: Schema
vue_package: "@laravilt/schemas"
---

# Schema Class

Base class for form and infolist layouts.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Schema;
use Laravilt\Forms\Components\TextInput;

$schema = Schema::make()
    ->schema([
        TextInput::make('name'),
        TextInput::make('email'),
    ])
    ->columns(2);
```

## Methods

```php
<?php

Schema::make()
    ->schema([...])           // Set components
    ->columns(2)              // Grid columns
    ->model(User::class)      // Model class
    ->resourceSlug('users')   // Resource slug
    ->operation('edit')       // create/edit/view
    ->record($user)           // Model instance
    ->fill($data);            // Fill with data
```

## Getters

| Method | Return | Description |
|--------|--------|-------------|
| `getSchema()` | `array` | Get components |
| `getGridColumns()` | `int` | Column count |
| `getModel()` | `?string` | Model class |
| `getOperation()` | `?string` | Current operation |
| `getRecord()` | `mixed` | Model instance |
| `getData()` | `array` | Form data |

## Validation

```php
<?php

$rules = $schema->getValidationRules();
$messages = $schema->getValidationMessages();
$attributes = $schema->getValidationAttributes();
```

## Serialization

```php
<?php

// For Inertia
$props = $schema->toInertiaProps();

// With form data
$props = $schema->toLaraviltProps($data, $record);
```

## Related

- [Section](components/section) - Sections
- [Tabs](components/tabs) - Tabbed layout

