---
title: Resources
description: Generate plugin resources
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: resources
---

# Resources

Generate Filament resources for plugins.

## Generate Resource

```bash
php artisan laravilt:make blog-manager resource PostResource
```

## Generated Resource

```php
<?php

namespace MyCompany\BlogManager\Resources;

use Laravilt\Panel\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Tables\Table;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Tables\Columns\TextColumn;

class PostResource extends Resource
{
    protected static ?string $model = \MyCompany\BlogManager\Models\Post::class;

    protected static ?string $navigationIcon = 'FileText';

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            TextInput::make('title')
                ->required()
                ->maxLength(255),

            TextInput::make('content')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->searchable()
            ->paginated();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
```

## Register in Plugin

```php
<?php

public function register(Panel $panel): void
{
    $panel->resources([
        Resources\PostResource::class,
        Resources\CategoryResource::class,
    ]);
}
```
