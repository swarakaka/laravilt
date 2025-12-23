---
title: Registration
description: Plugin registration methods
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: registration
---

# Registration

Register plugins with your application.

## Auto-Discovery

Plugins auto-discovered via composer.json:

```json
{
    "name": "mycompany/blog-manager",
    "extra": {
        "laravel": {
            "providers": [
                "MyCompany\\BlogManager\\BlogManagerPlugin"
            ]
        }
    }
}
```

## Manual Registration

In panel provider:

```php
<?php

namespace App\Providers\Laravilt;

use Laravilt\Panel\PanelProvider;
use Filament\Panel;
use MyCompany\BlogManager\BlogManagerPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugins([
                BlogManagerPlugin::make(),
            ]);
    }
}
```

## Fluent Registration

```php
<?php

use MyCompany\BlogManager\BlogManagerPlugin;

$panel->plugins([
    BlogManagerPlugin::make()
        ->navigationGroup('Content')
        ->navigationSort(5)
        ->postsPerPage(15),
]);
```

## Conditional Registration

```php
<?php

$panel->plugins(array_filter([
    BlogManagerPlugin::make(),

    config('app.enable_comments')
        ? CommentsPlugin::make()
        : null,
]));
```

## Multiple Panels

```php
<?php

// Admin panel
$adminPanel->plugins([
    BlogManagerPlugin::make()->full(),
]);

// Public panel
$publicPanel->plugins([
    BlogManagerPlugin::make()->readonly(),
]);
```
