---
title: TextEntry
description: Text display entry
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: TextEntry
vue_component: InfolistTextEntry
---

# TextEntry

Text display with formatting options.

## Basic Usage

```php
<?php

use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('name')
    ->label('Full Name');
```

## Badge Display

```php
<?php

use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('status')
    ->badge()
    ->color(fn (string $state): string => match($state) {
        'active' => 'success',
        'pending' => 'warning',
        default => 'secondary',
    });
```

## Date Formatting

```php
<?php

use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('created_at')
    ->dateTime('M d, Y')
    ->since();
```

## Currency & Copyable

```php
<?php

use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('price')->money('USD');
TextEntry::make('api_key')->copyable();
```

## HTML & Markdown

```php
<?php

use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('content')->html();
TextEntry::make('readme')->markdown()->prose();
```

## API Reference

| Method | Description |
|--------|-------------|
| `badge()` | Badge display |
| `copyable()` | Copy button |
| `date()` | Date format |
| `dateTime()` | DateTime format |
| `since()` | Relative time |
| `money()` | Currency format |
| `html()` | Render HTML |
| `markdown()` | Render markdown |
| `icon()` | Add icon |
| `limit()` | Character limit |
