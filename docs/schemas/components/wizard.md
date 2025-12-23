---
title: Wizard
description: Multi-step form workflow
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: schemas
vue_component: Wizard
vue_package: "@laravilt/schemas"
---

# Wizard

Multi-step form interface.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Wizard;
use Laravilt\Schemas\Components\Step;
use Laravilt\Forms\Components\TextInput;

Wizard::make()
    ->steps([
        Step::make('account')
            ->label('Account')
            ->description('Create your account')
            ->schema([
                TextInput::make('email')->email(),
                TextInput::make('password')->password(),
            ]),
        Step::make('profile')
            ->label('Profile')
            ->schema([
                TextInput::make('name'),
            ]),
    ]);
```

## Step with Icon

```php
<?php

Step::make('account')
    ->label('Account')
    ->icon('User')
    ->schema([...]);

Step::make('payment')
    ->label('Payment')
    ->icon('CreditCard')
    ->schema([...]);
```

## Skippable Wizard

```php
<?php

Wizard::make()
    ->skippable()
    ->steps([...]);
```

## Custom Button Labels

```php
<?php

Wizard::make()
    ->submitButtonLabel('Complete')
    ->nextButtonLabel('Continue')
    ->previousButtonLabel('Back')
    ->steps([...]);
```

## Wizard Methods

| Method | Description |
|--------|-------------|
| `make(string)` | Create wizard |
| `steps(array)` | Set step array |
| `skippable(bool)` | Allow step skipping |
| `submitButtonLabel(string\|Closure)` | Submit text |
| `nextButtonLabel(string\|Closure)` | Next text |
| `previousButtonLabel(string\|Closure)` | Previous text |
| `getSteps()` | Get steps array |

## Step Methods

| Method | Description |
|--------|-------------|
| `make(string)` | Create step |
| `label(string\|Closure)` | Step label |
| `description(string\|Closure)` | Step description |
| `icon(string\|Closure)` | Lucide icon |
| `schema(array)` | Step content |
| `getLabel()` | Get label |
| `getDescription()` | Get description |
| `getIcon()` | Get icon |
| `getSchema()` | Get schema |

## Complete Example

```php
<?php

Wizard::make()
    ->skippable()
    ->submitButtonLabel('Create Account')
    ->steps([
        Step::make('account')
            ->label('Account')
            ->description('Login credentials')
            ->icon('User')
            ->schema([
                TextInput::make('email')->email()->required(),
                TextInput::make('password')->password()->required(),
            ]),
        Step::make('profile')
            ->label('Profile')
            ->description('Your information')
            ->icon('UserCircle')
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('phone'),
            ]),
    ]);
```

## Related

- [Tabs](tabs) - Tabbed interface
- [Section](section) - Grouped content

