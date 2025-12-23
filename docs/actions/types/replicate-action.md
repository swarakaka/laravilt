---
title: ReplicateAction
description: Duplicate records with customization options
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: ReplicateAction
---

# ReplicateAction

Duplicate records using Laravel's replicate() method.

## Basic Usage

```php
use Laravilt\Actions\ReplicateAction;

ReplicateAction::make();
```

## Default Configuration

- **Icon**: Copy
- **Color**: gray
- **Requires Confirmation**: Yes

## Exclude Attributes

```php
use Laravilt\Actions\ReplicateAction;

ReplicateAction::make()
    ->excludeAttributes(['slug', 'published_at', 'views_count']);
```

## Before Save Callback

```php
use Laravilt\Actions\ReplicateAction;
use Illuminate\Support\Str;

ReplicateAction::make()
    ->beforeReplicaSaved(function ($replica) {
        $replica->title = $replica->title . ' (Copy)';
        $replica->is_published = false;
        $replica->slug = Str::slug($replica->title);
    });
```

## After Save Callback

```php
use Laravilt\Actions\ReplicateAction;

ReplicateAction::make()
    ->afterReplicaSaved(function ($replica, $original) {
        // Copy relationships
        foreach ($original->tags as $tag) {
            $replica->tags()->attach($tag);
        }
    });
```

## Success Redirect

```php
use Laravilt\Actions\ReplicateAction;

ReplicateAction::make()
    ->successRedirectUrl(fn ($record) => route('posts.edit', $record));
```

## Custom Confirmation

```php
use Laravilt\Actions\ReplicateAction;

ReplicateAction::make()
    ->modalHeading('Duplicate Record')
    ->modalDescription('This will create a copy of this record.')
    ->modalSubmitActionLabel('Create Copy');
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `?string $name` | Create action |
| `excludeAttributes()` | `array` | Attributes to exclude |
| `beforeReplicaSaved()` | `Closure` | Modify before save |
| `afterReplicaSaved()` | `Closure` | Run after save |
| `successRedirectUrl()` | `string\|Closure` | Redirect URL |
| `modalHeading()` | `string` | Modal title |
