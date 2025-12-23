---
title: ForceDeleteBulkAction
description: Permanently delete multiple records
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: ForceDeleteBulkAction
---

# ForceDeleteBulkAction

Permanently delete multiple selected records that cannot be recovered.

## Basic Usage

```php
use Laravilt\Actions\ForceDeleteBulkAction;

ForceDeleteBulkAction::make();
```

## Default Configuration

- **Icon**: Trash2
- **Color**: destructive
- **Requires Confirmation**: Yes
- Auto-deselects records after completion
- Permanently removes records (forceDelete)

## Specify Model

```php
use Laravilt\Actions\ForceDeleteBulkAction;
use App\Models\Post;

ForceDeleteBulkAction::make()
    ->model(Post::class);
```

## Custom Confirmation

```php
use Laravilt\Actions\ForceDeleteBulkAction;

ForceDeleteBulkAction::make()
    ->modalHeading('Permanently Delete Selected')
    ->modalDescription('This action cannot be undone. All selected records will be permanently removed.')
    ->modalSubmitActionLabel('Delete Permanently');
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
