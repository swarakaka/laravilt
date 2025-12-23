---
title: Custom Notifications
description: Create custom notification classes
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: notifications
concept: custom
---

# Custom Notifications

Create reusable notification classes.

## Basic Custom Class

```php
<?php

namespace App\Notifications;

use Laravilt\Notifications\Notification;

class OrderShipped extends Notification
{
    public function __construct(
        protected Order $order
    ) {}

    public function toToast(): array
    {
        return [
            'title' => 'Order Shipped',
            'body' => "Order #{$this->order->id} shipped.",
            'icon' => 'Truck',
            'color' => 'success',
        ];
    }

    public function toDatabase(): array
    {
        return [
            'title' => 'Order Shipped',
            'body' => "Order #{$this->order->id} shipped.",
            'icon' => 'Truck',
            'url' => route('orders.show', $this->order),
        ];
    }
}
```

## Usage

```php
<?php

use App\Notifications\OrderShipped;

(new OrderShipped($order))
    ->sendToDatabase($user)
    ->send();
```

## Laravel Notification Class

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Laravilt\Notifications\DatabaseMessage;

class NewOrderNotification extends Notification
{
    public function __construct(
        public Order $order
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return DatabaseMessage::make()
            ->title('New Order #' . $this->order->number)
            ->body('Total: $' . number_format($this->order->total, 2))
            ->icon('ShoppingCart')
            ->url('/orders/' . $this->order->id)
            ->success()
            ->toArray();
    }
}

// Usage
$user->notify(new NewOrderNotification($order));
```

## From Actions

```php
<?php

use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

Action::make('publish')
    ->action(fn ($record) => $record->publish())
    ->successNotification(
        Notification::make()
            ->title('Post Published')
            ->body('Your post is now live.')
            ->success()
    );
```

## API Reference

| Method | Description |
|--------|-------------|
| `toToast()` | Toast format |
| `toDatabase()` | Database format |
| `sendToDatabase()` | Save to database |
| `send()` | Send as toast |
