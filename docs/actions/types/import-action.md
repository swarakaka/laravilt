---
title: ImportAction
description: Import records from Excel or CSV files
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: ImportAction
---

# ImportAction

Import records from Excel or CSV files using Laravel Excel.

## Basic Usage

```php
use Laravilt\Actions\ImportAction;

ImportAction::make();
```

## Default Configuration

- **Icon**: Upload
- **Color**: gray
- **Requires Confirmation**: Yes (shows file upload modal)
- Integrates with Laravel Excel (Maatwebsite)

## Custom Importer Class

```php
use Laravilt\Actions\ImportAction;
use App\Imports\ProductImporter;

ImportAction::make()
    ->importer(ProductImporter::class);
```

## Import XLSX

```php
use Laravilt\Actions\ImportAction;

ImportAction::make()
    ->xlsx();
```

## Import CSV

```php
use Laravilt\Actions\ImportAction;

ImportAction::make()
    ->csv();
```

## Accepted File Types

```php
use Laravilt\Actions\ImportAction;

ImportAction::make()
    ->acceptedFileTypes([
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv',
    ]);
```

## Before Import Callback

```php
use Laravilt\Actions\ImportAction;
use Illuminate\Support\Facades\Log;

ImportAction::make()
    ->beforeImport(function ($file) {
        Log::info('Starting import: ' . $file->getClientOriginalName());
    });
```

## After Import Callback

```php
use Laravilt\Actions\ImportAction;
use Laravilt\Notifications\Notification;

ImportAction::make()
    ->afterImport(function ($import) {
        Notification::make()
            ->title('Import completed')
            ->success()
            ->send();
    });
```

## Queue Large Imports

```php
use Laravilt\Actions\ImportAction;

ImportAction::make()
    ->queue()
    ->chunkSize(1000)
    ->disk('imports');
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `?string $name` | Create action |
| `importer()` | `string` | Importer class |
| `xlsx()` | — | Import XLSX files |
| `csv()` | — | Import CSV files |
| `acceptedFileTypes()` | `array` | Accepted MIME types |
| `beforeImport()` | `Closure` | Before import hook |
| `afterImport()` | `Closure` | After import hook |
| `queue()` | — | Queue import |
| `chunkSize()` | `int` | Chunk size |
