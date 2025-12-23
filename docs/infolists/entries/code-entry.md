---
title: CodeEntry
description: Code blocks with syntax highlighting
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: CodeEntry
vue_component: InfolistCodeEntry
vue_package: shiki
---

# CodeEntry

Code blocks with syntax highlighting using Shiki.

## Basic Usage

```php
<?php

use Laravilt\Infolists\Entries\CodeEntry;

CodeEntry::make('source_code');
```

## Language Support

```php
<?php

use Laravilt\Infolists\Entries\CodeEntry;

CodeEntry::make('code')->php();
CodeEntry::make('script')->javascript();
CodeEntry::make('config')->json();
CodeEntry::make('types')->typescript();
CodeEntry::make('query')->sql();
CodeEntry::make('template')->html();
```

## Custom Language

```php
<?php

use Laravilt\Infolists\Entries\CodeEntry;

CodeEntry::make('code')
    ->language('ruby');
```

## Display Options

```php
<?php

use Laravilt\Infolists\Entries\CodeEntry;

CodeEntry::make('long_code')
    ->lineNumbers()
    ->maxHeight(300)
    ->copyable();
```

## API Reference

| Method | Description |
|--------|-------------|
| `language()` | Set language |
| `php()` | PHP syntax |
| `javascript()` | JS syntax |
| `json()` | JSON syntax |
| `typescript()` | TS syntax |
| `lineNumbers()` | Show line numbers |
| `maxHeight()` | Max height |
| `copyable()` | Enable copy |
