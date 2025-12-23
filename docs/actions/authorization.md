---
title: Action Authorization
description: Permissions and visibility control
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
---

# Action Authorization

Control who can see and execute actions.

## Can Method

```php
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;

EditAction::make()
    ->can(fn ($record) => auth()->user()->can('update', $record));

DeleteAction::make()
    ->can(fn ($record) => auth()->user()->can('delete', $record));
```

## Authorize Using Policy

```php
use Laravilt\Actions\Action;

Action::make('publish')
    ->authorize('publish', $record)
    ->action(fn ($record) => $record->publish());
```

## Visibility Control

```php
use Laravilt\Actions\Action;

Action::make('restore')
    ->visible(fn ($record) => $record->trashed());

Action::make('delete')
    ->hidden(fn ($record) => $record->trashed());
```

## Soft Delete Visibility

Built-in actions automatically handle soft-delete visibility:

```php
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\RestoreAction;
use Laravilt\Actions\ForceDeleteAction;

DeleteAction::make();       // Hidden when trashed
EditAction::make();         // Hidden when trashed
RestoreAction::make();      // Visible only when trashed
ForceDeleteAction::make();  // Visible only when trashed
```

| Action | Visible When | Hidden When |
|--------|--------------|-------------|
| `DeleteAction` | Record is not trashed | Record is trashed |
| `RestoreAction` | Record is trashed | Record is not trashed |
| `ForceDeleteAction` | Record is trashed | Record is not trashed |

## Next Steps

- [Styling](styling) - Colors and icons
- [Confirmation](confirmation) - Modals
- [Introduction](introduction) - Overview
