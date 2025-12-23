---
title: ViewAction
description: Navigate to view page for a record
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: ViewAction
---

# ViewAction

Navigate to the view/show page for a record.

## Basic Usage

```php
use Laravilt\Actions\ViewAction;

ViewAction::make();
```

## Default Configuration

- **Icon**: Eye
- **Color**: secondary
- **Method**: GET
- Auto-resolves URL from resource context

## Custom Label

```php
use Laravilt\Actions\ViewAction;

ViewAction::make()
    ->label('View Details');
```

## Custom Icon

```php
use Laravilt\Actions\ViewAction;

ViewAction::make()
    ->icon('FileText');
```

## Open in New Tab

```php
use Laravilt\Actions\ViewAction;

ViewAction::make()
    ->openUrlInNewTab();
```

## Custom URL

```php
use Laravilt\Actions\ViewAction;

ViewAction::make()
    ->url(fn ($record) => route('posts.show', $record));
```

## Conditional Visibility

```php
use Laravilt\Actions\ViewAction;

ViewAction::make()
    ->visible(fn ($record) => $record->is_published);
```

## Authorization

```php
use Laravilt\Actions\ViewAction;

ViewAction::make()
    ->authorize(fn ($record) => auth()->user()->can('view', $record));

// Or using Spatie permissions
ViewAction::make()
    ->can('view posts');
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `?string $name` | Create action |
| `label()` | `string` | Set label |
| `icon()` | `string` | Set icon |
| `color()` | `string` | Set color |
| `url()` | `string\|Closure` | Custom URL |
| `openUrlInNewTab()` | — | Open in new tab |
| `visible()` | `bool\|Closure` | Show condition |
| `hidden()` | `bool\|Closure` | Hide condition |
| `authorize()` | `Closure` | Auth callback |
| `can()` | `string` | Spatie permission |
