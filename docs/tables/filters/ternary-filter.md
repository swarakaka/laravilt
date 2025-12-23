---
title: TernaryFilter
description: Three-state boolean filter
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: TernaryFilter
vue_component: TableTernaryFilter
vue_package: "radix-vue (ToggleGroup)"
---

# TernaryFilter

True/False/All boolean filter.

## Basic Usage

```php
<?php

use Laravilt\Tables\Filters\TernaryFilter;

TernaryFilter::make('is_active')
    ->label('Active Status');
```

## Custom Labels

```php
<?php

use Laravilt\Tables\Filters\TernaryFilter;

TernaryFilter::make('is_featured')
    ->trueLabel('Featured Only')
    ->falseLabel('Not Featured')
    ->placeholder('All Items');
```

## Nullable Mode

```php
<?php

use Laravilt\Tables\Filters\TernaryFilter;

TernaryFilter::make('verified_at')
    ->nullable()
    ->trueLabel('Verified')
    ->falseLabel('Unverified');
```

## Custom Queries

```php
<?php

use Laravilt\Tables\Filters\TernaryFilter;

TernaryFilter::make('has_orders')
    ->queries(
        true: fn ($query) => $query->has('orders'),
        false: fn ($query) => $query->doesntHave('orders'),
    );
```

## API Reference

| Method | Description |
|--------|-------------|
| `trueLabel()` | True label |
| `falseLabel()` | False label |
| `placeholder()` | All label |
| `nullable()` | NULL mode |
| `queries()` | Custom queries |
