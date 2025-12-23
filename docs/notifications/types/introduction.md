---
title: Notification Types
description: Toast and database notification types
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: notifications
concept: types
---

# Notification Types

Two notification delivery methods available.

## Available Types

| Type | Description |
|------|-------------|
| [Toast](toast) | Temporary on-screen messages |
| [Database](database) | Persistent notification center |

## Toast Notifications

Temporary feedback that auto-dismisses:

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('Changes saved')
    ->success()
    ->send();
```

## Database Notifications

Persistent notifications with read/unread tracking:

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('New message')
    ->body('You have a new message.')
    ->sendToDatabase($user);
```

## Both Together

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('New Comment')
    ->body('Someone commented on your post.')
    ->info()
    ->sendToDatabase(auth()->user())
    ->send();
```

## Styling Options

| Method | Color |
|--------|-------|
| `success()` | Green |
| `warning()` | Yellow |
| `danger()` | Red |
| `info()` | Blue |

## Related

- [Toast](toast) - Temporary messages
- [Database](database) - Persistent center
