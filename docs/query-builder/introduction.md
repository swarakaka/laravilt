# Query-Builder Introduction

The Query-Builder package provides a powerful, fluent interface for building complex data queries with filtering, sorting, searching, and pagination capabilities.

## Overview

Laravilt Query-Builder offers:

- **Flexible Filtering** - Text, Select, Boolean, and Date filters
- **Dynamic Sorting** - Multi-column sorting with customizable defaults
- **Search Functionality** - Global search across multiple columns
- **Pagination** - Built-in pagination support
- **Fluent Interface** - Chainable API for intuitive configuration
- **Multi-Platform** - Serializes to Inertia.js and Flutter formats

---

## Basic Usage

### Simple Query Builder

```php
use Laravilt\QueryBuilder\QueryBuilder;
use Laravilt\QueryBuilder\Filters\TextFilter;
use Laravilt\QueryBuilder\Filters\SelectFilter;
use Laravilt\QueryBuilder\Sort;

$queryBuilder = new QueryBuilder();

$queryBuilder
    ->filters([
        TextFilter::make('name')
            ->label('Product Name')
            ->contains(),

        SelectFilter::make('status')
            ->label('Status')
            ->options([
                'active' => 'Active',
                'inactive' => 'Inactive',
            ]),
    ])
    ->sorts([
        Sort::make('name')->label('Name'),
        Sort::make('created_at')->label('Created Date')->defaultDirection('desc'),
    ])
    ->applyFilters([
        'name' => 'laptop',
        'status' => 'active',
    ])
    ->sortBy('created_at', 'desc')
    ->perPage(15);

// Apply to Eloquent query
$query = Product::query();
$queryBuilder->apply($query);

// Get paginated results
$products = $query->paginate($queryBuilder->perPage);
```

---

## Filter Types

### TextFilter

Text-based filtering with multiple operators.

```php
use Laravilt\QueryBuilder\Filters\TextFilter;

// Contains (substring match)
TextFilter::make('name')
    ->label('Product Name')
    ->contains()
    ->placeholder('Search products...');

// Exact match
TextFilter::make('sku')
    ->label('SKU')
    ->exact();

// Starts with
TextFilter::make('email')
    ->label('Email')
    ->startsWith()
    ->caseSensitive();

// Ends with
TextFilter::make('domain')
    ->label('Domain')
    ->endsWith();
```

**Operators:**
- `contains()` - WHERE column LIKE '%value%'
- `exact()` - WHERE column = 'value'
- `startsWith()` - WHERE column LIKE 'value%'
- `endsWith()` - WHERE column LIKE '%value'

**Options:**
- `caseSensitive(bool)` - Toggle case sensitivity (default: false)
- `operator(string)` - Custom operator ('=', 'like', 'starts_with', 'ends_with')

### SelectFilter

Dropdown-based filtering with single or multiple selections.

```php
use Laravilt\QueryBuilder\Filters\SelectFilter;

// Single select
SelectFilter::make('status')
    ->label('Status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ])
    ->default('published')
    ->placeholder('Select status...');

// Multiple select
SelectFilter::make('category')
    ->label('Categories')
    ->options([
        'electronics' => 'Electronics',
        'furniture' => 'Furniture',
        'fitness' => 'Fitness',
    ])
    ->multiple()
    ->searchable();
```

**Options:**
- `multiple(bool)` - Enable multiple selections (default: false)
- `searchable(bool)` - Enable search within options (default: false)
- `options(array)` - Key-value pairs for dropdown

**Application:**
- Single: WHERE column = value
- Multiple: WHERE column IN (value1, value2, ...)

### BooleanFilter

Boolean/toggle filtering for yes/no fields.

```php
use Laravilt\QueryBuilder\Filters\BooleanFilter;

BooleanFilter::make('is_featured')
    ->label('Featured Products')
    ->trueLabel('Featured')
    ->falseLabel('Not Featured')
    ->default(true);

BooleanFilter::make('is_active')
    ->label('Active Status')
    ->trueLabel('Active')
    ->falseLabel('Inactive');
```

**Options:**
- `trueLabel(string)` - Label for true value (default: 'Yes')
- `falseLabel(string)` - Label for false value (default: 'No')

**Value Conversion:**
- Supports: true/false, 'true'/'false', 1/0
- Uses `filter_var($value, FILTER_VALIDATE_BOOLEAN)`

### DateFilter

Date-based filtering with range and comparison operators.

```php
use Laravilt\QueryBuilder\Filters\DateFilter;

// Single date (equal)
DateFilter::make('created_at')
    ->label('Created Date')
    ->withTime();

// Before date
DateFilter::make('expires_at')
    ->label('Expires Before')
    ->before()
    ->maxDate('2024-12-31');

// After date
DateFilter::make('published_at')
    ->label('Published After')
    ->after()
    ->minDate('2024-01-01');

// Date range
DateFilter::make('created_at')
    ->label('Created Between')
    ->between()
    ->minDate('2024-01-01')
    ->maxDate('2024-12-31');
```

**Operators:**
- `before()` - WHERE column < date
- `after()` - WHERE column > date
- `between()` - WHERE column BETWEEN date1 AND date2

**Options:**
- `minDate(string)` - Minimum date constraint
- `maxDate(string)` - Maximum date constraint
- `withTime(bool)` - Include time selector (default: false)

---

## Custom Filter Logic

All filters support custom query logic via closures:

```php
TextFilter::make('search')
    ->label('Global Search')
    ->query(function ($query, $value) {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('description', 'like', "%{$value}%")
            ->orWhere('sku', 'like', "%{$value}%");
    });

SelectFilter::make('price_range')
    ->label('Price Range')
    ->options([
        'under_50' => 'Under $50',
        '50_to_100' => '$50 - $100',
        'over_100' => 'Over $100',
    ])
    ->query(function ($query, $value) {
        match($value) {
            'under_50' => $query->where('price', '<', 5000),
            '50_to_100' => $query->whereBetween('price', [5000, 10000]),
            'over_100' => $query->where('price', '>', 10000),
        };
    });
```

---

## Sorting

### Basic Sorting

```php
use Laravilt\QueryBuilder\Sort;

$queryBuilder->sorts([
    Sort::make('name')
        ->label('Name'),

    Sort::make('created_at')
        ->label('Created Date')
        ->defaultDirection('desc'),

    Sort::make('price')
        ->label('Price')
        ->column('price_cents'), // Different database column
]);

// Apply sorting
$queryBuilder->sortBy('created_at', 'desc');
```

### Sort Configuration

```php
Sort::make('name')
    ->label('Product Name')           // Display label
    ->column('name')                   // Database column
    ->defaultDirection('asc')          // Default direction
    ->visible(true);                   // Visibility control
```

**Auto-Label Generation:**
- 'created_at' → 'Created At'
- 'product_name' → 'Product Name'
- 'users.name' → 'Users Name'

---

## Search

### Global Search

```php
$queryBuilder->search($request->get('search'));
```

The search functionality allows frontend-driven filtering across multiple columns.

**Implementation Pattern:**

```php
// Backend: Set search value
$queryBuilder->search($request->get('search'));

// Frontend receives search value in props
// Vue component handles search filtering
```

---

## Pagination

### Configure Pagination

```php
// Set items per page
$queryBuilder->perPage(20);

// Toggle pagination
$queryBuilder->paginated(true);

// Disable pagination
$queryBuilder->paginated(false);
```

### Using with Laravel Pagination

```php
$query = Product::query();
$queryBuilder->apply($query);

// Paginate results
$products = $queryBuilder->paginated
    ? $query->paginate($queryBuilder->perPage)
    : $query->get();
```

**Default Configuration:**
- Enabled: true
- Items per page: 15

---

## Complete Examples

### Product Filtering

```php
use Laravilt\QueryBuilder\QueryBuilder;
use Laravilt\QueryBuilder\Filters\TextFilter;
use Laravilt\QueryBuilder\Filters\SelectFilter;
use Laravilt\QueryBuilder\Filters\BooleanFilter;
use Laravilt\QueryBuilder\Sort;

$queryBuilder = new QueryBuilder();

$queryBuilder
    ->filters([
        TextFilter::make('name')
            ->label('Product Name')
            ->contains()
            ->placeholder('Search products...'),

        SelectFilter::make('category')
            ->label('Category')
            ->options([
                'electronics' => 'Electronics',
                'furniture' => 'Furniture',
                'fitness' => 'Fitness',
            ])
            ->multiple()
            ->searchable(),

        BooleanFilter::make('is_featured')
            ->label('Featured')
            ->trueLabel('Featured Only')
            ->falseLabel('All Products'),

        SelectFilter::make('status')
            ->label('Status')
            ->options([
                'active' => 'Active',
                'inactive' => 'Inactive',
            ])
            ->default('active'),
    ])
    ->sorts([
        Sort::make('name')->label('Name'),
        Sort::make('price')->label('Price'),
        Sort::make('created_at')->label('Date Created')->defaultDirection('desc'),
    ])
    ->applyFilters($request->only(['name', 'category', 'is_featured', 'status']))
    ->search($request->get('search'))
    ->sortBy($request->get('sort'), $request->get('direction', 'asc'))
    ->perPage($request->get('perPage', 15));

$query = Product::query();
$queryBuilder->apply($query);

return Inertia::render('Products/Index', [
    'products' => $query->paginate($queryBuilder->perPage),
    'queryBuilder' => $queryBuilder->toInertiaProps(),
]);
```

### Article Filtering with Date Range

```php
$queryBuilder = new QueryBuilder();

$queryBuilder
    ->filters([
        TextFilter::make('title')
            ->label('Title')
            ->contains(),

        SelectFilter::make('category')
            ->label('Category')
            ->options([
                'tutorial' => 'Tutorial',
                'news' => 'News',
                'advanced' => 'Advanced',
            ])
            ->multiple(),

        BooleanFilter::make('is_featured')
            ->label('Featured'),

        BooleanFilter::make('is_published')
            ->label('Published'),

        DateFilter::make('published_at')
            ->label('Published Date')
            ->between()
            ->minDate('2024-01-01')
            ->maxDate('2024-12-31'),
    ])
    ->applyFilters([
        'category' => ['tutorial', 'advanced'],
        'is_featured' => true,
        'is_published' => true,
        'published_at' => ['2024-02-01', '2024-02-28'],
    ])
    ->sortBy('views', 'desc')
    ->perPage(20);

$query = Article::query();
$queryBuilder->apply($query);
$articles = $query->paginate($queryBuilder->perPage);
```

### User Management

```php
$queryBuilder = new QueryBuilder();

$queryBuilder
    ->filters([
        TextFilter::make('name')
            ->label('Name')
            ->contains(),

        TextFilter::make('email')
            ->label('Email')
            ->contains(),

        SelectFilter::make('role')
            ->label('Role')
            ->options([
                'admin' => 'Administrator',
                'editor' => 'Editor',
                'user' => 'User',
            ]),

        BooleanFilter::make('email_verified')
            ->label('Email Verified')
            ->trueLabel('Verified')
            ->falseLabel('Not Verified'),

        DateFilter::make('created_at')
            ->label('Registration Date')
            ->between(),
    ])
    ->sorts([
        Sort::make('name')->label('Name'),
        Sort::make('email')->label('Email'),
        Sort::make('created_at')->label('Registered')->defaultDirection('desc'),
    ])
    ->applyFilters($request->all())
    ->sortBy($request->get('sort', 'created_at'), $request->get('direction', 'desc'))
    ->perPage(25);

$query = User::query();
$queryBuilder->apply($query);

return Inertia::render('Users/Index', [
    'users' => $query->paginate($queryBuilder->perPage),
    'queryBuilder' => $queryBuilder->toInertiaProps(),
]);
```

---

## Filter Configuration

### Common Filter Options

All filters support these configuration methods:

```php
->label(string $label)              // Display label
->column(string $column)            // Database column
->default(mixed $value)             // Default value
->visible(bool $condition)          // Visibility control
->placeholder(string $placeholder)  // Placeholder text
->query(Closure $callback)          // Custom query logic
```

### Filter Visibility

```php
TextFilter::make('admin_notes')
    ->label('Admin Notes')
    ->visible(auth()->user()->isAdmin());

SelectFilter::make('status')
    ->label('Status')
    ->visible(fn() => request()->user()->can('viewAny', Product::class));
```

---

## Serialization

### Inertia.js Integration

```php
return Inertia::render('Products/Index', [
    'products' => $products,
    'queryBuilder' => $queryBuilder->toInertiaProps(),
]);
```

**Serialized Output:**
```php
[
    'filters' => [...],
    'sorts' => [...],
    'filterValues' => [...],
    'search' => 'search query',
    'sortBy' => 'column_name',
    'sortDirection' => 'asc',
    'perPage' => 15,
    'paginated' => true,
]
```

### Flutter Integration

```php
return response()->json([
    'data' => $products,
    'queryBuilder' => $queryBuilder->toFlutterProps(),
]);
```

---

## Best Practices

### 1. Use Appropriate Filter Types

```php
// Good: Specific filter types
BooleanFilter::make('is_active')
SelectFilter::make('status')
DateFilter::make('created_at')

// Avoid: Generic text filters for structured data
TextFilter::make('is_active')  // Use BooleanFilter instead
```

### 2. Provide Clear Labels

```php
// Good
TextFilter::make('name')->label('Product Name')
SelectFilter::make('status')->label('Publication Status')

// Avoid
TextFilter::make('name')  // Auto-generated label may not be ideal
```

### 3. Set Sensible Defaults

```php
SelectFilter::make('status')
    ->options([...])
    ->default('active');

Sort::make('created_at')
    ->defaultDirection('desc');
```

### 4. Use Closures for Dynamic Data

```php
// Good: Dynamic options from database
SelectFilter::make('category')
    ->options(Category::pluck('name', 'id')->toArray())

// Good: Complex filtering logic
TextFilter::make('search')
    ->query(function ($query, $value) {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    })
```

### 5. Optimize Pagination

```php
// Good: Reasonable page sizes
->perPage(15)  // Small lists
->perPage(25)  // Medium lists
->perPage(50)  // Large lists

// Avoid: Excessive page sizes
->perPage(1000)  // Performance issues
```

### 6. Enable Multi-Select for Categories

```php
SelectFilter::make('tags')
    ->options(Tag::pluck('name', 'id')->toArray())
    ->multiple()      // Allow multiple tag selection
    ->searchable();   // Enable search for many options
```

---

## API Reference

### QueryBuilder

```php
$queryBuilder = new QueryBuilder();

// Configuration
->filters(array $filters)
->addFilter(Filter $filter)
->sorts(array $sorts)
->addSort(Sort $sort)
->applyFilters(array $values)
->search(?string $search)
->sortBy(?string $column, ?string $direction = 'asc')
->perPage(int $perPage)
->paginated(bool $condition = true)

// Application
->apply(Builder $query): Builder

// Serialization
->toInertiaProps(): array
->toFlutterProps(): array
```

### Filter Methods

```php
Filter::make(string $name)
    ->label(string $label)
    ->column(string $column)
    ->default(mixed $value)
    ->visible(bool $condition)
    ->placeholder(string $placeholder)
    ->query(Closure $callback)
```

### TextFilter Methods

```php
TextFilter::make(string $name)
    ->operator(string $operator)  // '=', 'like', 'starts_with', 'ends_with'
    ->exact()
    ->contains()
    ->startsWith()
    ->endsWith()
    ->caseSensitive(bool $condition)
```

### SelectFilter Methods

```php
SelectFilter::make(string $name)
    ->options(array $options)
    ->multiple(bool $condition)
    ->searchable(bool $condition)
```

### BooleanFilter Methods

```php
BooleanFilter::make(string $name)
    ->trueLabel(string $label)
    ->falseLabel(string $label)
```

### DateFilter Methods

```php
DateFilter::make(string $name)
    ->operator(string $operator)  // '=', '<', '>', 'between'
    ->before()
    ->after()
    ->between()
    ->minDate(string $date)
    ->maxDate(string $date)
    ->withTime(bool $condition)
```

### Sort Methods

```php
Sort::make(string $name, ?string $column = null)
    ->label(string $label)
    ->column(string $column)
    ->defaultDirection(string $direction)
    ->visible(bool $condition)
```

---

## Next Steps

- [Tables](../tables/introduction.md) - Table integration with Query-Builder
- [Panel](../panel/introduction.md) - Panel configuration
