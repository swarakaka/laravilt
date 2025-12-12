# Resources

Resources are the core building blocks of Laravilt. They represent database entities with full CRUD functionality including forms, tables, and detail views.

## Creating Resources

### Using Artisan Command

```bash
php artisan laravilt:make-resource UserResource --model=User --panel=admin
```

Options:
- `--model=`: The Eloquent model class
- `--panel=`: Target panel (default: admin)
- `--create`: Also create the model if it doesn't exist
- `--all`: Generate all page types (list, create, edit, view)

### Generated Structure

```
app/Laravilt/Admin/Resources/
├── UserResource.php
└── User/
    ├── Pages/
    │   ├── ListUsers.php
    │   ├── CreateUser.php
    │   ├── EditUser.php
    │   └── ViewUser.php
    ├── Form/
    │   └── UserForm.php
    ├── Table/
    │   └── UserTable.php
    └── InfoList/
        └── UserInfoList.php
```

---

## Resource Structure

### Basic Resource

```php
<?php

namespace App\Laravilt\Admin\Resources;

use App\Models\User;
use Laravilt\Panel\Resource;
use Laravilt\Forms\Form;
use Laravilt\Tables\Table;

class UserResource extends Resource
{
    // The Eloquent model
    protected static ?string $model = User::class;

    // Navigation icon (Lucide icon name)
    protected static ?string $navigationIcon = 'Users';

    // Navigation group
    protected static ?string $navigationGroup = 'User Management';

    // Navigation sort order
    protected static ?int $navigationSort = 1;

    // Attribute used for record titles
    protected static ?string $recordTitleAttribute = 'name';

    // Define the form schema
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form fields here
            ]);
    }

    // Define the table configuration
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Table columns here
            ]);
    }

    // Define resource pages
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
```

---

## Resource Configuration

### Model Binding

```php
class ProductResource extends Resource
{
    // Required: The Eloquent model
    protected static ?string $model = Product::class;

    // Customize the model label
    protected static ?string $modelLabel = 'Product';

    // Customize the plural label
    protected static ?string $pluralModelLabel = 'Products';

    // Custom route slug
    protected static ?string $slug = 'products';
}
```

### Navigation

```php
class ProductResource extends Resource
{
    // Lucide icon name
    protected static ?string $navigationIcon = 'Package';

    // Navigation group (creates sidebar section)
    protected static ?string $navigationGroup = 'Shop';

    // Sort order within group
    protected static ?int $navigationSort = 1;

    // Custom navigation label
    protected static ?string $navigationLabel = 'All Products';

    // Navigation badge (dynamic count)
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    // Badge color
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'success' : 'warning';
    }

    // Conditionally hide from navigation
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view-products');
    }
}
```

### Global Search

```php
class ProductResource extends Resource
{
    // Attribute displayed in search results
    protected static ?string $recordTitleAttribute = 'name';

    // Searchable attributes for global search
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'sku', 'description'];
    }

    // Custom search result details
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'SKU' => $record->sku,
            'Price' => '$' . number_format($record->price, 2),
        ];
    }

    // Custom search result URL
    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('view', ['record' => $record]);
    }
}
```

---

## Form Configuration

### Basic Form

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Forms\Components\Section;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Basic Information')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),

                    Select::make('role')
                        ->options([
                            'admin' => 'Administrator',
                            'user' => 'User',
                        ])
                        ->required(),

                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                ])
                ->columns(2),
        ]);
}
```

### Form Layouts

```php
use Laravilt\Forms\Components\Section;
use Laravilt\Forms\Components\Grid;
use Laravilt\Forms\Components\Tabs;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Tabs::make('Product')
                ->tabs([
                    Tabs\Tab::make('Details')
                        ->schema([
                            TextInput::make('name')->required(),
                            TextInput::make('slug')->required(),
                        ]),
                    Tabs\Tab::make('Pricing')
                        ->schema([
                            TextInput::make('price')->numeric()->required(),
                            TextInput::make('cost')->numeric(),
                        ]),
                    Tabs\Tab::make('Inventory')
                        ->schema([
                            TextInput::make('stock')->numeric()->default(0),
                            TextInput::make('sku')->required(),
                        ]),
                ]),
        ]);
}
```

---

## Table Configuration

### Basic Table

```php
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\BadgeColumn;
use Laravilt\Tables\Columns\ToggleColumn;
use Laravilt\Tables\Filters\SelectFilter;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')
                ->searchable()
                ->sortable(),

            TextColumn::make('email')
                ->searchable()
                ->copyable(),

            BadgeColumn::make('role')
                ->colors([
                    'primary' => 'admin',
                    'secondary' => 'user',
                ]),

            ToggleColumn::make('is_active')
                ->label('Active'),

            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            SelectFilter::make('role')
                ->options([
                    'admin' => 'Administrator',
                    'user' => 'User',
                ]),
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
```

### Table Features

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([...])

        // Pagination
        ->paginated([10, 25, 50, 100])
        ->defaultPaginationPageOption(25)

        // Search
        ->searchable()
        ->searchPlaceholder('Search users...')

        // Sorting
        ->defaultSort('name', 'asc')

        // Reordering
        ->reorderable('sort_order')

        // Polling
        ->poll('60s')

        // Empty state
        ->emptyStateHeading('No users found')
        ->emptyStateDescription('Create your first user to get started.')
        ->emptyStateIcon('Users');
}
```

---

## Infolist Configuration

For view pages, define how record details are displayed:

```php
use Laravilt\Infolists\Components\TextEntry;
use Laravilt\Infolists\Components\Section;

public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Section::make('User Information')
                ->schema([
                    TextEntry::make('name'),
                    TextEntry::make('email')
                        ->copyable(),
                    TextEntry::make('role')
                        ->badge(),
                    TextEntry::make('created_at')
                        ->dateTime(),
                ])
                ->columns(2),
        ]);
}
```

---

## Resource Pages

### List Page

```php
<?php

namespace App\Laravilt\Admin\Resources\User\Pages;

use App\Laravilt\Admin\Resources\UserResource;
use Laravilt\Panel\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Laravilt\Actions\CreateAction::make(),
        ];
    }
}
```

### Create Page

```php
<?php

namespace App\Laravilt\Admin\Resources\User\Pages;

use App\Laravilt\Admin\Resources\UserResource;
use Laravilt\Panel\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Redirect after creation
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Mutate data before creation
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }

    // After creation hook
    protected function afterCreate(): void
    {
        // Send notification, trigger events, etc.
    }
}
```

### Edit Page

```php
<?php

namespace App\Laravilt\Admin\Resources\User\Pages;

use App\Laravilt\Admin\Resources\UserResource;
use Laravilt\Panel\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Laravilt\Actions\DeleteAction::make(),
        ];
    }

    // Mutate data before filling form
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    // Mutate data before saving
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }
}
```

### View Page

```php
<?php

namespace App\Laravilt\Admin\Resources\User\Pages;

use App\Laravilt\Admin\Resources\UserResource;
use Laravilt\Panel\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Laravilt\Actions\EditAction::make(),
            \Laravilt\Actions\DeleteAction::make(),
        ];
    }
}
```

### Manage Records (Single Page CRUD)

For simple resources, use a single page with modal dialogs:

```php
<?php

namespace App\Laravilt\Admin\Resources\Tag\Pages;

use App\Laravilt\Admin\Resources\TagResource;
use Laravilt\Panel\Pages\ManageRecords;

class ManageTags extends ManageRecords
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Laravilt\Actions\CreateAction::make(),
        ];
    }
}
```

Update the resource pages:

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ManageTags::route('/'),
    ];
}
```

---

## Relation Managers

Handle related records within a resource:

### Creating a Relation Manager

```bash
php artisan laravilt:make-relation PostComments --resource=PostResource --relationship=comments
```

### Relation Manager Class

```php
<?php

namespace App\Laravilt\Admin\Resources\Post\RelationManagers;

use Laravilt\Panel\Resources\RelationManagers\RelationManager;
use Laravilt\Forms\Form;
use Laravilt\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'content';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Laravilt\Forms\Components\Textarea::make('content')
                    ->required()
                    ->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                \Laravilt\Tables\Columns\TextColumn::make('content')
                    ->limit(50),
                \Laravilt\Tables\Columns\TextColumn::make('user.name'),
                \Laravilt\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->actions([
                \Laravilt\Actions\EditAction::make(),
                \Laravilt\Actions\DeleteAction::make(),
            ]);
    }
}
```

### Register Relation Manager

```php
class PostResource extends Resource
{
    public static function getRelations(): array
    {
        return [
            RelationManagers\CommentsRelationManager::class,
        ];
    }
}
```

---

## API Resources

Enable automatic REST API for a resource:

```php
use Laravilt\Panel\Resources\ApiResource;

class ProductResource extends Resource
{
    public static function getApiResource(): ?ApiResource
    {
        return ApiResource::make()
            // Searchable columns
            ->searchableColumns(['name', 'sku', 'description'])

            // Allowed filters
            ->allowedFilters(['category_id', 'is_active', 'price'])

            // Allowed sorts
            ->allowedSorts(['name', 'price', 'stock', 'created_at'])

            // Validation rules
            ->validationRules([
                'name' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric', 'min:0'],
                'stock' => ['required', 'integer', 'min:0'],
            ]);
    }
}
```

Generated API endpoints:

```
GET    /admin/api/products              # List
POST   /admin/api/products              # Create
GET    /admin/api/products/{id}         # Show
PUT    /admin/api/products/{id}         # Update
DELETE /admin/api/products/{id}         # Delete
GET    /admin/api/products/openapi.json # OpenAPI spec
```

---

## Authorization

### Policy-Based Authorization

```php
class UserResource extends Resource
{
    // Use Laravel policies
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('viewAny', User::class);
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create', User::class);
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('update', $record);
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete', $record);
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()?->can('view', $record);
    }
}
```

### Conditional Fields

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name'),

            // Only visible to admins
            Select::make('role')
                ->visible(fn () => auth()->user()->isAdmin()),

            // Disabled for non-owners
            TextInput::make('email')
                ->disabled(fn ($record) =>
                    $record && $record->id !== auth()->id()
                ),
        ]);
}
```

---

## Complete Resource Example

```php
<?php

namespace App\Laravilt\Admin\Resources;

use App\Models\Product;
use Laravilt\Panel\Resource;
use Laravilt\Forms\Form;
use Laravilt\Forms\Components\{Section, TextInput, Textarea, Select, Toggle, FileUpload};
use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\{TextColumn, ImageColumn, ToggleColumn};
use Laravilt\Tables\Filters\{SelectFilter, TernaryFilter};
use Laravilt\Infolists\Infolist;
use Laravilt\Infolists\Components\{TextEntry, ImageEntry, Section as InfoSection};

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'Package';
    protected static ?string $navigationGroup = 'Shop';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) =>
                                $set('slug', \Str::slug($state))
                            ),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Pricing')
                    ->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('stock')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('sku')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ])
                    ->columns(3),

                Section::make('Organization')
                    ->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Toggle::make('is_active')
                            ->default(true),
                        FileUpload::make('image')
                            ->image()
                            ->directory('products'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->circular(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('category.name')->badge(),
                TextColumn::make('price')->money('USD')->sortable(),
                TextColumn::make('stock')->sortable(),
                ToggleColumn::make('is_active'),
                TextColumn::make('created_at')->dateTime()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('category')->relationship('category', 'name'),
                TernaryFilter::make('is_active'),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoSection::make('Product Details')
                    ->schema([
                        ImageEntry::make('image'),
                        TextEntry::make('name'),
                        TextEntry::make('slug'),
                        TextEntry::make('description'),
                        TextEntry::make('price')->money('USD'),
                        TextEntry::make('stock'),
                        TextEntry::make('sku'),
                        TextEntry::make('category.name')->badge(),
                        TextEntry::make('is_active')->badge(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'sku', 'description'];
    }
}
```

---

## Next Steps

- [Pages](pages.md) - Create custom standalone pages
- [Navigation](navigation.md) - Customize navigation structure
- [Forms Documentation](../forms/introduction.md) - Learn all form field types
- [Tables Documentation](../tables/introduction.md) - Advanced table features
