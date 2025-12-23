---
title: Action Confirmation
description: Confirmation modals for actions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
---

# Action Confirmation

Add confirmation dialogs before action execution.

## Basic Confirmation

```php
use Laravilt\Actions\Action;

Action::make('delete')
    ->requiresConfirmation()
    ->modalHeading('Delete Record')
    ->modalDescription('Are you sure you want to delete this record?')
    ->modalSubmitActionLabel('Yes, Delete')
    ->modalCancelActionLabel('Cancel')
    ->action(fn ($record) => $record->delete());
```

## Modal with Icon

```php
use Laravilt\Actions\Action;

Action::make('delete')
    ->requiresConfirmation()
    ->modalHeading('Delete Record')
    ->modalIcon('AlertCircle')
    ->modalIconColor('destructive')
    ->action(fn ($record) => $record->delete());
```

## Modal Sizes

```php
use Laravilt\Actions\Action;

Action::make('configure')
    ->requiresConfirmation()
    ->modalWidth('4xl')     // sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl
    ->modalHeading('Configure Settings');
```

## Slide-Over

```php
use Laravilt\Actions\Action;

Action::make('settings')
    ->slideOver()               // Use Sheet component
    ->modalHeading('Settings')
    ->modalFormSchema([...]);
```

## Password Confirmation

```php
use Laravilt\Actions\Action;

Action::make('deleteAccount')
    ->requiresPassword()
    ->modalHeading('Delete Account')
    ->modalDescription('Enter your password to confirm deletion')
    ->action(fn ($record) => $record->delete());
```

## Next Steps

- [Forms](forms) - Modal forms
- [Styling](styling) - Colors and icons
- [Authorization](authorization) - Permissions
