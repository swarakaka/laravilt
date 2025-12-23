---
title: TagsInput
description: Multi-tag input field
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: TagsInput
vue_component: FormTagsInput
vue_package: "radix-vue (TagsInput)"
---

# TagsInput

Multi-tag input with suggestions.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\TagsInput;

TagsInput::make('tags')
    ->label('Tags');
```

## Suggestions

```php
<?php

use Laravilt\Forms\Components\TagsInput;

TagsInput::make('skills')
    ->suggestions([
        'PHP', 'Laravel', 'Vue.js',
        'React', 'JavaScript',
    ]);
```

## Split Keys

```php
<?php

use Laravilt\Forms\Components\TagsInput;

TagsInput::make('emails')
    ->splitKeys(['Tab', 'Enter', ',']);
```

## Vue Component

Uses Radix Vue TagsInput:

```vue
<script setup>
import { TagsInputRoot, TagsInputInput } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `suggestions()` | Autocomplete suggestions |
| `separator()` | Value separator |
| `splitKeys()` | Keys to split tags |
