---
title: Component
description: Base component class
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: support
vue_component: Component
vue_package: "@laravilt/support"
---

# Component

Base class for all Laravilt UI components.

## Creating Components

```php
<?php

use Laravilt\Support\Component;

class TextInput extends Component
{
    protected string $view = 'laravilt::text-input';

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

## Methods

| Method | Return | Description |
|--------|--------|-------------|
| `make(string $name)` | `static` | Create instance |
| `getName()` | `string` | Get component name |
| `meta(array $meta)` | `static` | Set metadata |
| `getMeta()` | `array` | Get metadata |
| `render()` | `string` | Render to HTML |
| `toArray()` | `array` | Convert to array |
| `toJson(int $options)` | `string` | Convert to JSON |

## Serialization

```php
<?php

use Laravilt\Support\Component;

$component = TextInput::make('email');

// For Vue.js/Inertia
$props = $component->toLaraviltProps();

// For REST API
$props = $component->toApiProps();

// For Flutter
$props = $component->toFlutterProps();
```

## Laravilt Props Output

```php
<?php

[
    'component' => 'text_input',
    'id' => 'email',
    'name' => 'email',
    'label' => 'Email',
    'placeholder' => 'Enter text...',
    'hidden' => false,
    'disabled' => false,
    'required' => true,
    'rtl' => false,
    'theme' => 'light',
]
```

## Related

- [Concerns](concerns/introduction) - Traits
- [Forms](../forms/introduction) - Form components

