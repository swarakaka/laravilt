---
title: TrashedFilter
description: Soft delete filter
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: TrashedFilter
vue_component: TableTrashedFilter
---

# TrashedFilter

Filter for soft-deleted records.

## Basic Usage

```php
<?php

use Laravilt\Tables\Filters\TrashedFilter;

TrashedFilter::make();
```

## Filter Options

Three states:
- **Without Trashed**: Active records (default)
- **With Trashed**: All including deleted
- **Only Trashed**: Only deleted records

## Model Requirement

```php
<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
}
```

## API Reference

| Method | Description |
|--------|-------------|
| `make()` | Create filter |
