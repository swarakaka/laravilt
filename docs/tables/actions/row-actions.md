---
title: Row Actions
description: Single record actions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: actions
vue_component: TableRowActions
---

# Row Actions

Actions for individual table records.

## Built-in Actions

```php
<?php

use Laravilt\Actions\ViewAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;

->actions([
    ViewAction::make(),
    EditAction::make(),
    DeleteAction::make(),
])
```

## Custom Action

```php
<?php

use Laravilt\Actions\Action;
use Laravilt\Notifications\Notification;

->actions([
    Action::make('publish')
        ->label('Publish')
        ->icon('Send')
        ->color('success')
        ->action(function ($record) {
            $record->update(['status' => 'published']);

            Notification::make()
                ->title('Published!')
                ->success()
                ->send();
        }),
])
```

## With Confirmation

```php
<?php

use Laravilt\Actions\Action;

Action::make('archive')
    ->icon('Archive')
    ->requiresConfirmation()
    ->modalHeading('Archive Post')
    ->action(fn ($record) => $record->archive());
```

## Action Group

```php
<?php

use Laravilt\Actions\ActionGroup;

ActionGroup::make([
    \Laravilt\Actions\ViewAction::make(),
    \Laravilt\Actions\EditAction::make(),
    \Laravilt\Actions\DeleteAction::make(),
])->dropdown();
```

## API Reference

| Method | Description |
|--------|-------------|
| `action()` | Action callback |
| `requiresConfirmation()` | Show modal |
| `icon()` | Action icon |
| `color()` | Button color |
| `visible()` | Visibility condition |
