---
title: TextInputColumn
description: Inline text input
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: TextInputColumn
vue_component: TableTextInputCell
---

# TextInputColumn

Inline text input for editing.

## Basic Usage

```php
<?php

use Laravilt\Tables\Columns\TextInputColumn;

TextInputColumn::make('title')
    ->placeholder('Enter title...');
```

## Input Types

```php
<?php

use Laravilt\Tables\Columns\TextInputColumn;

TextInputColumn::make('email')->type('email');
TextInputColumn::make('quantity')->type('number');
TextInputColumn::make('phone')->type('tel');
```

## Prefix & Suffix

```php
<?php

use Laravilt\Tables\Columns\TextInputColumn;

TextInputColumn::make('price')
    ->prefix('$')
    ->type('number');
```

## With Validation

```php
<?php

use Laravilt\Tables\Columns\TextInputColumn;

TextInputColumn::make('email')
    ->rules(['required', 'email'])
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['email' => $state]);
    });
```

## API Reference

| Method | Description |
|--------|-------------|
| `type()` | Input type |
| `prefix()` | Prefix text |
| `suffix()` | Suffix text |
| `prefixIcon()` | Prefix icon |
| `rules()` | Validation |
| `afterStateUpdated()` | Update hook |
