---
title: Schemas
description: Layout components for forms and infolists
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: schemas
vue_package: "@laravilt/schemas"
---

# Schemas

Layout components for organizing fields.

## Installation

```bash
composer require laravilt/schemas
```

## Documentation

- [Schema Class](schema) - Base schema class
- [Section](components/section) - Collapsible containers
- [Grid](components/grid) - Multi-column layouts
- [Tabs](components/tabs) - Tabbed interfaces
- [Wizard](components/wizard) - Multi-step forms
- [Fieldset](components/fieldset) - HTML fieldset
- [Split](components/split) - Two-pane layouts

## Quick Example

```php
<?php

use Laravilt\Schemas\Schema;
use Laravilt\Schemas\Components\Section;
use Laravilt\Forms\Components\TextInput;

Schema::make()
    ->columns(2)
    ->schema([
        Section::make('User Information')
            ->icon('User')
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
            ]),
    ]);
```

## Schema Methods

| Method | Description |
|--------|-------------|
| `make(?string)` | Create schema |
| `schema(array)` | Set components |
| `columns(int)` | Grid columns |
| `model(string)` | Model class |
| `operation(string)` | create/edit/view |
| `record(mixed)` | Model instance |
| `fill(array)` | Fill with data |

## Validation

```php
<?php

$rules = $schema->getValidationRules();
$messages = $schema->getValidationMessages();
$attributes = $schema->getValidationAttributes();
```

## Responsive Columns

```php
<?php

Grid::make()
    ->columns([
        'default' => 1,  // Mobile
        'md' => 2,       // Tablet
        'lg' => 3,       // Desktop
    ])
    ->schema([...]);
```

## Related

- [Forms](../forms/introduction) - Form fields
- [Infolists](../infolists/introduction) - Display entries

