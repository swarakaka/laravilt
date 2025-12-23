---
title: Infolists
description: Read-only data display components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
vue_component: Infolist
vue_package: "radix-vue, lucide-vue-next, shiki"
---

# Infolists

Read-only data display components.

## Vue Component Stack

| Layer | Package |
|-------|---------|
| UI Components | shadcn/ui (Radix Vue) |
| Icons | lucide-vue-next |
| Code Highlight | shiki |

## Basic Usage

```php
<?php

use Laravilt\Infolists\Infolist;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Infolists\Entries\ImageEntry;

Infolist::make()
    ->schema([
        ImageEntry::make('avatar')->circular(),
        TextEntry::make('name'),
        TextEntry::make('email')->copyable(),
        TextEntry::make('created_at')->dateTime(),
    ])
    ->fill($record);
```

## Features

| Feature | Description |
|---------|-------------|
| [Entries](entries/introduction) | 8 entry types |
| [Layouts](layouts/introduction) | Section, Grid, Tabs |
| [Custom](custom/introduction) | Vue components |

## Use Cases

- View Pages - Display record details
- Dashboards - Show key information
- Modals - Quick record preview
- Summaries - Formatted data display
