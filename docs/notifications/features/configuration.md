---
title: Configuration
description: Notification configuration options
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: notifications
concept: configuration
---

# Configuration

Configure notification behavior globally.

## Config File

```php
<?php

// config/laravilt-notifications.php
return [
    'default_duration' => 4000,
    'position' => 'top-right',
    'sound_enabled' => true,
    'max_visible' => 3,

    'database' => [
        'enabled' => true,
        'polling' => 30,
        'max_items' => 50,
        'auto_read_on_view' => false,
    ],
];
```

## Position Options

```php
<?php

// config/laravilt-notifications.php
return [
    // top-left, top-center, top-right
    // bottom-left, bottom-center, bottom-right
    'position' => 'top-right',
];
```

## Duration

```php
<?php

// config/laravilt-notifications.php
return [
    'default_duration' => 4000, // 4 seconds
];

// Override per notification
Notification::make()
    ->title('Message')
    ->duration(8000)
    ->send();
```

## Sound Settings

```php
<?php

// config/laravilt-notifications.php
return [
    'sound_enabled' => true,
    'sound_file' => '/sounds/notification.mp3',
];

// Per notification
Notification::make()
    ->title('Alert')
    ->sound()
    ->send();
```

## Database Polling

```php
<?php

// In panel provider
$panel->databaseNotifications()
    ->polling(30);  // Check every 30 seconds
```

## Max Visible Toasts

```php
<?php

// config/laravilt-notifications.php
return [
    'max_visible' => 3,
];
```

## API Reference

| Option | Default | Description |
|--------|---------|-------------|
| `default_duration` | 4000 | Toast duration (ms) |
| `position` | top-right | Toast position |
| `sound_enabled` | true | Enable sounds |
| `max_visible` | 3 | Max visible toasts |
| `polling` | 30 | Database refresh (s) |
