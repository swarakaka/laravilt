---
title: Actions Introduction
description: Interactive UI elements for triggering operations
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
---

# Actions Introduction

Interactive UI elements for triggering operations in your Laravilt applications.

## Overview

- **Regular Actions** - Single-record or global operations
- **Bulk Actions** - Operations on multiple records
- **Action Groups** - Organized action collections
- **Modal Forms** - Interactive forms in modal dialogs
- **Export/Import** - Excel and CSV support

## Basic Usage

```php
use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

Action::make('publish')
    ->label('Publish')
    ->icon('Send')
    ->color('success')
    ->action(function ($record) {
        $record->update(['status' => 'published']);

        Notification::make()
            ->title('Post published')
            ->success()
            ->send();
    });
```

## Built-in Actions

```php
use Laravilt\Actions\ViewAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\CreateAction;
use Laravilt\Actions\RestoreAction;
use Laravilt\Actions\ForceDeleteAction;
use Laravilt\Actions\ReplicateAction;
use Laravilt\Actions\ExportAction;
use Laravilt\Actions\ImportAction;

ViewAction::make();
EditAction::make();
DeleteAction::make();
CreateAction::make();
RestoreAction::make();
ForceDeleteAction::make();
ReplicateAction::make();
ExportAction::make()->exporter(UserExporter::class);
ImportAction::make()->importer(UserImporter::class);
```

## Built-in Bulk Actions

```php
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\RestoreBulkAction;
use Laravilt\Actions\ForceDeleteBulkAction;

DeleteBulkAction::make();
RestoreBulkAction::make();
ForceDeleteBulkAction::make();
```

## Next Steps

- [Styling](styling) - Colors, icons, variants
- [Confirmation](confirmation) - Modals and confirmations
- [Forms](forms) - Modal forms
- [Groups](groups) - Action groups
- [Authorization](authorization) - Permissions and visibility

## Component Reference

### Action Types
- [ViewAction](types/view-action)
- [EditAction](types/edit-action)
- [DeleteAction](types/delete-action)
- [CreateAction](types/create-action)
- [RestoreAction](types/restore-action)
- [ForceDeleteAction](types/force-delete-action)
- [ReplicateAction](types/replicate-action)
- [ExportAction](types/export-action)
- [ImportAction](types/import-action)
- [CustomAction](types/custom-action)

### Bulk Actions
- [BulkAction](bulk/bulk-action)
- [BulkActionGroup](bulk/bulk-action-group)
- [DeleteBulkAction](bulk/delete-bulk-action)
- [RestoreBulkAction](bulk/restore-bulk-action)
- [ForceDeleteBulkAction](bulk/force-delete-bulk-action)
