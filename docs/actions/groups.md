---
title: Action Groups
description: Organize actions into groups
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
---

# Action Groups

Organize multiple actions into dropdown groups.

## Bulk Action Groups

```php
use Laravilt\Actions\BulkAction;
use Laravilt\Actions\BulkActionGroup;

BulkActionGroup::make([
    BulkAction::make('publish')->action(...),
    BulkAction::make('draft')->action(...),
    BulkAction::make('archive')->action(...),
])
->label('Change Status')
->icon('Edit');
```

## In Table Actions

```php
use Laravilt\Actions\ViewAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\ActionGroup;

// In Table configuration
->recordActions([
    ViewAction::make(),
    EditAction::make(),
    ActionGroup::make([
        // More actions in dropdown
    ])->label('More'),
    DeleteAction::make(),
])
```

## Next Steps

- [Styling](styling) - Colors and icons
- [Forms](forms) - Modal forms
- [Authorization](authorization) - Permissions
