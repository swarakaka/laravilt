# Reactive Fields

Laravilt forms support reactive fields that update dynamically based on other field values, enabling complex field interactions and dependencies.

## Overview

Reactive features include:

- **Live Updates** - Fields that update on every change
- **Lazy Updates** - Fields that update on blur
- **Field Dependencies** - Fields that react to other fields
- **AfterStateUpdated** - Callbacks when field values change
- **Get/Set Utilities** - Access and modify field values
- **Conditional Visibility** - Show/hide fields based on values
- **Dynamic Options** - Update select options dynamically

---

## Live Updates

### Basic Live Field

```php
TextInput::make('name')
    ->live();  // Updates immediately on every change
```

### Live with Debounce

```php
TextInput::make('search')
    ->live(debounce: 500);  // Wait 500ms after typing stops
```

### Lazy Updates (On Blur)

```php
TextInput::make('email')
    ->lazy();  // Updates when field loses focus
```

---

## Field Dependencies

### Get Utility

Access other field values using the `Get` utility:

```php
use Laravilt\Support\Utilities\Get;

Select::make('state')
    ->options(fn (Get $get) => match($get('country')) {
        'US' => [
            'CA' => 'California',
            'NY' => 'New York',
            'TX' => 'Texas',
        ],
        'CA' => [
            'ON' => 'Ontario',
            'BC' => 'British Columbia',
            'QC' => 'Quebec',
        ],
        default => [],
    })
    ->dependsOn('country');
```

### Depends On

Mark explicit dependencies to trigger re-evaluation:

```php
Select::make('state')
    ->options(fn (Get $get) => $this->getStatesForCountry($get('country')))
    ->dependsOn('country');  // Re-evaluates when 'country' changes
```

### Multiple Dependencies

```php
TextInput::make('total')
    ->numeric()
    ->prefix('$')
    ->default(fn (Get $get) => $get('price') * $get('quantity'))
    ->dependsOn(['price', 'quantity']);
```

---

## After State Updated

Execute callbacks when field values change:

### Basic Callback

```php
use Laravilt\Support\Utilities\Set;

TextInput::make('name')
    ->live()
    ->afterStateUpdated(function ($state, Set $set) {
        $set('slug', Str::slug($state));
    });
```

### With Get and Set

```php
TextInput::make('price')
    ->numeric()
    ->live(debounce: 300)
    ->afterStateUpdated(function ($state, Get $get, Set $set) {
        $quantity = $get('quantity') ?? 1;
        $set('total', $state * $quantity);
    });

TextInput::make('quantity')
    ->numeric()
    ->live(debounce: 300)
    ->afterStateUpdated(function ($state, Get $get, Set $set) {
        $price = $get('price') ?? 0;
        $set('total', $state * $price);
    });
```

### Access Current Record

```php
TextInput::make('discount_percentage')
    ->numeric()
    ->live()
    ->afterStateUpdated(function ($state, Get $get, Set $set, $record) {
        $price = $record?->price ?? $get('price');
        $discountAmount = $price * ($state / 100);
        $set('final_price', $price - $discountAmount);
    });
```

---

## Conditional Visibility

### Show/Hide Based on Values

```php
Toggle::make('requires_shipping')
    ->live();

Section::make('Shipping Details')
    ->visible(fn (Get $get) => $get('requires_shipping'))
    ->schema([
        TextInput::make('shipping_method'),
        TextInput::make('tracking_number'),
    ]);
```

### Multiple Conditions

```php
TextInput::make('tax_id')
    ->visible(fn (Get $get) =>
        $get('country') === 'US' &&
        $get('account_type') === 'business'
    );
```

### Hidden Instead of Visible

```php
TextInput::make('discount_code')
    ->hidden(fn (Get $get) => $get('total') < 100);
```

---

## Dynamic Options

### Select Options Based on Another Field

```php
Select::make('country')
    ->options([
        'US' => 'United States',
        'CA' => 'Canada',
        'UK' => 'United Kingdom',
    ])
    ->live();

Select::make('state')
    ->options(fn (Get $get) => match($get('country')) {
        'US' => [
            'CA' => 'California',
            'NY' => 'New York',
            'TX' => 'Texas',
        ],
        'CA' => [
            'ON' => 'Ontario',
            'BC' => 'British Columbia',
        ],
        'UK' => [
            'EN' => 'England',
            'SC' => 'Scotland',
            'WA' => 'Wales',
        ],
        default => [],
    })
    ->dependsOn('country')
    ->visible(fn (Get $get) => filled($get('country')));
```

### Database-Driven Options

```php
Select::make('category_id')
    ->options(Category::pluck('name', 'id'))
    ->live();

Select::make('subcategory_id')
    ->options(fn (Get $get) =>
        Subcategory::where('category_id', $get('category_id'))
            ->pluck('name', 'id')
    )
    ->dependsOn('category_id')
    ->visible(fn (Get $get) => filled($get('category_id')));
```

---

## Disabled/Required States

### Dynamic Disabled State

```php
TextInput::make('discount_code')
    ->disabled(fn (Get $get) => $get('total') < 50);
```

### Dynamic Required State

```php
TextInput::make('company_name')
    ->required(fn (Get $get) => $get('account_type') === 'business');
```

### Required If

```php
TextInput::make('vat_number')
    ->requiredIf('country', 'UK');
```

### Required With

```php
TextInput::make('phone')
    ->requiredWith('address');  // Required if address is filled
```

### Required Without

```php
TextInput::make('phone')
    ->requiredWithout('email');  // Required if email is empty
```

---

## Complex Examples

### Shopping Cart Total

```php
use Laravilt\Forms\Components\Repeater;

Repeater::make('items')
    ->schema([
        Select::make('product_id')
            ->options(Product::pluck('name', 'id'))
            ->live()
            ->afterStateUpdated(function ($state, Set $set) {
                $product = Product::find($state);
                $set('price', $product?->price ?? 0);
                $set('subtotal', $product?->price ?? 0);
            }),

        NumberField::make('quantity')
            ->default(1)
            ->minValue(1)
            ->live(debounce: 300)
            ->afterStateUpdated(function ($state, Get $get, Set $set) {
                $price = $get('price') ?? 0;
                $set('subtotal', $price * $state);
            }),

        TextInput::make('price')
            ->numeric()
            ->prefix('$')
            ->disabled(),

        TextInput::make('subtotal')
            ->numeric()
            ->prefix('$')
            ->disabled(),
    ])
    ->columns(4)
    ->afterStateUpdated(function ($state, Set $set) {
        $total = collect($state)->sum('subtotal');
        $set('total', $total);
    });

TextInput::make('total')
    ->numeric()
    ->prefix('$')
    ->disabled();
```

### Address Autocomplete

```php
TextInput::make('zip_code')
    ->live(debounce: 500)
    ->afterStateUpdated(function ($state, Set $set) {
        $location = Http::get("https://api.zippopotam.us/us/{$state}")->json();

        if ($location) {
            $set('city', $location['places'][0]['place name'] ?? null);
            $set('state', $location['places'][0]['state abbreviation'] ?? null);
        }
    });

TextInput::make('city');
TextInput::make('state');
```

### Conditional Pricing

```php
Select::make('customer_type')
    ->options([
        'regular' => 'Regular',
        'wholesale' => 'Wholesale',
        'vip' => 'VIP',
    ])
    ->live();

TextInput::make('price')
    ->numeric()
    ->prefix('$')
    ->live(debounce: 300);

TextInput::make('final_price')
    ->numeric()
    ->prefix('$')
    ->disabled()
    ->default(fn (Get $get) => match($get('customer_type')) {
        'wholesale' => $get('price') * 0.7,  // 30% off
        'vip' => $get('price') * 0.5,        // 50% off
        default => $get('price'),
    })
    ->helperText(fn (Get $get) => match($get('customer_type')) {
        'wholesale' => '30% wholesale discount applied',
        'vip' => '50% VIP discount applied',
        default => 'Regular pricing',
    });
```

### Dynamic Validation

```php
TextInput::make('email')
    ->email()
    ->rules(fn (Get $get) => [
        'required',
        'email',
        $get('account_type') === 'business'
            ? 'email:rfc,dns'  // Stricter validation for business
            : 'email:rfc',
    ]);
```

---

## Slug Generation

Auto-generate slugs from titles:

```php
TextInput::make('title')
    ->required()
    ->live(debounce: 300)
    ->afterStateUpdated(function ($state, Set $set) {
        $set('slug', Str::slug($state));
    });

TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true);
```

---

## Nested Dot Notation

Access nested values using dot notation:

```php
TextInput::make('address.street')
    ->live();

TextInput::make('full_address')
    ->default(fn (Get $get) =>
        $get('address.street') . ', ' .
        $get('address.city') . ', ' .
        $get('address.state')
    );
```

---

## Repeater Field Dependencies

### Dependencies Within Repeater

```php
Repeater::make('line_items')
    ->schema([
        Select::make('product_id')
            ->options(Product::pluck('name', 'id'))
            ->live()
            ->afterStateUpdated(function ($state, Set $set) {
                $product = Product::find($state);
                $set('unit_price', $product?->price);
            }),

        NumberField::make('quantity')
            ->default(1)
            ->live(debounce: 300),

        TextInput::make('unit_price')
            ->numeric()
            ->prefix('$'),

        TextInput::make('line_total')
            ->numeric()
            ->prefix('$')
            ->disabled()
            ->default(fn (Get $get) =>
                $get('quantity') * $get('unit_price')
            ),
    ]);
```

---

## Performance Optimization

### Use Debounce

Avoid excessive updates:

```php
TextInput::make('search')
    ->live(debounce: 500);  // Wait 500ms after typing
```

### Use Lazy Instead of Live

For non-critical updates:

```php
TextInput::make('title')
    ->lazy()  // Update on blur only
    ->afterStateUpdated(fn ($state, Set $set) =>
        $set('slug', Str::slug($state))
    );
```

### Mark Dependencies Explicitly

```php
Select::make('category')
    ->options(...)
    ->dependsOn('parent_category');  // Only re-evaluate when parent changes
```

---

## Get Utility Methods

```php
// Get single value
$get('field_name')

// Get nested value
$get('address.city')

// Get with default
$get('optional_field') ?? 'default'

// Check if filled
filled($get('field_name'))
blank($get('field_name'))
```

---

## Set Utility Methods

```php
// Set single value
$set('field_name', 'value')

// Set nested value
$set('address.city', 'New York')

// Set multiple values
$set('price', 100);
$set('tax', 10);
$set('total', 110);
```

---

## Best Practices

### 1. Use Debounce for Text Fields

```php
TextInput::make('search')
    ->live(debounce: 500);  // Better than live() alone
```

### 2. Mark Dependencies Explicitly

```php
Select::make('state')
    ->options(fn (Get $get) => ...)
    ->dependsOn('country');  // Explicit dependency
```

### 3. Validate Before Using Values

```php
TextInput::make('discount')
    ->afterStateUpdated(function ($state, Get $get, Set $set) {
        $total = $get('total');

        if (is_numeric($total) && is_numeric($state)) {
            $set('final_total', $total - $state);
        }
    });
```

### 4. Use Lazy for Slug Generation

```php
TextInput::make('title')
    ->lazy()  // On blur is better than live() for slugs
    ->afterStateUpdated(fn ($state, Set $set) =>
        $set('slug', Str::slug($state))
    );
```

### 5. Provide Visual Feedback

```php
TextInput::make('final_price')
    ->disabled()  // Visual cue it's calculated
    ->helperText('Automatically calculated from price and discount');
```

---

## Common Patterns

### Calculate Totals

```php
TextInput::make('subtotal')
    ->numeric()
    ->live(debounce: 300);

TextInput::make('tax_rate')
    ->numeric()
    ->suffix('%')
    ->live(debounce: 300);

TextInput::make('total')
    ->numeric()
    ->disabled()
    ->default(fn (Get $get) => {
        $subtotal = $get('subtotal') ?? 0;
        $taxRate = $get('tax_rate') ?? 0;
        return $subtotal + ($subtotal * $taxRate / 100);
    });
```

### Conditional Required Fields

```php
Select::make('payment_method')
    ->options([
        'credit_card' => 'Credit Card',
        'bank_transfer' => 'Bank Transfer',
    ])
    ->live();

TextInput::make('card_number')
    ->required(fn (Get $get) => $get('payment_method') === 'credit_card')
    ->visible(fn (Get $get) => $get('payment_method') === 'credit_card');

TextInput::make('bank_account')
    ->required(fn (Get $get) => $get('payment_method') === 'bank_transfer')
    ->visible(fn (Get $get) => $get('payment_method') === 'bank_transfer');
```

### Copy Values Between Fields

```php
Toggle::make('billing_same_as_shipping')
    ->live()
    ->afterStateUpdated(function ($state, Get $get, Set $set) {
        if ($state) {
            $set('billing_street', $get('shipping_street'));
            $set('billing_city', $get('shipping_city'));
            $set('billing_zip', $get('shipping_zip'));
        }
    });
```

---

## Next Steps

- [Validation](validation.md) - Form validation rules
- [Layouts](layouts.md) - Form layout components
- [Field Types](field-types.md) - All available fields
