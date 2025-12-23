---
title: Schemas FAQ
description: Layout and schema component questions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: faq
---

# Schemas FAQ

Common questions about layouts and schema components.

## Layouts

### How do I create a multi-column layout?

```php
<?php

use Laravilt\Schemas\Components\Grid;
use Laravilt\Forms\Components\TextInput;

Grid::make(2)
    ->schema([
        TextInput::make('first_name'),
        TextInput::make('last_name'),
    ]);
```

### How do I create responsive columns?

```php
<?php

use Laravilt\Schemas\Components\Grid;

Grid::make()
    ->columns([
        'default' => 1,
        'md' => 2,
        'lg' => 3,
    ])
    ->schema([...]);
```

## Sections

### How do I create a section?

```php
<?php

use Laravilt\Schemas\Components\Section;
use Laravilt\Forms\Components\TextInput;

Section::make('User Information')
    ->description('Basic user details')
    ->icon('User')
    ->schema([
        TextInput::make('name'),
        TextInput::make('email'),
    ]);
```

### How do I make a section collapsible?

```php
<?php

use Laravilt\Schemas\Components\Section;

Section::make('Advanced Options')
    ->collapsible()
    ->collapsed()
    ->schema([...]);
```

## Tabs

### How do I create tabs?

```php
<?php

use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;

Tabs::make()
    ->tabs([
        Tab::make('general')
            ->label('General')
            ->icon('Settings')
            ->schema([...]),
        Tab::make('advanced')
            ->label('Advanced')
            ->schema([...]),
    ]);
```

## Wizard

### How do I create a multi-step form?

```php
<?php

use Laravilt\Schemas\Components\Wizard;
use Laravilt\Schemas\Components\Step;

Wizard::make()
    ->steps([
        Step::make('account')
            ->label('Account')
            ->schema([...]),
        Step::make('profile')
            ->label('Profile')
            ->schema([...]),
    ]);
```

## Related

- [Schemas Documentation](../schemas/introduction)
- [Grid](../schemas/components/grid)
- [Tabs](../schemas/components/tabs)

