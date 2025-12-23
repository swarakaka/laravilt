---
title: Card Types
description: Card configurations for grid view
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: display
vue_component: TableCard
---

# Card Types

Card type configurations for grid view.

## Product Card

```php
<?php

use Laravilt\Tables\Card;

Card::product(
    imageField: 'image',
    titleField: 'name',
    priceField: 'price',
    descriptionField: 'short_description',
    badgeField: 'stock_status'
);
```

## Simple Card

```php
<?php

use Laravilt\Tables\Card;

Card::simple(
    titleField: 'name',
    descriptionField: 'description'
);
```

## Media Card

```php
<?php

use Laravilt\Tables\Card;

Card::media(
    imageField: 'cover_image',
    titleField: 'title',
    descriptionField: 'excerpt'
);
```

## Profile Card

```php
<?php

use Laravilt\Tables\Card;

Card::profile(
    avatarField: 'avatar',
    nameField: 'name',
    subtitleField: 'role'
);
```

## API Reference

| Card Type | Fields |
|-----------|--------|
| `product()` | image, title, price, description, badge |
| `simple()` | title, description |
| `media()` | image, title, description |
| `profile()` | avatar, name, subtitle |
