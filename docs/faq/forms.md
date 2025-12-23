---
title: Forms FAQ
description: Form fields and validation questions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: faq
---

# Forms FAQ

Common questions about forms, fields, and validation.

## Creating Forms

### How do I create a form?

```php
<?php

use Laravilt\Forms\Form;
use Laravilt\Forms\Components\TextInput;

Form::make()
    ->schema([
        TextInput::make('name')->required(),
        TextInput::make('email')->email(),
    ]);
```

## Validation

### How do I make a field required?

```php
<?php

use Laravilt\Forms\Components\TextInput;

TextInput::make('name')->required();
```

### How do I add validation rules?

```php
<?php

use Laravilt\Forms\Components\TextInput;

TextInput::make('email')
    ->email()
    ->unique('users', 'email')
    ->rules(['max:255']);
```

### How do I add custom validation?

```php
<?php

use Laravilt\Forms\Components\TextInput;

TextInput::make('username')
    ->rules([
        fn ($attribute, $value, $fail) =>
            str_contains($value, ' ')
                ? $fail('No spaces allowed')
                : null,
    ]);
```

## Reactive Fields

### How do I create dependent fields?

```php
<?php

use Laravilt\Forms\Components\Select;

Select::make('country_id')
    ->options(Country::pluck('name', 'id'))
    ->live();

Select::make('state_id')
    ->options(fn ($get) =>
        State::where('country_id', $get('country_id'))
            ->pluck('name', 'id')
    );
```

### How do I show/hide fields conditionally?

```php
<?php

use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;

Toggle::make('has_website')->live();

TextInput::make('website_url')
    ->visible(fn ($get) => $get('has_website'));
```

## File Uploads

### How do I handle file uploads?

```php
<?php

use Laravilt\Forms\Components\FileUpload;

FileUpload::make('avatar')
    ->image()
    ->disk('public')
    ->directory('avatars');
```

## Related

- [Forms Documentation](../forms/introduction)
- [Validation](../forms/validation/introduction)

