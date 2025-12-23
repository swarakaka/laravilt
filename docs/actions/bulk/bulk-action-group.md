---
title: BulkActionGroup
description: Group multiple bulk actions in a dropdown
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: BulkActionGroup
---

# BulkActionGroup

Group multiple bulk actions into a dropdown menu for organized table actions.

## Basic Usage

```php
use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\BulkAction;

BulkActionGroup::make([
    BulkAction::make('approve')
        ->label('Approve')
        ->action(fn ($records) => /* ... */),
    BulkAction::make('reject')
        ->label('Reject')
        ->action(fn ($records) => /* ... */),
    DeleteBulkAction::make(),
]);
```

## Custom Label

```php
use Laravilt\Actions\BulkActionGroup;

BulkActionGroup::make([...])
    ->label('Bulk Actions')
    ->icon('MoreHorizontal')
    ->color('gray');
```

## In Table Resource

```php
use Laravilt\Actions\BulkActionGroup;
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\BulkAction;
use Laravilt\Tables\Table;
use Laravilt\Resources\Resource;

class PostResource extends Resource
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([...])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('publish')
                        ->label('Publish')
                        ->icon('Globe')
                        ->action(fn ($records) => /* ... */),
                    BulkAction::make('unpublish')
                        ->label('Unpublish')
                        ->icon('EyeOff')
                        ->action(fn ($records) => /* ... */),
                ]),
                DeleteBulkAction::make(),
            ]);
    }
}
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `array $actions` | Create group with actions |
| `label()` | `string` | Group label |
| `icon()` | `string` | Group icon |
| `color()` | `string` | Group color |
