---
title: Models
description: Generate plugin models
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: models
---

# Models

Generate Eloquent models for plugins.

## Generate Model

```bash
php artisan laravilt:make blog-manager model Post
```

## Generated Model

```php
<?php

namespace MyCompany\BlogManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
```

## With Relationships

```php
<?php

namespace MyCompany\BlogManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
```

## Model Factory

```bash
php artisan laravilt:make blog-manager factory PostFactory
```

```php
<?php

namespace MyCompany\BlogManager\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MyCompany\BlogManager\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
        ];
    }
}
```
