# Notifications Introduction

The Notifications package provides toast notifications and database notifications for user feedback in Laravilt applications.

## Overview

Laravilt Notifications offers:

- **Toast Notifications** - Temporary on-screen messages
- **Database Notifications** - Persistent notification center
- **Success/Warning/Danger/Info** - Styled notification types
- **Actions** - Interactive notification buttons
- **Auto-dismiss** - Configurable timeout
- **Sound** - Optional notification sounds

---

## Toast Notifications

### Basic Toast

```php
use Laravilt\Notifications\Notification;

Notification::make()
    ->title('Saved successfully')
    ->success()
    ->send();
```

### Notification Types

```php
// Success (green)
Notification::make()
    ->title('Operation successful')
    ->success()
    ->send();

// Warning (yellow)
Notification::make()
    ->title('Warning message')
    ->warning()
    ->send();

// Danger/Error (red)
Notification::make()
    ->title('Error occurred')
    ->danger()
    ->send();

// Info (blue)
Notification::make()
    ->title('Information')
    ->info()
    ->send();
```

### With Body Text

```php
Notification::make()
    ->title('Post Published')
    ->body('Your post has been published and is now visible to everyone.')
    ->success()
    ->send();
```

### With Icon

```php
Notification::make()
    ->title('Upload Complete')
    ->icon('CheckCircle')
    ->success()
    ->send();
```

### Custom Duration

```php
Notification::make()
    ->title('Message')
    ->success()
    ->duration(5000)    // 5 seconds (default: 4000)
    ->send();
```

### Persistent (No Auto-dismiss)

```php
Notification::make()
    ->title('Important Message')
    ->body('This requires your attention.')
    ->warning()
    ->persistent()      // Won't auto-dismiss
    ->send();
```

### With Sound

```php
Notification::make()
    ->title('New Message')
    ->info()
    ->sound()           // Play notification sound
    ->send();
```

---

## Notification Actions

Add interactive buttons to notifications:

```php
use Laravilt\Actions\Action;

Notification::make()
    ->title('New Comment')
    ->body('Someone commented on your post.')
    ->info()
    ->actions([
        Action::make('view')
            ->button()
            ->url(route('posts.show', $post)),

        Action::make('markAsRead')
            ->button()
            ->color('secondary')
            ->action(function () {
                // Mark as read logic
            }),
    ])
    ->send();
```

---

## Database Notifications

### Enable Database Notifications

In your panel provider:

```php
$panel->databaseNotifications();
```

### Send Database Notification

```php
use Laravilt\Notifications\Notification;

$recipient = auth()->user();

Notification::make()
    ->title('New Order')
    ->body('You have received a new order #12345.')
    ->icon('ShoppingCart')
    ->info()
    ->sendToDatabase($recipient);
```

### Send to Multiple Recipients

```php
$users = User::where('role', 'admin')->get();

Notification::make()
    ->title('System Alert')
    ->body('Critical system event occurred.')
    ->danger()
    ->sendToDatabase($users);
```

### Database & Toast Combined

```php
Notification::make()
    ->title('New Message')
    ->body('You have a new message from John.')
    ->info()
    ->sendToDatabase(auth()->user())
    ->send();  // Also show as toast
```

---

## Notification Center

### Accessing Notifications

The notification center is available in the panel header when database notifications are enabled.

### Mark as Read

```php
// Mark single notification as read
$notification->markAsRead();

// Mark all as read
auth()->user()->unreadNotifications->markAsRead();
```

### Delete Notification

```php
$notification->delete();
```

---

## Notification from Actions

Actions automatically send notifications:

```php
use Laravilt\Actions\Action;

Action::make('publish')
    ->action(fn ($record) => $record->publish())
    ->successNotificationTitle('Published successfully')
    ->successNotification(
        Notification::make()
            ->title('Post Published')
            ->body('Your post is now live.')
            ->success()
    );
```

---

## Flash Notifications

Send notifications via session flash (for redirects):

```php
// In Controller
public function store(Request $request)
{
    $product = Product::create($request->validated());

    Notification::make()
        ->title('Product created')
        ->success()
        ->send();

    return redirect()->route('products.index');
}
```

---

## Custom Notification Classes

### Create Custom Notification

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
            'body' => "Order #{$this->order->id} has been shipped.",
            'icon' => 'Truck',
            'color' => 'success',
        ];
    }

    public function toDatabase(): array
    {
        return [
            'title' => 'Order Shipped',
            'body' => "Order #{$this->order->id} has been shipped.",
            'icon' => 'Truck',
            'url' => route('orders.show', $this->order),
        ];
    }
}
```

### Send Custom Notification

```php
(new OrderShipped($order))
    ->sendToDatabase($user)
    ->send();
```

---

## Configuration

### Global Configuration

In `config/laravilt-notifications.php`:

```php
return [
    'default_duration' => 4000,     // Default toast duration (ms)
    'position' => 'top-right',      // top-right, top-left, bottom-right, bottom-left
    'sound_enabled' => true,        // Enable sound
    'max_visible' => 3,             // Max visible toasts
];
```

---

## Notification Builder API

### All Methods

```php
Notification::make()
    // Content
    ->title(string $title)
    ->body(string $body)
    ->icon(string $icon)

    // Styling
    ->success()
    ->warning()
    ->danger()
    ->info()
    ->color(string $color)

    // Behavior
    ->duration(int $milliseconds)
    ->persistent()
    ->sound()

    // Actions
    ->actions(array $actions)

    // Sending
    ->send()                            // Toast
    ->sendToDatabase(User|Collection)   // Database
```

---

## Complete Examples

### Success Toast

```php
Notification::make()
    ->title('Changes Saved')
    ->body('Your changes have been saved successfully.')
    ->icon('CheckCircle')
    ->success()
    ->duration(3000)
    ->send();
```

### Error Toast

```php
Notification::make()
    ->title('Upload Failed')
    ->body('The file could not be uploaded. Please try again.')
    ->icon('XCircle')
    ->danger()
    ->persistent()
    ->send();
```

### Warning with Action

```php
Notification::make()
    ->title('Low Stock Alert')
    ->body('Product inventory is running low.')
    ->icon('AlertTriangle')
    ->warning()
    ->actions([
        Action::make('restock')
            ->button()
            ->url(route('products.restock', $product)),
    ])
    ->send();
```

### Database Notification with Link

```php
Notification::make()
    ->title('New Comment')
    ->body('Someone commented on your post "' . $post->title . '".')
    ->icon('MessageCircle')
    ->info()
    ->actions([
        Action::make('view')
            ->button()
            ->url(route('posts.show', $post)),
    ])
    ->sendToDatabase($post->author);
```

---

## Real-time Notifications

### Broadcasting

Enable real-time notifications with Laravel Echo:

```php
// In NotificationServiceProvider
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
```

### Listen for Notifications

```javascript
// In your Vue component
import Echo from '@/lib/echo'

Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        // Display notification
        showNotification(notification)
    })
```

---

## Best Practices

### 1. Use Appropriate Types

```php
Notification::make()->success()  // For successful operations
Notification::make()->warning()  // For warnings
Notification::make()->danger()   // For errors
Notification::make()->info()     // For information
```

### 2. Keep Messages Concise

```php
// Good
Notification::make()
    ->title('Saved')
    ->body('Changes saved successfully.')

// Avoid
Notification::make()
    ->title('Success')
    ->body('Your changes have been successfully saved to the database...')
```

### 3. Use Icons for Visual Clarity

```php
Notification::make()
    ->title('Upload Complete')
    ->icon('Upload')
    ->success()
```

### 4. Provide Actions When Helpful

```php
Notification::make()
    ->title('Post Draft Saved')
    ->actions([
        Action::make('publish')->url(route('posts.publish', $post)),
        Action::make('preview')->url(route('posts.preview', $post)),
    ])
```

### 5. Use Database Notifications for Important Messages

```php
// Temporary feedback
Notification::make()->success()->send();

// Important notifications
Notification::make()->sendToDatabase($user);
```

---

## Next Steps

- [Actions](../actions/introduction.md) - Interactive action buttons
- [Panel](../panel/introduction.md) - Panel configuration
