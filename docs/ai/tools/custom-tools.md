---
title: Custom Tools
description: Build custom AI tools
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
concept: custom-tools
---

# Custom Tools

Build custom tools for AI agents.

## Basic Custom Tool

```php
<?php

use Laravilt\AI\Tools\Tool;
use Illuminate\Support\Facades\Http;

class WeatherTool extends Tool
{
    protected function handle(array $arguments): mixed
    {
        $city = $arguments['city'] ?? 'Unknown';
        $weather = Http::get("https://api.weather.com/{$city}")->json();

        return [
            'city' => $city,
            'temperature' => $weather['temp'],
            'conditions' => $weather['conditions'],
        ];
    }
}

$tool = WeatherTool::make('get_weather')
    ->description('Get current weather for a city')
    ->addParameter('city', 'string', 'The city name', required: true);
```

## Using Closures

```php
<?php

use Laravilt\AI\Tools\Tool;
use App\Models\Product;

$tool = Tool::make('get_product_count')
    ->description('Get total number of products')
    ->handler(fn () => ['count' => Product::count()]);

$tool = Tool::make('get_low_stock')
    ->description('Get products with low stock')
    ->addParameter('threshold', 'integer', 'Stock threshold', true)
    ->handler(fn ($args) => Product::where('stock', '<', $args['threshold'])
        ->get(['id', 'name', 'stock'])
        ->toArray()
    );
```

## Parameter Types

```php
<?php

use Laravilt\AI\Tools\Tool;

$tool->addParameter('name', 'string', 'Product name', required: true);
$tool->addParameter('price', 'number', 'Product price');
$tool->addParameter('quantity', 'integer', 'Stock quantity');
$tool->addParameter('active', 'boolean', 'Is product active');
$tool->addParameter('tags', 'array', 'Product tags');
```

## JSON Schema

```php
<?php

use Laravilt\AI\Tools\Tool;

$tool = Tool::make('create_order')
    ->description('Create a new order')
    ->schema([
        'type' => 'object',
        'properties' => [
            'customer_id' => ['type' => 'integer'],
            'items' => [
                'type' => 'array',
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'product_id' => ['type' => 'integer'],
                        'quantity' => ['type' => 'integer'],
                    ],
                ],
            ],
        ],
        'required' => ['customer_id', 'items'],
    ]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `description()` | Tool description |
| `addParameter()` | Add parameter |
| `schema()` | Set JSON schema |
| `handler()` | Set handler function |
| `execute()` | Execute the tool |
