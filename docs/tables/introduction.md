---
title: Tables
description: Data tables with Vue 3 frontend
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
vue_component: DataTable
vue_package: "@tanstack/vue-table"
---

# Tables

Data table system with Vue 3 rendering.

## Vue Component Stack

| Layer | Package |
|-------|---------|
| Table Core | @tanstack/vue-table |
| UI Components | shadcn/ui (Radix Vue) |
| Icons | lucide-vue-next |
| Drag & Drop | @vueuse/core (useSortable) |

## Basic Usage

```php
<?php

use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\ImageColumn;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            ImageColumn::make('avatar')->circular(),
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email')->copyable(),
        ])
        ->actions([
            \Laravilt\Actions\ViewAction::make(),
            \Laravilt\Actions\EditAction::make(),
        ])
        ->searchable()
        ->paginated();
}
```

## Features

| Feature | Description |
|---------|-------------|
| [Columns](columns/introduction) | 8 column types |
| [Filters](filters/introduction) | 4 filter types |
| [Actions](actions/introduction) | Row & bulk actions |
| [Display](display/introduction) | Grid/card views |
| [Features](features/introduction) | Sorting, search, scroll |
| [API](api/introduction) | REST API generation |
| [Custom](custom/introduction) | Vue components & custom columns |
