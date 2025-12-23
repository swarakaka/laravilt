---
title: Quick Start
description: Build your first resource in 5 minutes
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Quick Start

Build a complete CRUD resource in 5 minutes.

## Prerequisites

Complete the [installation](installation) first.

## Step 1: Create Model

```bash
php artisan make:model Product -m
```

Edit the migration:

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->integer('stock')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

Run migration:

```bash
php artisan migrate
```

## Step 2: Generate Resource

```bash
php artisan laravilt:resource admin --model=Product
```

This creates:

```
app/Laravilt/Admin/Resources/Product/
├── ProductResource.php
├── Form/ProductForm.php
├── Table/ProductTable.php
├── Pages/
│   ├── ListProduct.php
│   ├── CreateProduct.php
│   └── EditProduct.php
```

## Step 3: Build Assets

```bash
npm run build
```

## Step 4: View Resource

Visit `http://localhost:8000/admin/products`

You now have:
- List page with search and filters
- Create form with validation
- Edit functionality
- Delete with confirmation

## Customize Form

Edit `Form/ProductForm.php`:

```php
return $form->schema([
    Section::make('Product Details')
        ->schema([
            TextInput::make('name')->required(),
            TextInput::make('price')->numeric()->prefix('$'),
            Toggle::make('is_active')->default(true),
        ]),
]);
```

## Customize Table

Edit `Table/ProductTable.php`:

```php
return $table->columns([
    TextColumn::make('name')->searchable(),
    TextColumn::make('price')->money('USD'),
    ToggleColumn::make('is_active'),
]);
```

## Next Steps

- [First Resource](first-resource) - Complete resource tutorial
- [Resource Table](resource-table) - Table configuration
- [Forms](../forms/introduction) - All form components
- [Tables](../tables/introduction) - Table features
- [Troubleshooting](troubleshooting) - Common issues
