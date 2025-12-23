---
title: Textarea
description: Multi-line text input field
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: Textarea
vue_component: FormTextarea
vue_package: "@vueuse/core (useTextareaAutosize)"
---

# Textarea

Multi-line text input with auto-expand.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\Textarea;

Textarea::make('description')
    ->label('Description')
    ->rows(4);
```

## Auto-Sizing

```php
<?php

use Laravilt\Forms\Components\Textarea;

Textarea::make('notes')
    ->autosize()
    ->rows(3);
```

## Character Limits

```php
<?php

use Laravilt\Forms\Components\Textarea;

Textarea::make('bio')
    ->minLength(50)
    ->maxLength(500)
    ->characterCount();
```

## Vue Component

Uses `@vueuse/core` for autosize:

```vue
<script setup>
import { useTextareaAutosize } from '@vueuse/core'
const { textarea } = useTextareaAutosize()
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `rows()` | Set visible rows |
| `cols()` | Set visible columns |
| `autosize()` | Enable auto-expansion |
| `minLength()` | Minimum characters |
| `maxLength()` | Maximum characters |
| `characterCount()` | Show counter |
