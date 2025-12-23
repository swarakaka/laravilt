---
title: Fieldset
description: Bordered entry grouping
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: Fieldset
vue_component: InfolistFieldset
---

# Fieldset

Group entries with a bordered container and legend.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Fieldset;
use Laravilt\Infolists\Entries\TextEntry;

Fieldset::make('Address')
    ->schema([
        TextEntry::make('street'),
        TextEntry::make('city'),
        TextEntry::make('state'),
        TextEntry::make('zip'),
    ]);
```

## With Columns

```php
<?php

use Laravilt\Schemas\Components\Fieldset;
use Laravilt\Infolists\Entries\TextEntry;

Fieldset::make('Contact')
    ->columns(2)
    ->schema([
        TextEntry::make('phone'),
        TextEntry::make('fax'),
        TextEntry::make('email'),
        TextEntry::make('website'),
    ]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `columns()` | Grid columns |
| `label()` | Legend text |
