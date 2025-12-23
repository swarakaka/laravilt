---
title: Notifications
description: Toast and database notifications
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: notifications
vue_component: NotificationCenter
vue_package: "radix-vue, lucide-vue-next"
---

# Notifications

Toast and database notification system.

## Features

| Feature | Description |
|---------|-------------|
| [Types](types/introduction) | Toast & database |
| [Features](features/actions) | Actions, sounds, config |
| [Custom](custom/introduction) | Custom classes |

## Quick Start

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('Saved successfully')
    ->success()
    ->send();
```

## Notification Types

```php
<?php

use Laravilt\Notifications\Notification;

// Success (green)
Notification::make()->title('Success')->success()->send();

// Warning (yellow)
Notification::make()->title('Warning')->warning()->send();

// Danger (red)
Notification::make()->title('Error')->danger()->send();

// Info (blue)
Notification::make()->title('Info')->info()->send();
```

## With Body & Icon

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('Post Published')
    ->body('Your post is now visible.')
    ->icon('CheckCircle')
    ->success()
    ->send();
```

## Database Notifications

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('New Order')
    ->body('Order #12345 received.')
    ->icon('ShoppingCart')
    ->sendToDatabase(auth()->user());
```

## Related

- [Toast](types/toast) - Temporary messages
- [Database](types/database) - Persistent notifications
