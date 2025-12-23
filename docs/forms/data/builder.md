---
title: Builder
description: Block builder for content
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: Builder
vue_component: FormBuilder
vue_package: "@vueuse/core (useSortable)"
---

# Builder

Block builder for flexible content.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\Builder;
use Laravilt\Forms\Components\Builder\Block;
use Laravilt\Forms\Components\TextInput;

Builder::make('content')
    ->blocks([
        Block::make('heading')
            ->label('Heading')
            ->icon('Type')
            ->schema([
                TextInput::make('content')->required(),
            ]),
        Block::make('paragraph')
            ->label('Paragraph')
            ->icon('AlignLeft')
            ->schema([
                Textarea::make('content'),
            ]),
    ]);
```

## Reorderable

```php
<?php

use Laravilt\Forms\Components\Builder;

Builder::make('page_content')
    ->blocks([...])
    ->reorderable()
    ->collapsible();
```

## Vue Component

Uses drag-and-drop:

```vue
<script setup>
import { useSortable } from '@vueuse/integrations/useSortable'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `blocks()` | Define block types |
| `reorderable()` | Enable reordering |
| `collapsible()` | Enable collapse |
| `cloneable()` | Enable cloning |
