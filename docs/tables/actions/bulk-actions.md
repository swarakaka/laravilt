---
title: Bulk Actions
description: Multiple records actions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: actions
vue_component: TableBulkActions
---

# Bulk Actions

Actions for multiple selected records.

## Built-in Bulk Actions

```php
<?php

use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\RestoreBulkAction;
use Laravilt\Actions\ForceDeleteBulkAction;

->bulkActions([
    DeleteBulkAction::make(),
    RestoreBulkAction::make(),
    ForceDeleteBulkAction::make(),
])
```

## Custom Bulk Action

```php
<?php

use Laravilt\Actions\BulkAction;
use Laravilt\Notifications\Notification;

->bulkActions([
    BulkAction::make('activate')
        ->label('Activate Selected')
        ->icon('CheckCircle')
        ->action(function ($records) {
            $records->each->activate();

            Notification::make()
                ->title("{$records->count()} activated")
                ->success()
                ->send();
        }),
])
```

## With Form

```php
<?php

use Laravilt\Actions\BulkAction;
use Laravilt\Forms\Components\Select;

BulkAction::make('assignCategory')
    ->form([
        Select::make('category_id')
            ->options(Category::pluck('name', 'id'))
            ->required(),
    ])
    ->action(function ($records, array $data) {
        $records->each->update(['category_id' => $data['category_id']]);
    });
```

## API Reference

| Method | Description |
|--------|-------------|
| `action()` | Action callback |
| `form()` | Action form |
| `requiresConfirmation()` | Show modal |
| `deselectRecordsAfterCompletion()` | Deselect after |
