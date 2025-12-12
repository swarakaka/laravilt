# Tables Introduction

The Tables package provides a powerful, feature-rich data table system for displaying and managing database records with Vue 3 frontend rendering.

## Overview

Laravilt Tables offers:

- **9 Column Types** - Text, Icon, Image, Color, Toggle, Select, TextInput, Checkbox
- **5 Filter Types** - Select, Ternary, Trashed, Base, Custom
- **Advanced Features** - Sorting, searching, pagination, bulk actions
- **Multiple Views** - Table view and Card/Grid view
- **Inline Editing** - Toggle, Select, TextInput, Checkbox columns
- **API Resources** - Auto-generated REST API endpoints
- **Real-time Updates** - Polling and live updates
- **Responsive Design** - Mobile-friendly layouts

---

## Basic Usage

### Defining a Table

```php
use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\ImageColumn;
use Laravilt\Tables\Columns\ToggleColumn;
use Laravilt\Tables\Filters\SelectFilter;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            ImageColumn::make('avatar')
                ->circular(),

            TextColumn::make('name')
                ->searchable()
                ->sortable(),

            TextColumn::make('email')
                ->searchable()
                ->copyable(),

            TextColumn::make('role')
                ->badge()
                ->color(fn (string $state): string => match($state) {
                    'admin' => 'danger',
                    'editor' => 'warning',
                    default => 'secondary',
                }),

            ToggleColumn::make('is_active')
                ->label('Active'),

            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            SelectFilter::make('role')
                ->options([
                    'admin' => 'Administrator',
                    'editor' => 'Editor',
                    'user' => 'User',
                ]),
        ])
        ->actions([
            \Laravilt\Actions\ViewAction::make(),
            \Laravilt\Actions\EditAction::make(),
            \Laravilt\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            \Laravilt\Actions\DeleteBulkAction::make(),
        ])
        ->defaultSort('created_at', 'desc')
        ->searchable()
        ->paginated();
}
```

---

## Table Configuration

### Basic Settings

```php
$table
    ->query(fn() => User::query())  // Base query
    ->columns([...])                // Column definitions
    ->filters([...])                // Filter definitions
    ->searchable()                  // Enable global search
    ->searchPlaceholder('Search users...')
    ->paginated()                   // Enable pagination
    ->perPage(25)                   // Items per page
    ->defaultSort('name', 'asc');   // Default sorting
```

### Display Options

```php
$table
    ->striped()                     // Striped row backgrounds
    ->hoverable()                   // Highlight on hover
    ->fixedActions()                // Fixed action column
    ->reorderable('sort_order');    // Drag to reorder
```

### Views

```php
// Table view only (default)
$table->columns([...]);

// Grid/Card view
$table
    ->columns([...])
    ->card(
        Card::product(
            imageField: 'thumbnail',
            titleField: 'name',
            priceField: 'price',
            descriptionField: 'description',
            badgeField: 'status'
        )
    )
    ->cardsPerRow(3);

// Grid only (hide table view)
$table->gridOnly();
```

---

## Column Types

### Text Column

```php
TextColumn::make('name')
    ->searchable()
    ->sortable()
    ->limit(50)                     // Character limit
    ->badge()                       // Display as badge
    ->copyable()                    // Copy to clipboard
    ->color('primary')              // Color
    ->icon('User')                  // Icon
    ->formatStateUsing(fn ($state) => strtoupper($state));
```

### Image Column

```php
ImageColumn::make('avatar')
    ->circular()                    // Circular image
    ->imageSize('lg')               // sm, md, lg
    ->stacked()                     // Stack multiple images
    ->limit(3);                     // Show max 3 images
```

### Toggle Column

```php
ToggleColumn::make('is_active')
    ->label('Active')
    ->afterStateUpdated(function ($record, $state) {
        // Handle toggle
    });
```

See [Columns](columns.md) for all column types.

---

## Filters

### Select Filter

```php
SelectFilter::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ])
    ->multiple();
```

### Ternary Filter

```php
TernaryFilter::make('is_featured')
    ->label('Featured')
    ->trueLabel('Featured only')
    ->falseLabel('Not featured')
    ->placeholderLabel('All');
```

### Trashed Filter

```php
TrashedFilter::make();  // For soft-deleted models
```

See [Filters](filters.md) for all filter types.

---

## Actions

### Row Actions

```php
->actions([
    \Laravilt\Actions\ViewAction::make(),
    \Laravilt\Actions\EditAction::make(),
    \Laravilt\Actions\DeleteAction::make(),

    \Laravilt\Actions\Action::make('publish')
        ->icon('Send')
        ->action(fn ($record) => $record->publish()),
])
```

### Bulk Actions

```php
->bulkActions([
    \Laravilt\Actions\DeleteBulkAction::make(),

    \Laravilt\Actions\BulkAction::make('activate')
        ->label('Activate Selected')
        ->icon('CheckCircle')
        ->action(function ($records) {
            $records->each->activate();
        }),
])
```

See [Actions](actions.md) for detailed action configuration.

---

## Searching & Sorting

### Global Search

```php
TextColumn::make('name')
    ->searchable();  // Included in search

TextColumn::make('email')
    ->searchable();  // Included in search
```

### Column Sorting

```php
TextColumn::make('created_at')
    ->sortable()
    ->dateTime();
```

### Default Sort

```php
$table->defaultSort('created_at', 'desc');
```

---

## Pagination

### Basic Pagination

```php
$table
    ->paginated()
    ->perPage(25)
    ->paginationPageOptions([10, 25, 50, 100]);
```

### Infinite Scroll

```php
$table
    ->infiniteScroll()
    ->perPage(20);
```

---

## Card/Grid View

### Product Cards

```php
use Laravilt\Tables\Card;

$table
    ->card(
        Card::product(
            imageField: 'image',
            titleField: 'name',
            priceField: 'price',
            descriptionField: 'short_description',
            badgeField: 'stock_status'
        )
    )
    ->cardsPerRow(4);
```

### Simple Cards

```php
$table
    ->card(
        Card::simple(
            titleField: 'name',
            descriptionField: 'description'
        )
    )
    ->cardsPerRow(3);
```

### Media Cards

```php
$table
    ->card(
        Card::media(
            imageField: 'cover_image',
            titleField: 'title',
            descriptionField: 'excerpt'
        )
    )
    ->cardsPerRow(2);
```

---

## Empty State

### Custom Empty State

```php
$table
    ->emptyStateHeading('No users found')
    ->emptyStateDescription('Create your first user to get started')
    ->emptyStateIcon('Users');
```

---

## Polling

Auto-refresh table data at intervals:

```php
$table->poll('5s');   // Every 5 seconds
$table->poll('30s');  // Every 30 seconds
$table->poll('1m');   // Every 1 minute
```

---

## API Resources

Enable REST API for your table:

```php
use Laravilt\Tables\ApiResource;
use Laravilt\Tables\ApiColumn;

$table
    ->api(true)
    ->apiResource(
        ApiResource::make()
            ->endpoint('/api/users')
            ->list()
            ->show()
            ->create()
            ->update()
            ->delete()
            ->columns([
                ApiColumn::make('id')->type('integer')->readable(),
                ApiColumn::make('name')->type('string')->searchable()->sortable(),
                ApiColumn::make('email')->type('string')->searchable(),
            ])
    );
```

---

## Inline Editing

### Toggle Column

```php
ToggleColumn::make('is_active')
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['is_active' => $state]);
    });
```

### Select Column

```php
SelectColumn::make('status')
    ->options([
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ])
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['status' => $state]);
    });
```

### Text Input Column

```php
TextInputColumn::make('notes')
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['notes' => $state]);
    });
```

---

## Column Visibility

Allow users to toggle column visibility:

```php
TextColumn::make('created_at')
    ->toggleable(isToggledHiddenByDefault: true);

TextColumn::make('updated_at')
    ->toggleable(isToggledHiddenByDefault: true);

// Always visible (not toggleable)
TextColumn::make('name')
    ->toggleable(false);
```

---

## Reordering

Enable drag-to-reorder:

```php
$table
    ->reorderable('sort_order')  // Column to store sort order
    ->defaultSort('sort_order', 'asc');
```

---

## Complete Example

```php
<?php

namespace App\Laravilt\Admin\Resources\Product\Table;

use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\ImageColumn;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\ToggleColumn;
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Filters\TernaryFilter;
use Laravilt\Tables\Card;

class ProductTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->circular(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->sku),

                TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'secondary',
                        'active' => 'success',
                        'inactive' => 'warning',
                        'archived' => 'danger',
                        default => 'secondary',
                    }),

                ToggleColumn::make('is_active')
                    ->label('Active'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'archived' => 'Archived',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                \Laravilt\Actions\ViewAction::make(),
                \Laravilt\Actions\EditAction::make(),
                \Laravilt\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Laravilt\Actions\DeleteBulkAction::make(),
            ])
            ->card(
                Card::product(
                    imageField: 'thumbnail',
                    titleField: 'name',
                    priceField: 'price',
                    descriptionField: 'description',
                    badgeField: 'status'
                )
            )
            ->cardsPerRow(3)
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->paginated()
            ->perPage(12)
            ->paginationPageOptions([12, 25, 50, 100])
            ->striped()
            ->hoverable();
    }
}
```

---

## Performance Tips

### 1. Eager Load Relationships

```php
$table->query(fn() => Product::with('category', 'brand'));
```

### 2. Limit Searchable Columns

Only mark frequently searched columns as searchable.

### 3. Use Pagination

```php
$table->paginated()->perPage(25);
```

### 4. Index Sortable Columns

Add database indexes to sortable columns.

### 5. Optimize Images

Use appropriate image sizes and lazy loading.

---

## Next Steps

- [Columns](columns.md) - All column types and options
- [Filters](filters.md) - Filter configuration
- [Actions](actions.md) - Row and bulk actions
- [Table API](api.md) - REST API generation
