---
title: Custom BulkAction
description: Create custom actions for multiple selected records
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: BulkAction
---

# Custom BulkAction

Create custom actions that operate on multiple selected records.

## Basic Usage

```php
use Laravilt\Actions\BulkAction;

BulkAction::make('approve_all')
    ->label('Approve Selected')
    ->icon('CheckCircle')
    ->color('success')
    ->action(function (array $records) {
        foreach ($records as $record) {
            $record->update(['status' => 'approved']);
        }
    });
```

## With Confirmation

```php
use Laravilt\Actions\BulkAction;

BulkAction::make('archive')
    ->label('Archive Selected')
    ->icon('Archive')
    ->requiresConfirmation()
    ->modalDescription('Are you sure you want to archive all selected records?')
    ->action(function (array $records) {
        foreach ($records as $record) {
            $record->update(['archived_at' => now()]);
        }
    });
```

## With Form

```php
use Laravilt\Actions\BulkAction;
use Laravilt\Forms\Components\Select;

BulkAction::make('change_status')
    ->label('Change Status')
    ->form([
        Select::make('status')
            ->options([
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ])
            ->required(),
    ])
    ->action(function (array $records, array $data) {
        foreach ($records as $record) {
            $record->update(['status' => $data['status']]);
        }
    });
```

## Auto Deselect

```php
use Laravilt\Actions\BulkAction;

BulkAction::make('process')
    ->deselectRecordsAfterCompletion(true) // Default is true
    ->action(function (array $records) {
        // Process records
    });
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `string $name` | Create action |
| `label()` | `string` | Set label |
| `icon()` | `string` | Set icon |
| `color()` | `string` | Set color |
| `action()` | `Closure` | Callback with records array |
| `form()` | `array` | Modal form schema |
| `requiresConfirmation()` | — | Show confirmation |
| `modalHeading()` | `string` | Modal title |
| `modalDescription()` | `string` | Modal message |
| `deselectRecordsAfterCompletion()` | `bool` | Auto-deselect records |
