---
title: First Resource
description: Complete guide to building your first resource
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Your First Resource

A complete guide to building a Product resource.

## Resource Structure

When you run `php artisan laravilt:resource admin --model=Product`, it creates:

```
app/Laravilt/Admin/Resources/Product/
├── ProductResource.php
├── Form/
│   └── ProductForm.php
├── Table/
│   └── ProductTable.php
└── Pages/
    ├── ListProduct.php
    ├── CreateProduct.php
    └── EditProduct.php
```

## ProductResource.php

```php
namespace App\Laravilt\Admin\Resources\Product;

use App\Models\Product;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Tables\Table;

class ProductResource extends Resource
{
    protected static string $model = Product::class;

    protected static ?string $navigationIcon = 'Package';
    protected static ?string $navigationGroup = 'Shop';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return ProductForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return ProductTable::configure($table);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }
}
```

## Form Configuration

Complete `Form/ProductForm.php`:

```php
namespace App\Laravilt\Admin\Resources\Product\Form;

use Laravilt\Forms\Components\MarkdownEditor;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Forms\Components\FileUpload;
use Laravilt\Forms\Components\Select;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $form): Schema
    {
        return $form->schema([
            Section::make('Basic Information')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($set, $state) =>
                            $set('slug', str($state)->slug())
                        ),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    MarkdownEditor::make('description')
                        ->columnSpanFull(),

                    FileUpload::make('image')
                        ->image()
                        ->directory('products')
                        ->columnSpanFull(),
                ]),

            Section::make('Pricing & Inventory')
                ->columns(3)
                ->schema([
                    TextInput::make('price')
                        ->numeric()
                        ->prefix('$')
                        ->required()
                        ->minValue(0),

                    TextInput::make('compare_price')
                        ->numeric()
                        ->prefix('$')
                        ->minValue(0),

                    TextInput::make('stock')
                        ->integer()
                        ->default(0)
                        ->minValue(0),
                ]),

            Section::make('Status')
                ->schema([
                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    Toggle::make('is_featured')
                        ->label('Featured'),

                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload(),
                ]),
        ]);
    }
}
```

## Next Steps

- [Resource Table](resource-table) - Table configuration
- [Forms](../forms/introduction) - All form components
- [Tables](../tables/introduction) - Table features
