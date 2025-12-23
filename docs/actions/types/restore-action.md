---
title: RestoreAction
description: Restore soft-deleted records
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: RestoreAction
---

# RestoreAction

Restore soft-deleted records. Only visible for trashed records.

## Basic Usage

```php
use Laravilt\Actions\RestoreAction;

RestoreAction::make();
```

## Default Configuration

- **Icon**: RotateCcw
- **Color**: success
- **Requires Confirmation**: Yes
- Only visible for soft-deleted records

## Custom Confirmation

```php
use Laravilt\Actions\RestoreAction;

RestoreAction::make()
    ->modalHeading('Restore Record')
    ->modalDescription('This will restore the deleted record.')
    ->modalSubmitActionLabel('Restore');
```

## Authorization

```php
use Laravilt\Actions\RestoreAction;

RestoreAction::make()
    ->can(fn ($record) => auth()->user()->can('restore', $record));
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
