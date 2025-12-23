---
title: ExportAction
description: Export records to various file formats
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: actions
component: ExportAction
---

# ExportAction

Export table records to Excel, CSV using Laravel Excel.

## Basic Usage

```php
use Laravilt\Actions\ExportAction;

ExportAction::make();
```

## Default Configuration

- **Icon**: Download
- **Color**: gray
- Integrates with Laravel Excel (Maatwebsite)

## Export as XLSX

```php
use Laravilt\Actions\ExportAction;

ExportAction::make()
    ->xlsx()
    ->fileName('products-export');
```

## Export as CSV

```php
use Laravilt\Actions\ExportAction;

ExportAction::make()
    ->csv()
    ->fileName('orders');
```

## Custom Exporter Class

```php
use Laravilt\Actions\ExportAction;
use App\Exports\ProductExporter;

ExportAction::make()
    ->exporter(ProductExporter::class)
    ->fileName('products');
```

## Specify Columns

```php
use Laravilt\Actions\ExportAction;

ExportAction::make()
    ->columns(['id', 'name', 'email', 'created_at'])
    ->headings(['ID', 'Full Name', 'Email Address', 'Registration Date']);
```

## Modify Query

```php
use Laravilt\Actions\ExportAction;

ExportAction::make()
    ->modifyQueryUsing(function ($query) {
        return $query->where('is_active', true)
            ->orderBy('created_at', 'desc');
    });
```

## Queue Large Exports

```php
use Laravilt\Actions\ExportAction;

ExportAction::make()
    ->queue()
    ->disk('exports')
    ->filePath('exports/products');
```

## API Reference

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `?string $name` | Create action |
| `exporter()` | `string` | Exporter class |
| `fileName()` | `string` | Output filename |
| `xlsx()` | — | Export as XLSX |
| `csv()` | — | Export as CSV |
| `columns()` | `array` | Columns to export |
| `headings()` | `array` | Column headings |
| `modifyQueryUsing()` | `Closure` | Modify query |
| `queue()` | — | Queue export |
| `disk()` | `string` | Storage disk |
