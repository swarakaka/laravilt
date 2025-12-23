---
title: Action Styling
description: Customize action appearance
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
---

# Action Styling

Customize the appearance of your actions.

## Colors

```php
use Laravilt\Actions\Action;

Action::make('action')
    ->color('primary')      // primary, secondary, success, warning, danger
    ->color('destructive')  // For delete actions
    ->color('success');     // For approve/activate actions
```

## Icons

```php
use Laravilt\Actions\Action;

Action::make('send')
    ->icon('Send')              // Lucide icon name
    ->iconPosition('after');    // before or after
```

## Variants

```php
use Laravilt\Actions\Action;

Action::make('view')
    ->button()          // Render as button (default)
    ->iconButton()      // Icon-only button
    ->link();           // Text link
```

## Sizes

```php
use Laravilt\Actions\Action;

Action::make('action')
    ->size('sm')        // sm, default, lg
    ->size('lg');
```

## Outlined Style

```php
use Laravilt\Actions\Action;

Action::make('action')
    ->outlined();       // Outlined button style
```

## Tooltips

```php
use Laravilt\Actions\Action;

Action::make('delete')
    ->icon('Trash2')
    ->tooltip('Delete this record')
    ->iconButton();
```

## Disabled State

```php
use Laravilt\Actions\Action;

Action::make('approve')
    ->disabled(fn ($record) => $record->is_locked);
```

## Next Steps

- [Confirmation](confirmation) - Modals and confirmations
- [Forms](forms) - Modal forms
- [Authorization](authorization) - Permissions
