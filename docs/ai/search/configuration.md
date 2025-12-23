---
title: Search Configuration
description: Configure global search
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
concept: search-configuration
---

# Search Configuration

Configure AI-powered global search.

## Panel Configuration

```php
<?php

use Laravilt\Panel\Panel;

Panel::make()
    ->globalSearch()
    ->globalSearchUseAI()
    ->globalSearchDebounce(300)
    ->globalSearchKeyBindings(['ctrl+k', 'cmd+k']);
```

## Register Resources

```php
<?php

use Laravilt\AI\GlobalSearch;
use App\Models\Product;

app(GlobalSearch::class)
    ->registerResource(
        resource: 'products',
        model: Product::class,
        searchable: ['name', 'sku', 'description'],
        label: 'Products',
        icon: 'Package',
        url: '/admin/products/{id}'
    )
    ->limit(5)
    ->useAI(true);
```

## Making Resources Searchable

```php
<?php

namespace App\Laravilt\Admin\Resources\Product;

use Laravilt\Panel\Resources\Resource;

class ProductResource extends Resource
{
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'sku'];
    }
}
```

## With AI Agent

```php
<?php

use Laravilt\Panel\Resources\Resource;
use Laravilt\AI\AIAgent;

class ProductResource extends Resource
{
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'sku'];
    }

    public static function ai(AIAgent $agent): AIAgent
    {
        return $agent
            ->searchable(['name', 'description', 'sku'])
            ->canQuery(true);
    }
}
```

## Custom Result Title

```php
<?php

use Illuminate\Database\Eloquent\Model;

public static function getGlobalSearchResultTitle(Model $record): string
{
    return "{$record->name} ({$record->sku})";
}
```

## Custom Result Details

```php
<?php

use Illuminate\Database\Eloquent\Model;

public static function getGlobalSearchResultDetails(Model $record): array
{
    return [
        'Category' => $record->category?->name,
        'Price' => '$' . number_format($record->price, 2),
    ];
}
```

## API Reference

| Method | Description |
|--------|-------------|
| `registerResource()` | Add searchable resource |
| `limit()` | Max results per resource |
| `useAI()` | Enable AI understanding |
| `search()` | Execute search |
