---
title: Broadcasting
description: Real-time notifications
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: notifications
concept: broadcasting
vue_package: "laravel-echo, pusher-js"
---

# Broadcasting

Real-time notifications with Laravel Echo.

## Setup Broadcasting

```php
<?php

// In NotificationServiceProvider
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
```

## Broadcast Notification

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('New message')
    ->body('You have a new message.')
    ->success()
    ->broadcast()
    ->sendTo($user);
```

## Database + Broadcast

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('New Comment')
    ->body('Someone commented.')
    ->info()
    ->sendToDatabase($user)
    ->broadcast();
```

## Vue Integration

```vue
<script setup lang="ts">
import Echo from '@/lib/echo'

const userId = inject('userId')

onMounted(() => {
  Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
      showNotification(notification)
    })
})
</script>
```

## Environment

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=mt1
```

## API Reference

| Method | Description |
|--------|-------------|
| `broadcast()` | Enable broadcasting |
| `sendTo()` | Send to user |
