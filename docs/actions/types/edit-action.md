---
title: EditAction
description: Navigate to edit page for a record
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: EditAction
---

# EditAction

Navigate to the edit page for a record. Auto-hides for soft-deleted records.

## Basic Usage

```php
use Laravilt\Actions\EditAction;

EditAction::make();
```

## Default Configuration

- **Icon**: Pencil
- **Color**: warning
- **Method**: GET
- Auto-hidden for trashed records
- Auto-resolves URL from resource context

## Custom Label

```php
use Laravilt\Actions\EditAction;

EditAction::make()
    ->label('Modify');
```

## Custom Icon

```php
use Laravilt\Actions\EditAction;

EditAction::make()
    ->icon('Edit2');
```

## Custom URL

```php
use Laravilt\Actions\EditAction;

EditAction::make()
    ->url(fn ($record) => route('posts.edit', $record));
```

## Conditional Visibility

```php
use Laravilt\Actions\EditAction;

EditAction::make()
    ->visible(fn ($record) => !$record->is_locked);
```

## Authorization

```php
use Laravilt\Actions\EditAction;

EditAction::make()
    ->authorize(fn ($record) => auth()->user()->can('update', $record));

// Using Spatie permissions
EditAction::make()
    ->can('edit posts');
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `?string $name` | Create action |
| `label()` | `string` | Set label |
| `icon()` | `string` | Set icon |
| `color()` | `string` | Set color |
| `url()` | `string\|Closure` | Custom URL |
| `visible()` | `bool\|Closure` | Show condition |
| `hidden()` | `bool\|Closure` | Hide condition |
| `authorize()` | `Closure` | Auth callback |
| `can()` | `string` | Spatie permission |
