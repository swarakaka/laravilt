---
title: Hidden
description: Hidden form field
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: Hidden
vue_component: FormHidden
---

# Hidden

Hidden field for storing invisible values.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\Hidden;

Hidden::make('user_id')
    ->default(auth()->id());
```

## With Closure

```php
<?php

use Laravilt\Forms\Components\Hidden;

Hidden::make('organization_id')
    ->default(fn () => auth()->user()->organization_id);
```

## Vue Component

Simple hidden input:

```vue
<template>
  <input type="hidden" :name="name" :value="modelValue" />
</template>
```

## API Reference

| Method | Description |
|--------|-------------|
| `make()` | Create hidden field |
| `default()` | Set default value |
