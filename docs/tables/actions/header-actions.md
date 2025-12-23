---
title: Header Actions
description: Table header actions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: actions
vue_component: TableHeaderActions
---

# Header Actions

Actions in the table header.

## Create Action

```php
<?php

use Laravilt\Actions\CreateAction;

->headerActions([
    CreateAction::make()
        ->url(route('products.create')),
])
```

## Export Action

```php
<?php

use Laravilt\Actions\Action;

->headerActions([
    Action::make('export')
        ->label('Export All')
        ->icon('Download')
        ->action(function () {
            return response()->download(
                $this->exportTable(),
                'products.csv'
            );
        }),
])
```

## Import Action

```php
<?php

use Laravilt\Actions\Action;
use Laravilt\Forms\Components\FileUpload;

->headerActions([
    Action::make('import')
        ->label('Import')
        ->icon('Upload')
        ->form([
            FileUpload::make('file')
                ->acceptedFileTypes(['.csv', '.xlsx'])
                ->required(),
        ])
        ->action(function (array $data) {
            $this->importFile($data['file']);
        }),
])
```

## API Reference

| Method | Description |
|--------|-------------|
| `url()` | Redirect URL |
| `action()` | Action callback |
| `form()` | Action form |
| `icon()` | Button icon |
