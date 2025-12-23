---
title: SelectColumn
description: Inline dropdown selection
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: SelectColumn
vue_component: TableSelectCell
vue_package: "radix-vue (Select)"
---

# SelectColumn

Inline dropdown for editable selection.

## Basic Usage

```php
<?php

use Laravilt\Tables\Columns\SelectColumn;

SelectColumn::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ]);
```

## With State Update

```php
<?php

use Laravilt\Tables\Columns\SelectColumn;

SelectColumn::make('status')
    ->options([
        'pending' => 'Pending',
        'approved' => 'Approved',
    ])
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['status' => $state]);
    });
```

## Searchable

```php
<?php

use Laravilt\Tables\Columns\SelectColumn;
use App\Models\Category;

SelectColumn::make('category_id')
    ->options(Category::pluck('name', 'id'))
    ->searchable();
```

## API Reference

| Method | Description |
|--------|-------------|
| `options()` | Options array |
| `searchable()` | Enable search |
| `multiple()` | Multi-select |
| `native()` | Native select |
| `afterStateUpdated()` | Update hook |
