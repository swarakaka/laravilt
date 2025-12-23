---
title: Tabs
description: Tabbed interface for content
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: schemas
vue_component: Tabs
vue_package: "@laravilt/schemas"
---

# Tabs

Organize content into tabbed panels.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;
use Laravilt\Forms\Components\TextInput;

Tabs::make('settings')
    ->tabs([
        Tab::make('general')
            ->label('General')
            ->schema([
                TextInput::make('name'),
            ]),
        Tab::make('security')
            ->label('Security')
            ->schema([
                TextInput::make('password')->password(),
            ]),
    ]);
```

## Tab with Icon

```php
<?php

Tab::make('profile')
    ->label('Profile')
    ->icon('User')
    ->schema([...]);
```

## Tab with Badge

```php
<?php

Tab::make('notifications')
    ->label('Notifications')
    ->icon('Bell')
    ->badge('5')
    ->schema([...]);
```

## Persist Active Tab

```php
<?php

Tabs::make('settings')
    ->persistTabInQueryString()
    ->tabs([...]);
```

## Set Active Tab

```php
<?php

Tabs::make('settings')
    ->activeTab(1)  // Second tab (0-indexed)
    ->tabs([...]);
```

## Tabs Methods

| Method | Description |
|--------|-------------|
| `make(string)` | Create tabs |
| `tabs(array)` | Set tab array |
| `activeTab(int)` | Default tab index |
| `persistTabInQueryString(bool)` | Persist in URL |
| `getTabs()` | Get tabs array |

## Tab Methods

| Method | Description |
|--------|-------------|
| `make(string)` | Create tab |
| `label(string\|Closure)` | Tab label |
| `icon(string\|Closure)` | Lucide icon |
| `badge(string\|Closure)` | Badge text |
| `schema(array)` | Tab content |
| `getLabel()` | Get label |
| `getIcon()` | Get icon |
| `getBadge()` | Get badge |
| `getSchema()` | Get schema |

## Complete Example

```php
<?php

Tabs::make('user')
    ->persistTabInQueryString()
    ->tabs([
        Tab::make('profile')
            ->label('Profile')
            ->icon('User')
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
            ]),
        Tab::make('security')
            ->label('Security')
            ->icon('Shield')
            ->schema([
                TextInput::make('password')->password(),
            ]),
    ]);
```

## Related

- [Section](section) - Grouped content
- [Wizard](wizard) - Multi-step forms

