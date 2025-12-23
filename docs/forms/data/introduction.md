---
title: Data Fields
description: Complex data structure components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: data
---

# Data Fields

Components for complex data structures.

## Available Components

| Component | Description | Use Case |
|-----------|-------------|----------|
| `Repeater` | Repeating field groups | Multiple items |
| `Builder` | Block builder | Page content |
| `KeyValue` | Key-value pairs | Settings, meta |

## Repeater

Repeating groups of fields:

```php
<?php

use Laravilt\Forms\Components\Repeater;
use Laravilt\Forms\Components\TextInput;

Repeater::make('items')
    ->schema([
        TextInput::make('name')->required(),
        TextInput::make('quantity')->numeric(),
    ])
    ->minItems(1)
    ->maxItems(10)
    ->reorderable()
    ->collapsible();
```

## Builder

Block-based content builder:

```php
<?php

use Laravilt\Forms\Components\Builder;
use Laravilt\Forms\Components\Builder\Block;

Builder::make('content')
    ->blocks([
        Block::make('heading')
            ->schema([
                TextInput::make('content'),
                Select::make('level')->options(['h1', 'h2', 'h3']),
            ]),
        Block::make('paragraph')
            ->schema([
                RichEditor::make('content'),
            ]),
        Block::make('image')
            ->schema([
                FileUpload::make('image')->image(),
                TextInput::make('alt'),
            ]),
    ]);
```

## KeyValue

Key-value pair input:

```php
<?php

use Laravilt\Forms\Components\KeyValue;

KeyValue::make('metadata')
    ->keyLabel('Key')
    ->valueLabel('Value')
    ->reorderable();
```

## Vue Component Pattern

```vue
<template>
  <div v-for="(item, index) in items" :key="index">
    <slot :item="item" :index="index" />
    <Button @click="removeItem(index)">Remove</Button>
  </div>
  <Button @click="addItem">Add Item</Button>
</template>
```

## Related

- [Repeater](repeater) - Repeating groups
- [Builder](builder) - Block builder
- [KeyValue](key-value) - Key-value pairs
