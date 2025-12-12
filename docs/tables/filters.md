# Table Filters

Complete reference for filtering table data in Laravilt.

## Overview

Laravilt provides 5 filter types:

- **SelectFilter** - Dropdown selection filter
- **TernaryFilter** - Three-state boolean filter (True/False/All)
- **TrashedFilter** - Soft delete filter (With/Without/Only trashed)
- **BaseFilter** - Custom filter with form schema
- **Custom Filters** - Build your own using closures

All filters support custom query logic, default values, and active filter indicators.

---

## SelectFilter

Dropdown selection filter with single or multiple options.

### Basic Usage

```php
use Laravilt\Tables\Filters\SelectFilter;

SelectFilter::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ]);
```

### Multiple Selection

```php
SelectFilter::make('categories')
    ->options(Category::pluck('name', 'id'))
    ->multiple();
```

### Searchable Options

```php
SelectFilter::make('author')
    ->options(User::pluck('name', 'id'))
    ->searchable();
```

### Relationship-Based

```php
SelectFilter::make('category')
    ->relationship('category', 'name')
    ->preload();                    // Load all options immediately
```

### Relationship with Modification

```php
SelectFilter::make('author')
    ->relationship(
        name: 'author',
        titleAttribute: 'name',
        modifyQueryUsing: fn ($query) => $query->where('is_active', true)
    );
```

### Custom Query

```php
SelectFilter::make('status')
    ->options([
        'active' => 'Active',
        'inactive' => 'Inactive',
    ])
    ->query(function ($query, $value) {
        return $query->where('status', $value);
    });
```

### Default Value

```php
SelectFilter::make('status')
    ->options([...])
    ->default('published');         // Pre-select "published"
```

### Empty Option

```php
SelectFilter::make('category')
    ->relationship('category', 'name')
    ->hasEmptyOption()              // Show "None" option
    ->emptyRelationshipOptionLabel('No Category');
```

### Custom Indicator

```php
SelectFilter::make('status')
    ->options([
        'active' => 'Active',
        'inactive' => 'Inactive',
    ])
    ->indicateUsing(function ($value) {
        $labels = [
            'active' => 'Active Only',
            'inactive' => 'Inactive Only',
        ];
        return $labels[$value] ?? $value;
    });
```

### All SelectFilter Options

```php
SelectFilter::make('field')
    ->options(array|Closure)        // Filter options
    ->multiple(bool)                // Multiple selection
    ->searchable(bool)              // Searchable dropdown
    ->relationship(...)             // Filter by relationship
    ->preload(bool)                 // Preload options
    ->hasEmptyOption(bool)          // Show empty option
    ->emptyRelationshipOptionLabel(string)
    ->query(Closure)                // Custom query logic
    ->default(mixed)                // Default value
    ->indicateUsing(Closure)        // Custom indicator
    ->attribute(string);            // Database column name
```

---

## TernaryFilter

Three-state boolean filter (True/False/All).

### Basic Usage

```php
use Laravilt\Tables\Filters\TernaryFilter;

TernaryFilter::make('is_featured')
    ->label('Featured');
```

### Custom Labels

```php
TernaryFilter::make('is_active')
    ->label('Active Status')
    ->trueLabel('Active Only')
    ->falseLabel('Inactive Only')
    ->placeholderLabel('All Records');
```

### Nullable Mode

```php
TernaryFilter::make('email_verified_at')
    ->nullable()                    // Uses whereNull/whereNotNull
    ->trueLabel('Verified')
    ->falseLabel('Unverified')
    ->placeholderLabel('All');
```

### Custom Queries

```php
TernaryFilter::make('subscription')
    ->queries(
        true: fn ($query) => $query->whereHas('subscription', fn ($q) =>
            $q->where('status', 'active')
        ),
        false: fn ($query) => $query->whereDoesntHave('subscription'),
        blank: fn ($query) => $query  // All records
    );
```

### All TernaryFilter Options

```php
TernaryFilter::make('field')
    ->trueLabel(string)             // Label for true state
    ->falseLabel(string)            // Label for false state
    ->placeholderLabel(string)      // Label for all/blank state
    ->nullable(bool)                // Use whereNull/whereNotNull
    ->queries(...)                  // Custom query closures
    ->indicateUsing(Closure)        // Custom indicator
    ->attribute(string);            // Database column name
```

---

## TrashedFilter

Filter for soft-deleted records (requires SoftDeletes trait).

### Basic Usage

```php
use Laravilt\Tables\Filters\TrashedFilter;

TrashedFilter::make();
```

This creates a filter with three options:
- **Without Trashed** (default) - Only non-deleted records
- **With Trashed** - All records including deleted
- **Only Trashed** - Only deleted records

### Customization

The filter automatically works with Laravel's SoftDeletes trait and provides:
- Pre-configured labels
- Automatic query scopes
- Built-in indicator text

---

## BaseFilter

Create custom filters with any form field as input.

### Basic Usage

```php
use Laravilt\Tables\Filters\BaseFilter;
use Laravilt\Forms\Components\TextInput;

BaseFilter::make('search')
    ->schema(
        TextInput::make('search')
            ->placeholder('Search...')
    )
    ->query(function ($query, $value) {
        return $query->where('name', 'like', "%{$value}%");
    });
```

### Date Range Filter

```php
use Laravilt\Forms\Components\DatePicker;

BaseFilter::make('date_range')
    ->schema(
        DateRangePicker::make('dates')
            ->startFieldName('start_date')
            ->endFieldName('end_date')
    )
    ->query(function ($query, $value) {
        return $query->whereBetween('created_at', [
            $value['start_date'],
            $value['end_date'],
        ]);
    });
```

### Number Range Filter

```php
use Laravilt\Forms\Components\TextInput;

BaseFilter::make('price_range')
    ->schema([
        TextInput::make('min_price')
            ->numeric()
            ->prefix('$')
            ->placeholder('Min'),
        TextInput::make('max_price')
            ->numeric()
            ->prefix('$')
            ->placeholder('Max'),
    ])
    ->query(function ($query, $value) {
        if (isset($value['min_price'])) {
            $query->where('price', '>=', $value['min_price']);
        }
        if (isset($value['max_price'])) {
            $query->where('price', '<=', $value['max_price']);
        }
        return $query;
    });
```

### Toggle Filter

```php
use Laravilt\Forms\Components\Toggle;

BaseFilter::make('has_image')
    ->schema(
        Toggle::make('has_image')
            ->label('Has Image')
    )
    ->query(function ($query, $value) {
        if ($value) {
            return $query->whereNotNull('image');
        }
        return $query;
    });
```

### All BaseFilter Options

```php
BaseFilter::make('field')
    ->schema(Field|array)           // Form field(s) for input
    ->query(Closure)                // Filter query logic
    ->default(mixed)                // Default value
    ->indicateUsing(Closure)        // Custom indicator
    ->attribute(string);            // Database column name
```

---

## Custom Filters

Create completely custom filters using closures.

### Simple Custom Filter

```php
use Laravilt\Forms\Components\Select;

BaseFilter::make('priority')
    ->schema(
        Select::make('priority')
            ->options([
                'high' => 'High Priority',
                'medium' => 'Medium Priority',
                'low' => 'Low Priority',
            ])
    )
    ->query(function ($query, $value) {
        return $query->where('priority', $value);
    })
    ->indicateUsing(fn ($value) => "Priority: {$value}");
```

### Complex Custom Filter

```php
BaseFilter::make('advanced_search')
    ->schema([
        TextInput::make('keyword')
            ->placeholder('Search keyword'),
        Select::make('category')
            ->options(Category::pluck('name', 'id')),
        DateRangePicker::make('date_range'),
    ])
    ->query(function ($query, $value) {
        if (!empty($value['keyword'])) {
            $query->where('name', 'like', "%{$value['keyword']}%");
        }
        if (!empty($value['category'])) {
            $query->where('category_id', $value['category']);
        }
        if (!empty($value['date_range'])) {
            $query->whereBetween('created_at', [
                $value['date_range']['start'],
                $value['date_range']['end'],
            ]);
        }
        return $query;
    });
```

---

## Filter Indicators

Filters show active indicators in the toolbar when applied.

### Default Indicator

```php
SelectFilter::make('status')
    ->options([...]);
// Shows: "Status: Published" when filtered
```

### Custom Indicator

```php
SelectFilter::make('status')
    ->options([
        'active' => 'Active',
        'inactive' => 'Inactive',
    ])
    ->indicateUsing(function ($value) {
        return match($value) {
            'active' => 'Showing active items only',
            'inactive' => 'Showing inactive items only',
            default => null,
        };
    });
```

### Multiple Values Indicator

```php
SelectFilter::make('categories')
    ->multiple()
    ->options(Category::pluck('name', 'id'))
    ->indicateUsing(function ($value) {
        $categories = Category::whereIn('id', $value)->pluck('name');
        return 'Categories: ' . $categories->join(', ');
    });
```

---

## Filter Query Logic

### Basic Query

```php
SelectFilter::make('status')
    ->options([...])
    ->query(fn ($query, $value) =>
        $query->where('status', $value)
    );
```

### Multiple Conditions

```php
SelectFilter::make('type')
    ->options([...])
    ->query(function ($query, $value) {
        return match($value) {
            'premium' => $query->where('is_premium', true)
                              ->where('price', '>', 100),
            'basic' => $query->where('is_premium', false),
            default => $query,
        };
    });
```

### Relationship Query

```php
SelectFilter::make('author')
    ->relationship('author', 'name')
    ->query(fn ($query, $value) =>
        $query->whereHas('author', fn ($q) =>
            $q->where('id', $value)
        )
    );
```

---

## Default Filter Values

Set default values to pre-filter tables:

```php
SelectFilter::make('status')
    ->options([...])
    ->default('published');

TernaryFilter::make('is_featured')
    ->default(true);
```

---

## Filter Attribute Mapping

Map filter name to different database column:

```php
SelectFilter::make('category')
    ->attribute('category_id')      // Maps to category_id column
    ->options(Category::pluck('name', 'id'));
```

---

## Complete Example

```php
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Filters\TernaryFilter;
use Laravilt\Tables\Filters\TrashedFilter;
use Laravilt\Tables\Filters\BaseFilter;
use Laravilt\Forms\Components\DateRangePicker;

->filters([
    SelectFilter::make('status')
        ->options([
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ])
        ->default('published')
        ->indicateUsing(fn ($value) => "Status: " . ucfirst($value)),

    SelectFilter::make('category')
        ->relationship('category', 'name')
        ->searchable()
        ->preload()
        ->multiple(),

    SelectFilter::make('author')
        ->options(User::where('role', 'author')->pluck('name', 'id'))
        ->searchable(),

    TernaryFilter::make('is_featured')
        ->label('Featured')
        ->trueLabel('Featured Only')
        ->falseLabel('Not Featured')
        ->placeholderLabel('All Posts'),

    TernaryFilter::make('comments_enabled')
        ->label('Comments')
        ->nullable(),

    BaseFilter::make('date_range')
        ->schema(
            DateRangePicker::make('dates')
                ->label('Published Date')
                ->startFieldName('start_date')
                ->endFieldName('end_date')
        )
        ->query(function ($query, $value) {
            return $query->whereBetween('published_at', [
                $value['start_date'],
                $value['end_date'],
            ]);
        })
        ->indicateUsing(function ($value) {
            return "Published: {$value['start_date']} to {$value['end_date']}";
        }),

    BaseFilter::make('views')
        ->schema([
            TextInput::make('min_views')
                ->numeric()
                ->placeholder('Min views'),
            TextInput::make('max_views')
                ->numeric()
                ->placeholder('Max views'),
        ])
        ->query(function ($query, $value) {
            if (isset($value['min_views'])) {
                $query->where('views', '>=', $value['min_views']);
            }
            if (isset($value['max_views'])) {
                $query->where('views', '<=', $value['max_views']);
            }
            return $query;
        }),

    TrashedFilter::make(),
])
```

---

## Best Practices

### 1. Provide Clear Labels

```php
TernaryFilter::make('is_published')
    ->trueLabel('Published Posts')
    ->falseLabel('Draft Posts')
    ->placeholderLabel('All Posts');
```

### 2. Use Relationships for Foreign Keys

```php
SelectFilter::make('category')
    ->relationship('category', 'name')  // Better than manual options
    ->preload();
```

### 3. Add Search for Long Lists

```php
SelectFilter::make('author')
    ->options(User::pluck('name', 'id'))
    ->searchable();                     // Essential for 100+ options
```

### 4. Set Sensible Defaults

```php
SelectFilter::make('status')
    ->default('active');                // Show active by default
```

### 5. Provide Helpful Indicators

```php
->indicateUsing(fn ($value) => "Filtering by: {$value}");
```

### 6. Optimize Queries

```php
SelectFilter::make('category')
    ->relationship('category', 'name')
    ->query(fn ($query, $value) =>
        $query->whereHas('category', fn ($q) =>
            $q->where('id', $value)
        )
    );
// Better than loading all categories in memory
```

---

## Next Steps

- [Columns](columns.md) - Table column types
- [Actions](actions.md) - Row and bulk actions
- [Introduction](introduction.md) - Table basics
