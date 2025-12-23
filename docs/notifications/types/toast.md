---
title: Toast Notifications
description: Temporary on-screen messages
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: notifications
component: Notification
vue_component: Toast
---

# Toast Notifications

Temporary, auto-dismissing feedback messages.

## Basic Usage

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('Saved successfully')
    ->success()
    ->send();
```

## With Body & Icon

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('File uploaded')
    ->body('Your file has been uploaded.')
    ->icon('Upload')
    ->success()
    ->send();
```

## Duration

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('Quick message')
    ->duration(2000)  // 2 seconds
    ->send();

// Persistent (no auto-dismiss)
Notification::make()
    ->title('Action required')
    ->warning()
    ->persistent()
    ->send();
```

## With Sound

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('New message')
    ->success()
    ->sound()
    ->send();
```

## Position

```php
<?php

use Laravilt\Notifications\Notification;

Notification::make()
    ->title('Message')
    ->position('top-right')
    ->send();

// Positions: top-left, top-center, top-right
//           bottom-left, bottom-center, bottom-right
```

## API Reference

| Method | Description |
|--------|-------------|
| `title()` | Notification title |
| `body()` | Notification body |
| `icon()` | Lucide icon name |
| `success()` | Green style |
| `warning()` | Yellow style |
| `danger()` | Red style |
| `info()` | Blue style |
| `duration()` | Duration in ms |
| `persistent()` | No auto-dismiss |
| `sound()` | Play sound |
| `position()` | Toast position |
| `send()` | Send notification |
