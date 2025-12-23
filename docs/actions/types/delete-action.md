---
title: DeleteAction
description: Soft delete a record with confirmation
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: DeleteAction
---

# DeleteAction

Soft delete a record with confirmation dialog. Auto-hidden for trashed records.

## Basic Usage

```php
use Laravilt\Actions\DeleteAction;

DeleteAction::make();
```

## Default Configuration

- **Icon**: Trash2
- **Color**: destructive
- **Requires Confirmation**: Yes
- Performs soft delete
- Auto-hidden for trashed records

## Custom Confirmation

```php
use Laravilt\Actions\DeleteAction;

DeleteAction::make()
    ->modalHeading('Delete Post')
    ->modalDescription('Are you sure you want to delete this post?')
    ->modalSubmitActionLabel('Yes, delete it');
```

## Custom Icon

```php
use Laravilt\Actions\DeleteAction;

DeleteAction::make()
    ->icon('XCircle');
```

## Without Confirmation

```php
use Laravilt\Actions\DeleteAction;

DeleteAction::make()
    ->requiresConfirmation(false);
```

## After Delete Redirect

```php
use Laravilt\Actions\DeleteAction;

DeleteAction::make()
    ->successRedirectUrl('/posts');
```

## Custom Delete Logic

```php
use Laravilt\Actions\DeleteAction;

DeleteAction::make()
    ->action(function ($record) {
        $record->archived_at = now();
        $record->save();
    });
```

## Authorization

```php
use Laravilt\Actions\DeleteAction;

DeleteAction::make()
    ->authorize(fn ($record) => auth()->user()->can('delete', $record));

// Using Spatie permissions
DeleteAction::make()
    ->can('delete posts');
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `?string $name` | Create action |
| `label()` | `string` | Set label |
| `icon()` | `string` | Set icon |
| `requiresConfirmation()` | `bool` | Show confirmation |
| `modalHeading()` | `string` | Modal title |
| `modalDescription()` | `string` | Modal message |
| `action()` | `Closure` | Custom delete logic |
| `successRedirectUrl()` | `string` | Redirect after delete |
| `authorize()` | `Closure` | Auth callback |
