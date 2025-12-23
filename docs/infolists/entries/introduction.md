---
title: Infolist Entries
description: Entry types for data display
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
concept: entries
---

# Infolist Entries

8 entry types for displaying data.

## Available Entries

| Entry | Description |
|-------|-------------|
| [TextEntry](text-entry) | Text with formatting |
| [BadgeEntry](badge-entry) | Styled badges |
| [IconEntry](icon-entry) | Lucide icons |
| [ImageEntry](image-entry) | Images/avatars |
| [ColorEntry](color-entry) | Color swatches |
| [KeyValueEntry](key-value-entry) | Key-value pairs |
| [RepeatableEntry](repeatable-entry) | Collections |
| [CodeEntry](code-entry) | Code blocks |

## Common Features

```php
<?php

use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('name')
    ->label('Full Name')
    ->icon('User')
    ->tooltip('User name')
    ->visible(fn () => auth()->user()->isAdmin());
```

## Default Values

```php
<?php

use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('bio')
    ->default('N/A')
    ->placeholder('Not provided');
```

## Related

- [Text Entry](text-entry) - Text display
- [Image Entry](image-entry) - Image display
- [Badge Entry](badge-entry) - Badge display
