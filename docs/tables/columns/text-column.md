---
title: TextColumn
description: Text display column
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: TextColumn
vue_component: TableTextCell
---

# TextColumn

Text column with extensive formatting.

## Basic Usage

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')
    ->searchable()
    ->sortable();
```

## Badge Display

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('status')
    ->badge()
    ->color(fn (string $state): string => match($state) {
        'active' => 'success',
        'pending' => 'warning',
        default => 'secondary',
    });
```

## Date Formatting

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('created_at')
    ->dateTime('M d, Y')
    ->since();
```

## Currency & Copyable

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('price')->money('USD');
TextColumn::make('api_key')->copyable();
```

## API Reference

| Method | Description |
|--------|-------------|
| `badge()` | Badge display |
| `copyable()` | Copy button |
| `date()` | Date format |
| `dateTime()` | DateTime format |
| `since()` | Relative time |
| `money()` | Currency format |
| `limit()` | Character limit |
| `icon()` | Add icon |
| `url()` | Make link |
| `html()` | Render HTML |
