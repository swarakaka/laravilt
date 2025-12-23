---
title: Resource Table
description: Complete table configuration for your resource
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Resource Table

Complete table configuration for the Product resource.

## Table Configuration

Complete `Table/ProductTable.php`:

```php
namespace App\Laravilt\Admin\Resources\Product\Table;

use Laravilt\Tables\Actions\BulkActionGroup;
use Laravilt\Tables\Actions\DeleteAction;
use Laravilt\Tables\Actions\DeleteBulkAction;
use Laravilt\Tables\Actions\EditAction;
use Laravilt\Tables\Actions\ViewAction;
use Laravilt\Tables\Columns\ImageColumn;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\ToggleColumn;
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Filters\TernaryFilter;
use Laravilt\Tables\Table;

class ProductTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->circular()
                    ->defaultImageUrl('/images/placeholder.png'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->slug),

                TextColumn::make('category.name')
                    ->badge()
                    ->sortable(),

                TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('stock')
                    ->badge()
                    ->color(fn (int $state): string => match(true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),

                ToggleColumn::make('is_active')
                    ->label('Active'),

                ToggleColumn::make('is_featured')
                    ->label('Featured'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active Status'),

                TernaryFilter::make('is_featured')
                    ->label('Featured'),

                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->preload()
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

## Column Types

Common column types used:

| Column | Description |
|--------|-------------|
| `TextColumn` | Text with search, sort, format |
| `ImageColumn` | Thumbnails with fallback |
| `ToggleColumn` | Inline boolean toggle |
| `BadgeColumn` | Colored status badges |
| `IconColumn` | Icon-based display |

## Filter Types

Common filter types:

| Filter | Description |
|--------|-------------|
| `SelectFilter` | Dropdown selection |
| `TernaryFilter` | Yes/No/All toggle |
| `Filter` | Custom filter logic |

## Actions

Available table actions:

```php
->recordActions([
    ViewAction::make()
        ->slideOver(),  // Opens in slide-over

    EditAction::make()
        ->modal(),      // Opens in modal

    DeleteAction::make()
        ->requiresConfirmation(),
])
```

## Next Steps

- [First Resource](first-resource) - Resource overview
- [Tables](../tables/introduction) - All table features
- [Actions](../actions/introduction) - Custom actions
