---
title: Action Notifications
description: Success and failure feedback
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
---

# Action Notifications

Provide feedback after action execution.

## Success Notification

```php
use Laravilt\Actions\Action;

Action::make('approve')
    ->action(fn ($record) => $record->approve())
    ->successNotificationTitle('Approved successfully');
```

## Custom Success Notification

```php
use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

Action::make('process')
    ->action(fn ($record) => $record->process())
    ->successNotification(
        Notification::make()
            ->title('Processing complete')
            ->body('The record has been processed.')
            ->success()
    );
```

## Failure Notification

```php
use Laravilt\Actions\Action;

Action::make('process')
    ->action(function ($record) {
        if (!$record->canBeProcessed()) {
            throw new \Exception('Cannot process this record');
        }
        $record->process();
    })
    ->failureNotificationTitle('Processing failed');
```

## Manual Notification

```php
use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

Action::make('publish')
    ->action(function ($record) {
        $record->publish();

        Notification::make()
            ->title('Post published')
            ->success()
            ->send();
    });
```

## Bulk Action Notification

```php
use Laravilt\Actions\BulkAction;
use Laravilt\Notifications\Notification;

BulkAction::make('publish')
    ->action(function ($records) {
        $records->each->publish();

        Notification::make()
            ->title("{$records->count()} posts published")
            ->success()
            ->send();
    });
```

## Next Steps

- [Confirmation](confirmation) - Confirmation modals
- [Authorization](authorization) - Permissions
- [Introduction](introduction) - Overview
