# Quick Start Guide

This guide will walk you through building your first CRUD resource with Laravilt in under 10 minutes.

## Prerequisites

Ensure you have completed the [installation](installation.md) process.

## Creating Your First Resource

We'll create a complete Product management system with:
- Listing with search and filters
- Create and edit forms
- View page with details
- Delete functionality

### Step 1: Create the Model and Migration

```bash
php artisan make:model Product -m
```

Edit the migration `database/migrations/xxxx_create_products_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->string('sku')->unique();
            $table->boolean('is_active')->default(true);
            $table->string('thumbnail')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

Run the migration:

```bash
php artisan migrate
```

### Step 2: Update the Model

Edit `app/Models/Product.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'sku',
        'is_active',
        'thumbnail',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
```

### Step 3: Generate the Resource

Use the Laravilt resource generator. The command is interactive and will guide you through the process:

```bash
php artisan laravilt:resource admin --table=products
```

Or specify the model directly:

```bash
php artisan laravilt:resource admin --model=Product
```

**Command Options:**
- `admin` - The panel ID (first argument)
- `--table=` - Database table name to generate from
- `--model=` - Eloquent model class name
- `--simple` - Generate a simplified resource structure

This creates a complete resource structure:

```
app/Laravilt/Admin/Resources/Product/
├── ProductResource.php           # Main resource class
├── Form/
│   └── ProductForm.php          # Form configuration
├── Table/
│   └── ProductTable.php         # Table configuration
├── InfoList/
│   └── ProductInfoList.php      # View page configuration
├── Api/
│   └── ProductApi.php           # API configuration
├── Pages/
│   ├── ListProduct.php          # List page
│   ├── CreateProduct.php        # Create page
│   ├── EditProduct.php          # Edit page
│   └── ViewProduct.php          # View page
└── RelationManagers/            # Relation managers (if any)
```

### Step 4: Understanding the Resource Structure

The generated `ProductResource.php` delegates configuration to separate classes:

```php
<?php

namespace App\Laravilt\Admin\Resources\Product;

use App\Laravilt\Admin\Resources\Product\Form\ProductForm;
use App\Laravilt\Admin\Resources\Product\Table\ProductTable;
use App\Laravilt\Admin\Resources\Product\InfoList\ProductInfoList;
use App\Laravilt\Admin\Resources\Product\Api\ProductApi;
use App\Laravilt\Admin\Resources\Product\Pages\CreateProduct;
use App\Laravilt\Admin\Resources\Product\Pages\EditProduct;
use App\Laravilt\Admin\Resources\Product\Pages\ListProduct;
use App\Laravilt\Admin\Resources\Product\Pages\ViewProduct;
use App\Models\Product;
use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Tables\ApiResource;
use Laravilt\Tables\Table;

class ProductResource extends Resource
{
    protected static string $model = Product::class;

    protected static ?string $navigationIcon = 'Package';

    protected static ?string $navigationGroup = null;

    protected static int $navigationSort = 1;

    protected static bool $hasApi = true;

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductInfoList::configure($schema);
    }

    public static function api(ApiResource $api): ApiResource
    {
        return ProductApi::configure($api);
    }

    public static function getPages(): array
    {
        return [
            'list' => ListProduct::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
            'view' => ViewProduct::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::count();
        return $count > 0 ? (string) $count : null;
    }
}
```

### Step 5: Customize the Form

Edit `app/Laravilt/Admin/Resources/Product/Form/ProductForm.php`:

```php
<?php

namespace App\Laravilt\Admin\Resources\Product\Form;

use Laravilt\Forms\Components\FileUpload;
use Laravilt\Forms\Components\MarkdownEditor;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Forms\Components\ToggleButtons;
use Laravilt\Schemas\Components\Grid;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->description('Enter the product details')
                    ->icon('Info')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Product Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('sku')
                                    ->label('SKU')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(100),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Content')
                    ->icon('FileText')
                    ->collapsible()
                    ->schema([
                        MarkdownEditor::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Media')
                    ->icon('Image')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('products/thumbnails')
                            ->imagePreviewHeight(150),
                    ]),

                Section::make('Pricing & Inventory')
                    ->icon('DollarSign')
                    ->collapsible()
                    ->schema([
                        Grid::make(3)
                            ->columns(3)
                            ->schema([
                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required()
                                    ->minValue(0),

                                TextInput::make('stock_quantity')
                                    ->label('Stock Quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->minValue(0),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->inline(false),
                            ]),
                    ]),

                Section::make('Status')
                    ->icon('Tag')
                    ->collapsible()
                    ->schema([
                        ToggleButtons::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'archived' => 'Archived',
                            ])
                            ->default('draft'),
                    ]),
            ]);
    }
}
```

### Step 6: Customize the Table

Edit `app/Laravilt/Admin/Resources/Product/Table/ProductTable.php`:

```php
<?php

namespace App\Laravilt\Admin\Resources\Product\Table;

use Laravilt\Tables\Columns\ImageColumn;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\ToggleColumn;
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Filters\TernaryFilter;
use Laravilt\Tables\Table;

class ProductTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->circular(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->sku),

                TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'secondary',
                        'active' => 'success',
                        'inactive' => 'warning',
                        'archived' => 'danger',
                        default => 'secondary',
                    }),

                ToggleColumn::make('is_active')
                    ->label('Active'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'archived' => 'Archived',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                \Laravilt\Actions\ViewAction::make(),
                \Laravilt\Actions\EditAction::make(),
                \Laravilt\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Laravilt\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
```

### Step 7: Build Frontend Assets

```bash
npm run build
```

### Step 8: Test Your Resource

Visit `http://localhost:8000/admin/products` to see your new resource.

You should see:
- Empty state with "Create Product" button
- Search bar
- Filter dropdowns
- Column toggles

---

## Adding Custom Actions

Add a custom action to duplicate a product in `ProductTable.php`:

```php
->actions([
    \Laravilt\Actions\ViewAction::make(),
    \Laravilt\Actions\EditAction::make(),

    \Laravilt\Actions\Action::make('duplicate')
        ->label('Duplicate')
        ->icon('Copy')
        ->color('secondary')
        ->requiresConfirmation()
        ->modalHeading('Duplicate Product')
        ->modalDescription('This will create a copy of this product.')
        ->action(function ($record) {
            $duplicate = $record->replicate();
            $duplicate->name = $record->name . ' (Copy)';
            $duplicate->slug = $record->slug . '-copy-' . time();
            $duplicate->sku = $record->sku . '-' . time();
            $duplicate->save();

            \Laravilt\Notifications\Notification::make()
                ->title('Product duplicated')
                ->success()
                ->send();
        }),

    \Laravilt\Actions\DeleteAction::make(),
])
```

---

## Adding API Access

The resource already has API support via the `ProductApi.php` class. Edit it to customize:

```php
<?php

namespace App\Laravilt\Admin\Resources\Product\Api;

use Laravilt\Tables\ApiResource;

class ProductApi
{
    public static function configure(ApiResource $api): ApiResource
    {
        return $api
            ->searchableColumns(['name', 'sku', 'description'])
            ->allowedFilters(['status', 'is_active'])
            ->allowedSorts(['name', 'price', 'stock_quantity', 'created_at'])
            ->validationRules([
                'name' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric', 'min:0'],
                'stock_quantity' => ['required', 'integer', 'min:0'],
            ]);
    }
}
```

API endpoints are automatically generated:
- `GET /admin/api/products` - List products
- `GET /admin/api/products/{id}` - Get product
- `POST /admin/api/products` - Create product
- `PUT /admin/api/products/{id}` - Update product
- `DELETE /admin/api/products/{id}` - Delete product

---

## Next Steps

Now that you have your first resource, explore:

- [Forms Documentation](../forms/introduction.md) - Learn all field types
- [Tables Documentation](../tables/introduction.md) - Advanced table features
- [Actions Documentation](../actions/introduction.md) - Custom actions
- [Panel Documentation](../panel/introduction.md) - Multi-panel setup
