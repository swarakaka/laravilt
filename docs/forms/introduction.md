---
title: Forms Introduction
description: Declarative form builder with Vue.js integration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
---

# Forms Introduction

The Forms package provides a powerful, declarative form builder with Vue.js frontend integration.

## Overview

- **30+ Field Types** - Text, select, date, file upload, rich editor
- **Declarative Schema** - Define forms using PHP fluent syntax
- **Vue Integration** - Seamless frontend rendering with shadcn/ui
- **Reactive Fields** - Live updates and field dependencies
- **Layout Components** - Sections, grids, tabs, wizards

## Vue Component Stack

| Package | Purpose |
|---------|---------|
| **Vue 3** | Frontend framework |
| **shadcn/ui** | UI components (Radix Vue based) |
| **Lucide Icons** | Icon library |
| **VueUse** | Composables for reactivity |
| **Tiptap** | Rich text editor |
| **FilePond** | File uploads |

## Basic Usage

```php
<?php

use Laravilt\Schemas\Schema;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Select;
use Laravilt\Schemas\Components\Section;

public static function form(Schema $form): Schema
{
    return $form->schema([
        Section::make('User Information')
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required(),

                Select::make('role')
                    ->options([
                        'admin' => 'Administrator',
                        'user' => 'User',
                    ]),
            ])
            ->columns(2),
    ]);
}
```

## Related

### Field Categories
- [Inputs](inputs/introduction) - Text, number, hidden fields
- [Selection](selection/introduction) - Select, radio, checkbox, toggle
- [DateTime](datetime/introduction) - Date and time pickers
- [Media](media/introduction) - File upload, editors
- [Pickers](pickers/introduction) - Color, icon, tags
- [Data](data/introduction) - Repeater, builder, key-value

### Configuration
- [Layouts](layouts/introduction) - Section, grid, tabs, wizard
- [Validation](validation/introduction) - Rules and messages
- [Reactive](reactive/introduction) - Live updates, dependencies
- [Custom Fields](custom/introduction) - Create custom components
