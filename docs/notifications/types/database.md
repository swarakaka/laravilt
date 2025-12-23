---
title: Database Notifications
description: Persistent notification center
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: notifications
component: Notification
vue_component: NotificationCenter
---

# Database Notifications

Persistent notifications with read/unread tracking.

## Enable in Panel

```php
<?php

use Laravilt\Panel\Panel;

public function panel(Panel $panel): Panel
{
    return $panel->databaseNotifications();
}
```

## Basic Usage

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('New comment')
    ->body('John commented on your post.')
    ->icon('MessageCircle')
    ->sendToDatabase($user);
```

## Multiple Recipients

```php
<?php

use Laravilt\Notifications\Notification;
use App\Models\User;

$admins = User::where('role', 'admin')->get();

Notification::make()
    ->title('System Alert')
    ->danger()
    ->sendToDatabase($admins);
```

## Polling

```php
<?php

$panel->databaseNotifications()
    ->polling(30);  // Check every 30 seconds
```

## Mark as Read

```php
<?php

// Single notification
$notification->markAsRead();

// All notifications
$user->unreadNotifications->markAsRead();
```

## Query Notifications

```php
<?php

// All notifications
$user->notifications;

// Unread only
$user->unreadNotifications;

// Read only
$user->readNotifications;
```

## API Reference

| Method | Description |
|--------|-------------|
| `sendToDatabase()` | Save to database |
| `markAsRead()` | Mark as read |
| `databaseNotifications()` | Enable in panel |
| `polling()` | Refresh interval |
