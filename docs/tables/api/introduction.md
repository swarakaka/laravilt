---
title: Table API
description: REST API generation
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: api
---

# Table API

Auto-generated REST API for tables.

## Enable API

```php
<?php

use Laravilt\Tables\Table;
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
    );
```

## API Columns

```php
<?php

use Laravilt\Tables\ApiResource;
use Laravilt\Tables\ApiColumn;

ApiResource::make()
    ->columns([
        ApiColumn::make('id')->type('integer')->readable(),
        ApiColumn::make('name')->type('string')->searchable()->sortable(),
        ApiColumn::make('email')->type('string')->searchable(),
        ApiColumn::make('created_at')->type('datetime')->readable(),
    ]);
```

## API Response

```json
{
  "data": [...],
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 100
  }
}
```

## API Methods

| Method | Endpoint |
|--------|----------|
| `list()` | GET /api/users |
| `show()` | GET /api/users/{id} |
| `create()` | POST /api/users |
| `update()` | PUT /api/users/{id} |
| `delete()` | DELETE /api/users/{id} |
