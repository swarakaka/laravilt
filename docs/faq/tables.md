---
title: Tables FAQ
description: Table columns, filters, and actions questions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: faq
---

# Tables FAQ

Common questions about tables, columns, and filters.

## Creating Tables

### How do I create a table?

```php
<?php

use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;

Table::make()
    ->columns([
        TextColumn::make('name'),
        TextColumn::make('email'),
    ]);
```

## Columns

### How do I make a column searchable?

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')->searchable();
```

### How do I make a column sortable?

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('created_at')->sortable();
```

### How do I format a column?

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('price')
    ->money('USD')
    ->sortable();

TextColumn::make('created_at')
    ->dateTime('M j, Y');
```

## Filters

### How do I add filters?

```php
<?php

use Laravilt\Tables\Filters\SelectFilter;

$table->filters([
    SelectFilter::make('status')
        ->options([
            'active' => 'Active',
            'inactive' => 'Inactive',
        ]),
]);
```

### How do I add a date filter?

```php
<?php

use Laravilt\Tables\Filters\DateFilter;

DateFilter::make('created_at')
    ->label('Created Date');
```

## Actions

### How do I add row actions?

```php
<?php

use Laravilt\Tables\Actions\EditAction;
use Laravilt\Tables\Actions\DeleteAction;

$table->actions([
    EditAction::make(),
    DeleteAction::make(),
]);
```

### How do I add bulk actions?

```php
<?php

use Laravilt\Tables\Actions\DeleteBulkAction;

$table->bulkActions([
    DeleteBulkAction::make(),
]);
```

### How do I add confirmation to actions?

```php
<?php

use Laravilt\Tables\Actions\Action;

Action::make('delete')
    ->requiresConfirmation()
    ->modalHeading('Delete Record')
    ->action(fn ($record) => $record->delete());
```

## Related

- [Tables Documentation](../tables/introduction)
- [Filters](../tables/filters/introduction)

