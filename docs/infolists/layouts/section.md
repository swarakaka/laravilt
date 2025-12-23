---
title: Section
description: Group entries with heading
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: Section
vue_component: InfolistSection
---

# Section

Group entries with optional heading and description.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Section;
use Laravilt\Infolists\Entries\TextEntry;

Section::make('User Information')
    ->schema([
        TextEntry::make('name'),
        TextEntry::make('email'),
    ]);
```

## With Description

```php
<?php

use Laravilt\Schemas\Components\Section;
use Laravilt\Infolists\Entries\TextEntry;

Section::make('Contact Details')
    ->description('Primary contact information')
    ->schema([
        TextEntry::make('phone'),
        TextEntry::make('address'),
    ]);
```

## With Icon

```php
<?php

use Laravilt\Schemas\Components\Section;
use Laravilt\Infolists\Entries\TextEntry;

Section::make('Security')
    ->icon('Shield')
    ->schema([
        TextEntry::make('two_factor_enabled')->badge(),
    ]);
```

## Collapsible

```php
<?php

use Laravilt\Schemas\Components\Section;

Section::make('Advanced')
    ->collapsible()
    ->collapsed()
    ->schema([...]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `description()` | Section description |
| `icon()` | Heading icon |
| `collapsible()` | Enable collapse |
| `collapsed()` | Start collapsed |
| `aside()` | Side panel style |
