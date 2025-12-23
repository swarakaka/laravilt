---
title: KeyValueEntry
description: Key-value pairs display
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: KeyValueEntry
vue_component: InfolistKeyValueEntry
---

# KeyValueEntry

Key-value pairs in table format.

## Basic Usage

```php
<?php

use Laravilt\Infolists\Entries\KeyValueEntry;

KeyValueEntry::make('metadata');
```

## Custom Labels

```php
<?php

use Laravilt\Infolists\Entries\KeyValueEntry;

KeyValueEntry::make('settings')
    ->keyLabel('Setting')
    ->valueLabel('Value');
```

## Copyable

```php
<?php

use Laravilt\Infolists\Entries\KeyValueEntry;

KeyValueEntry::make('api_settings')
    ->copyableKeys()
    ->copyableValues();
```

## API Reference

| Method | Description |
|--------|-------------|
| `keyLabel()` | Key column label |
| `valueLabel()` | Value column label |
| `copyableKeys()` | Enable key copy |
| `copyableValues()` | Enable value copy |
