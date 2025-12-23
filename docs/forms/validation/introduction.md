---
title: Validation
description: Form field validation rules
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: validation
---

# Validation

Laravel validation integration for form fields.

## Built-in Methods

```php
<?php

use Laravilt\Forms\Components\TextInput;

TextInput::make('email')
    ->required()
    ->email()
    ->unique('users', 'email', ignoreRecord: true)
    ->maxLength(255);

TextInput::make('age')
    ->numeric()
    ->integer()
    ->minValue(18)
    ->maxValue(120);

TextInput::make('website')
    ->url();

TextInput::make('password')
    ->password()
    ->minLength(8)
    ->confirmed();
```

## Custom Rules

```php
<?php

use Laravilt\Forms\Components\TextInput;

TextInput::make('username')
    ->rules([
        'required',
        'string',
        'min:3',
        'alpha_dash',
        function ($attribute, $value, $fail) {
            if (in_array(strtolower($value), ['admin', 'root'])) {
                $fail('This username is reserved.');
            }
        },
    ]);
```

## Validation Messages

```php
<?php

use Laravilt\Forms\Components\TextInput;

TextInput::make('email')
    ->required()
    ->email()
    ->validationMessages([
        'required' => 'Please enter your email.',
        'email' => 'Please enter a valid email.',
    ]);
```


## Available Methods

| Method | Rule |
|--------|------|
| `required()` | required |
| `email()` | email |
| `url()` | url |
| `numeric()` | numeric |
| `integer()` | integer |
| `rules()` | custom rules array |
| `minLength()` | min:x |
| `maxLength()` | max:x |
| `minValue()` | min:x |
| `maxValue()` | max:x |
| `unique()` | unique:table,column |
| `confirmed()` | confirmed |
| `regex()` | regex:pattern |

## Related

- [Reactive Fields](../reactive/introduction) - Live validation
- [Text Input](../inputs/text-input) - Input validation
