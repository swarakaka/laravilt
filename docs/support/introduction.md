---
title: Support Package
description: Core utilities and base classes
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: support
vue_package: "@laravilt/support"
---

# Support Package

Core utilities and base classes for Laravilt components.

## Installation

```bash
composer require laravilt/support
```

## Documentation

- [Component](component) - Base component class
- [Concerns](concerns/introduction) - Reusable traits
- [Utilities](utilities) - Get/Set helpers

## Quick Example

```php
<?php

use Laravilt\Support\Component;

class TextInput extends Component
{
    protected string $view = 'components.text-input';

    protected function setUp(): void
    {
        $this->placeholder('Enter text...');
    }
}

// Usage
TextInput::make('email')
    ->label('Email Address')
    ->required();
```

## Features

| Feature | Description |
|---------|-------------|
| Factory Pattern | `make()` static constructor |
| Multi-platform | Inertia, API, Flutter |
| RTL Support | Auto RTL/LTR detection |
| State Management | Component state handling |

## Facade

```php
<?php

use Laravilt\Support\Facades\Laravilt;

Laravilt::isLaraviltRequest();
Laravilt::auth();
```

## Related

- [Component](component) - Base class
- [Schemas](../schemas/introduction) - Layout components
- [Forms](../forms/introduction) - Form components

