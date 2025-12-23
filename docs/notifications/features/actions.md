---
title: Notification Actions
description: Interactive notification buttons
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: notifications
concept: actions
---

# Notification Actions

Add interactive buttons to notifications.

## Basic Actions

```php
<?php

use Laravilt\Notifications\Notification;
use Laravilt\Actions\Action;

Notification::make()
    ->title('New Comment')
    ->body('Someone commented on your post.')
    ->info()
    ->actions([
        Action::make('view')
            ->button()
            ->url(route('posts.show', $post)),
    ])
    ->send();
```

## Multiple Actions

```php
<?php

use Laravilt\Notifications\Notification;
use Laravilt\Actions\Action;

Notification::make()
    ->title('New Order')
    ->body('Order #12345 needs processing.')
    ->success()
    ->actions([
        Action::make('view')
            ->label('View Order')
            ->url('/orders/12345'),

        Action::make('dismiss')
            ->label('Dismiss')
            ->close(),
    ])
    ->send();
```

## Action Callbacks

```php
<?php

use Laravilt\Notifications\Notification;
use Laravilt\Actions\Action;

Notification::make()
    ->title('New Comment')
    ->actions([
        Action::make('markAsRead')
            ->button()
            ->color('secondary')
            ->action(function () {
                // Mark as read logic
            }),
    ])
    ->send();
```

## Database Actions

```php
<?php

use Laravilt\Notifications\Notification;
use Laravilt\Actions\Action;

Notification::make()
    ->title('Team Invitation')
    ->body('Join Team Alpha')
    ->actions([
        Action::make('accept')
            ->label('Accept')
            ->url('/invitations/123/accept')
            ->color('success'),

        Action::make('decline')
            ->label('Decline')
            ->url('/invitations/123/decline')
            ->color('danger'),
    ])
    ->sendToDatabase($user);
```

## API Reference

| Method | Description |
|--------|-------------|
| `actions()` | Set action buttons |
| `button()` | Button style |
| `url()` | Action URL |
| `close()` | Close notification |
| `action()` | Callback function |
| `color()` | Button color |
