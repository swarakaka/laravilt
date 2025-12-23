---
title: KeyValue
description: Key-value pairs editor
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: KeyValue
vue_component: FormKeyValue
---

# KeyValue

Key-value pairs for metadata.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\KeyValue;

KeyValue::make('metadata');
```

## Custom Labels

```php
<?php

use Laravilt\Forms\Components\KeyValue;

KeyValue::make('attributes')
    ->keyLabel('Attribute Name')
    ->valueLabel('Attribute Value');
```

## Reorderable

```php
<?php

use Laravilt\Forms\Components\KeyValue;

KeyValue::make('headers')
    ->reorderable();
```

## Default Values

```php
<?php

use Laravilt\Forms\Components\KeyValue;

KeyValue::make('config')
    ->default([
        'debug' => 'false',
        'cache' => 'true',
    ]);
```

## Vue Component

Simple table-based editor:

```vue
<template>
  <div v-for="(pair, index) in pairs" :key="index">
    <input v-model="pair.key" />
    <input v-model="pair.value" />
  </div>
</template>
```

## API Reference

| Method | Description |
|--------|-------------|
| `keyLabel()` | Key column label |
| `valueLabel()` | Value column label |
| `reorderable()` | Enable reordering |
| `default()` | Default pairs |
