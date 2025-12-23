---
title: DeleteBulkAction
description: Bulk delete multiple selected records
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: DeleteBulkAction
---

# DeleteBulkAction

Bulk soft-delete multiple selected records with confirmation.

## Basic Usage

```php
use Laravilt\Actions\DeleteBulkAction;

DeleteBulkAction::make();
```

## Default Configuration

- **Icon**: Trash2
- **Color**: destructive
- **Requires Confirmation**: Yes
- Auto-deselects records after completion
- Shows count in success notification

## Specify Model

```php
use Laravilt\Actions\DeleteBulkAction;
use App\Models\Post;

DeleteBulkAction::make()
    ->model(Post::class);
```

## Custom Confirmation

```php
use Laravilt\Actions\DeleteBulkAction;

DeleteBulkAction::make()
    ->modalHeading('Delete Selected')
    ->modalDescription('Are you sure you want to delete the selected records?')
    ->modalSubmitActionLabel('Delete All');
```

## Custom Label

```php
use Laravilt\Actions\DeleteBulkAction;

DeleteBulkAction::make()
    ->label('Remove Selected')
    ->icon('XCircle');
```

## Without Deselection

```php
use Laravilt\Actions\DeleteBulkAction;

DeleteBulkAction::make()
    ->deselectRecordsAfterCompletion(false);
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `?string $name` | Create action |
| `model()` | `string` | Set model class |
| `resource()` | `string` | Set resource class |
| `deselectRecordsAfterCompletion()` | `bool` | Auto-deselect |
| `modalHeading()` | `string` | Modal title |
| `modalDescription()` | `string` | Modal message |
| `modalSubmitActionLabel()` | `string` | Confirm button text |
