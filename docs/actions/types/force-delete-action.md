---
title: ForceDeleteAction
description: Permanently delete records
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: ForceDeleteAction
---

# ForceDeleteAction

Permanently delete records. Only visible for trashed records.

## Basic Usage

```php
use Laravilt\Actions\ForceDeleteAction;

ForceDeleteAction::make();
```

## Default Configuration

- **Icon**: Trash2
- **Color**: destructive
- **Requires Confirmation**: Yes
- Only visible for soft-deleted records
- Permanently removes the record

## Custom Confirmation

```php
use Laravilt\Actions\ForceDeleteAction;

ForceDeleteAction::make()
    ->modalHeading('Permanently Delete')
    ->modalDescription('This action cannot be undone.')
    ->modalSubmitActionLabel('Delete Permanently');
```

## Authorization

```php
use Laravilt\Actions\ForceDeleteAction;

ForceDeleteAction::make()
    ->can(fn ($record) => auth()->user()->can('forceDelete', $record));
```

## Requirements

Your model must use the `SoftDeletes` trait:

```php
namespace App\Models;

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
| `label()` | `string` | Set label |
| `icon()` | `string` | Set icon |
| `color()` | `string` | Set color |
| `modalHeading()` | `string` | Modal title |
| `modalDescription()` | `string` | Modal message |
| `can()` | `Closure` | Authorization |
