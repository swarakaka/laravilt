---
title: Custom Action
description: Create custom actions with modals, forms, and callbacks
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: Action
---

# Custom Action

Create custom actions with modals, forms, and callbacks.

## Basic Usage

```php
use Laravilt\Actions\Action;

Action::make('approve')
    ->label('Approve')
    ->icon('CheckCircle')
    ->color('success')
    ->action(function ($record) {
        $record->update(['status' => 'approved']);
    });
```

## With Confirmation

```php
use Laravilt\Actions\Action;

Action::make('archive')
    ->label('Archive')
    ->icon('Archive')
    ->requiresConfirmation()
    ->modalHeading('Archive Record')
    ->modalDescription('Are you sure you want to archive this record?')
    ->action(function ($record) {
        $record->update(['archived_at' => now()]);
    });
```

## With Modal Form

```php
use Laravilt\Actions\Action;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\Textarea;

Action::make('change_status')
    ->label('Change Status')
    ->icon('RefreshCw')
    ->form([
        Select::make('status')
            ->options([
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ])
            ->required(),
        Textarea::make('notes')
            ->label('Notes'),
    ])
    ->action(function ($record, array $data) {
        $record->update([
            'status' => $data['status'],
            'notes' => $data['notes'],
        ]);
    });
```

## View-Only Modal (Infolist)

```php
use Laravilt\Actions\Action;
use Laravilt\Infolists\Entries\TextEntry;

Action::make('preview')
    ->modalInfolistSchema([
        TextEntry::make('title'),
        TextEntry::make('content')->html(),
        TextEntry::make('created_at')->dateTime(),
    ])
    ->isViewOnly();
```

## URL Action

```php
use Laravilt\Actions\Action;

Action::make('view_report')
    ->label('View Report')
    ->icon('ExternalLink')
    ->url(fn ($record) => route('reports.show', $record))
    ->openUrlInNewTab();
```

## Button Variants

```php
use Laravilt\Actions\Action;

// Standard button (default)
Action::make('submit')->button();

// Icon-only button
Action::make('delete')->icon('Trash2')->iconButton();

// Text link
Action::make('learn_more')->link();

// Outlined button
Action::make('cancel')->outlined();
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `string $name` | Create action |
| `label()` | `string` | Set label |
| `icon()` | `string` | Set icon |
| `color()` | `string` | Set color |
| `action()` | `Closure` | Backend callback |
| `form()` | `array` | Modal form schema |
| `requiresConfirmation()` | — | Show confirmation |
| `modalHeading()` | `string` | Modal title |
| `modalWidth()` | `string` | Modal width |
| `slideOver()` | — | Use slide-over |
| `url()` | `string\|Closure` | Navigate to URL |
| `visible()` | `bool\|Closure` | Show condition |
| `can()` | `string` | Spatie permission |
