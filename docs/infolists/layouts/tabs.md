---
title: Tabs
description: Tabbed content panels
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: Tabs
vue_component: InfolistTabs
vue_package: "radix-vue"
---

# Tabs

Organize entries into tabbed panels.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;
use Laravilt\Infolists\Entries\TextEntry;

Tabs::make()
    ->schema([
        Tab::make('Profile')
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('bio'),
            ]),
        Tab::make('Settings')
            ->schema([
                TextEntry::make('timezone'),
                TextEntry::make('locale'),
            ]),
    ]);
```

## With Icons

```php
<?php

use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;

Tabs::make()
    ->schema([
        Tab::make('Profile')
            ->icon('User')
            ->schema([...]),
        Tab::make('Notifications')
            ->icon('Bell')
            ->badge(5)
            ->schema([...]),
    ]);
```

## Contained Style

```php
<?php

use Laravilt\Schemas\Components\Tabs;

Tabs::make()
    ->contained()
    ->schema([...]);
```

## Vertical Tabs

```php
<?php

use Laravilt\Schemas\Components\Tabs;

Tabs::make()
    ->vertical()
    ->schema([...]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `contained()` | Card style |
| `vertical()` | Vertical layout |
| `icon()` | Tab icon |
| `badge()` | Tab badge count |
