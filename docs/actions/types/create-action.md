---
title: CreateAction
description: Create new records via modal or navigation
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: CreateAction
---

# CreateAction

Create new records via a modal form or by navigating to a create page.

## Basic Usage

```php
use Laravilt\Actions\CreateAction;

CreateAction::make();
```

## Default Configuration

- **Icon**: Plus
- **Color**: primary
- Auto-detects context (modal vs navigation)

## Modal Creation

```php
use Laravilt\Actions\CreateAction;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Textarea;
use Laravilt\Forms\Components\Select;
use App\Models\Post;

CreateAction::make()
    ->model(Post::class)
    ->form([
        TextInput::make('title')->required(),
        Textarea::make('content'),
        Select::make('status')
            ->options([
                'draft' => 'Draft',
                'published' => 'Published',
            ]),
    ]);
```

## Custom Creation Logic

```php
use Laravilt\Actions\CreateAction;
use App\Models\Post;

CreateAction::make()
    ->model(Post::class)
    ->form([...])
    ->using(function (array $data) {
        $post = Post::create($data);
        $post->author()->associate(auth()->user());
        $post->save();
        return $post;
    });
```

## Custom Modal Settings

```php
use Laravilt\Actions\CreateAction;

CreateAction::make()
    ->modalHeading('Create New Post')
    ->modalWidth('2xl')
    ->modalSubmitActionLabel('Create Post');
```

## Slide Over Modal

```php
use Laravilt\Actions\CreateAction;

CreateAction::make()
    ->form([...])
    ->slideOver();
```

## Success Redirect

```php
use Laravilt\Actions\CreateAction;

CreateAction::make()
    ->successRedirectUrl(fn ($record) => route('posts.edit', $record));
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `?string $name` | Create action |
| `model()` | `string` | Set model class |
| `form()` | `array` | Form schema |
| `using()` | `Closure` | Custom creation logic |
| `modalHeading()` | `string` | Modal title |
| `modalWidth()` | `string` | Modal width |
| `slideOver()` | — | Use slide-over |
| `successRedirectUrl()` | `string\|Closure` | Redirect after create |
