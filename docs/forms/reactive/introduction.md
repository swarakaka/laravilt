---
title: Reactive Fields
description: Live updates and field dependencies
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: reactive
---

# Reactive Fields

Live updates and field dependencies.

## Live Updates

Update immediately on change:

```php
<?php

use Laravilt\Forms\Components\TextInput;
use Illuminate\Support\Str;

TextInput::make('name')
    ->live()
    ->afterStateUpdated(function ($state, $set) {
        $set('slug', Str::slug($state));
    });
```

## Debounced Updates

```php
TextInput::make('search')
    ->live(debounce: 500);
```

## Update on Blur

```php
TextInput::make('title')
    ->lazy();
```

## Field Dependencies

```php
<?php

use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Get;

Select::make('country')
    ->options(['US' => 'USA', 'CA' => 'Canada'])
    ->live();

Select::make('state')
    ->options(fn (Get $get) => match ($get('country')) {
        'US' => ['CA' => 'California', 'NY' => 'New York'],
        'CA' => ['ON' => 'Ontario', 'BC' => 'British Columbia'],
        default => [],
    })
    ->dependsOn('country');
```

## Conditional Visibility

```php
Select::make('has_discount')
    ->boolean()
    ->live();

TextInput::make('discount_code')
    ->visible(fn (Get $get) => $get('has_discount'));
```

## Setting Other Fields

```php
<?php

use Laravilt\Forms\Set;

Select::make('template')
    ->options(['blank', 'blog', 'shop'])
    ->live()
    ->afterStateUpdated(function ($state, Set $set) {
        if ($state === 'blog') {
            $set('layout', 'sidebar');
            $set('show_author', true);
        }
    });
```

## Get and Set Helpers

| Helper | Purpose |
|--------|---------|
| `Get $get` | Read field values |
| `Set $set` | Update field values |
| `$record` | Access current record |
| `$operation` | 'create' or 'edit' |

## Related

- [Live Updates](live-updates) - Real-time updates
- [Dependencies](dependencies) - Field dependencies
