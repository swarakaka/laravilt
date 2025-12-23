---
title: ImageColumn
description: Image display column
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: ImageColumn
vue_component: TableImageCell
---

# ImageColumn

Display images with various layouts.

## Basic Usage

```php
<?php

use Laravilt\Tables\Columns\ImageColumn;

ImageColumn::make('avatar')
    ->circular()
    ->size(40);
```

## Shapes

```php
<?php

use Laravilt\Tables\Columns\ImageColumn;

ImageColumn::make('photo')->square();
ImageColumn::make('avatar')->circular();
```

## Stacked Images

```php
<?php

use Laravilt\Tables\Columns\ImageColumn;

ImageColumn::make('team_members')
    ->stacked()
    ->ring(2)
    ->limit(3)
    ->limitedRemainingText();
```

## Fallback

```php
<?php

use Laravilt\Tables\Columns\ImageColumn;

ImageColumn::make('avatar')
    ->defaultImageUrl('/default-avatar.png')
    ->checkFileExistence();
```

## API Reference

| Method | Description |
|--------|-------------|
| `circular()` | Round shape |
| `square()` | Square shape |
| `stacked()` | Stack multiple |
| `limit()` | Max images |
| `size()` | Width/height |
| `ring()` | Border ring |
| `defaultImageUrl()` | Fallback |
