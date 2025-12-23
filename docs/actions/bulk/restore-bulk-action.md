---
title: RestoreBulkAction
description: Bulk restore multiple soft-deleted records
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: RestoreBulkAction
---

# RestoreBulkAction

Bulk restore multiple soft-deleted records.

## Basic Usage

```php
use Laravilt\Actions\RestoreBulkAction;

RestoreBulkAction::make();
```

## Default Configuration

- **Icon**: RotateCcw
- **Color**: success
- **Requires Confirmation**: Yes
- Auto-deselects records after completion
- Shows count in success notification

## Specify Model

```php
use Laravilt\Actions\RestoreBulkAction;
use App\Models\Post;

RestoreBulkAction::make()
    ->model(Post::class);
```

## Custom Confirmation

```php
use Laravilt\Actions\RestoreBulkAction;

RestoreBulkAction::make()
    ->modalHeading('Restore Selected')
    ->modalDescription('This will restore all selected records.')
    ->modalSubmitActionLabel('Restore All');
```

## Requirements

Your model must use the `SoftDeletes` trait:

```php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
}
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
