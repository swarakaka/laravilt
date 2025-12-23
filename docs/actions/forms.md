---
title: Action Forms
description: Modal forms for actions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
---

# Action Forms

Add interactive forms to action modals.

## Form Input

```php
use Laravilt\Actions\Action;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\Textarea;

Action::make('changeStatus')
    ->modalHeading('Change Status')
    ->schema([
        Select::make('status')
            ->label('New Status')
            ->options([
                'draft' => 'Draft',
                'published' => 'Published',
                'archived' => 'Archived',
            ])
            ->required(),

        Textarea::make('reason')
            ->label('Reason')
            ->rows(3),
    ])
    ->action(function ($record, array $data) {
        $record->update([
            'status' => $data['status'],
            'reason' => $data['reason'],
        ]);
    });
```

## View-Only Modal (Infolist)

```php
use Laravilt\Actions\Action;
use Laravilt\Infolists\Entries\TextEntry;

Action::make('viewDetails')
    ->modalHeading('User Details')
    ->schema([
        TextEntry::make('name'),
        TextEntry::make('email'),
        TextEntry::make('created_at')->dateTime(),
    ])
    ->isViewOnly();     // No submit button
```

## With Form Data

```php
use Laravilt\Actions\Action;
use Laravilt\Forms\Components\TextInput;

Action::make('updatePrice')
    ->schema([
        TextInput::make('price')->numeric()->required(),
    ])
    ->action(function ($record, array $data) {
        $record->update(['price' => $data['price']]);
    });
```

## Next Steps

- [Confirmation](confirmation) - Confirmation modals
- [Groups](groups) - Action groups
- [Authorization](authorization) - Permissions
