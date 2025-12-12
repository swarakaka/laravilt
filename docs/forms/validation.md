# Form Validation

Laravilt Forms integrates seamlessly with Laravel's validation system, providing both declarative and programmatic validation.

## Basic Validation

### Using Validation Methods

```php
TextInput::make('name')
    ->required()
    ->maxLength(255);

TextInput::make('email')
    ->required()
    ->email()
    ->unique('users', 'email');

TextInput::make('password')
    ->required()
    ->minLength(8)
    ->confirmed();
```

### Using Rules Method

```php
TextInput::make('username')
    ->rules(['required', 'string', 'min:3', 'max:20', 'alpha_dash']);

// Or as a string
TextInput::make('email')
    ->rules('required|email|unique:users,email');
```

---

## Available Validation Methods

### String Validation

```php
TextInput::make('field')
    ->required()                  // Field is required
    ->nullable()                  // Field can be null
    ->minLength(3)               // Minimum characters
    ->maxLength(255)             // Maximum characters
    ->alpha()                    // Only alphabetic characters
    ->alphaDash()                // Alphabetic, dashes, underscores
    ->alphaNum()                 // Alphanumeric only
    ->ascii()                    // ASCII characters only
    ->regex('/^[A-Z]+$/')        // Must match pattern
    ->notRegex('/[0-9]/');       // Must not match pattern
```

### Email & URL

```php
TextInput::make('email')
    ->email()                    // Valid email format
    ->endsWith(['@company.com']) // Must end with
    ->dns();                     // Valid DNS record

TextInput::make('website')
    ->url()                      // Valid URL
    ->activeUrl()                // URL is accessible
    ->startsWith(['https://']);  // Must start with
```

### Numeric Validation

```php
TextInput::make('age')
    ->numeric()                  // Must be numeric
    ->integer()                  // Must be integer
    ->minValue(18)              // Minimum value
    ->maxValue(120)             // Maximum value
    ->multipleOf(5)             // Must be multiple of
    ->between(1, 100);          // Between range

TextInput::make('price')
    ->numeric()
    ->decimal(2);               // Decimal precision
```

### Date Validation

```php
DatePicker::make('birth_date')
    ->before('today')
    ->after('1900-01-01');

DatePicker::make('start_date')
    ->beforeOrEqual('end_date');

DatePicker::make('end_date')
    ->afterOrEqual('start_date');
```

### Unique & Exists

```php
TextInput::make('email')
    ->unique('users', 'email')
    ->unique(ignoreRecord: true); // Ignore current record on edit

TextInput::make('category_id')
    ->exists('categories', 'id');
```

---

## Custom Validation Rules

### Closure Rules

```php
TextInput::make('username')
    ->rules([
        'required',
        function ($attribute, $value, $fail) {
            if (in_array(strtolower($value), ['admin', 'root', 'system'])) {
                $fail('This username is reserved.');
            }
        },
    ]);
```

### Laravel Rule Objects

```php
use App\Rules\NoSpam;
use Illuminate\Validation\Rules\Password;

TextInput::make('comment')
    ->rules([new NoSpam()]);

TextInput::make('password')
    ->rules([
        Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised(),
    ]);
```

---

## Conditional Validation

### Required If

```php
TextInput::make('company_name')
    ->requiredIf('account_type', 'business');

TextInput::make('vat_number')
    ->requiredWith('company_name');

TextInput::make('phone')
    ->requiredWithout('email');
```

### Dynamic Rules

```php
TextInput::make('discount')
    ->rules(function (Get $get) {
        $rules = ['nullable', 'numeric', 'min:0'];

        if ($get('has_discount')) {
            $rules[] = 'required';
            $rules[] = 'max:' . $get('price');
        }

        return $rules;
    });
```

### Visible/Hidden Validation

Fields that are hidden are automatically excluded from validation:

```php
TextInput::make('tax_id')
    ->required()
    ->hidden(fn (Get $get) => $get('country') !== 'US');
// tax_id is only validated when country is 'US'
```

---

## Validation Messages

### Custom Messages

```php
TextInput::make('email')
    ->required()
    ->email()
    ->validationMessages([
        'required' => 'Please enter your email address.',
        'email' => 'Please enter a valid email address.',
    ]);
```

### Custom Attribute Name

```php
TextInput::make('dob')
    ->validationAttribute('date of birth');

// Error: "The date of birth field is required."
```

---

## File Validation

### File Upload Validation

```php
FileUpload::make('document')
    ->required()
    ->acceptedFileTypes(['application/pdf', '.doc', '.docx'])
    ->maxSize(5120)  // 5MB in KB
    ->minSize(10)    // 10KB minimum;

FileUpload::make('images')
    ->image()
    ->multiple()
    ->minFiles(1)
    ->maxFiles(5);
```

### Image Dimensions

```php
FileUpload::make('avatar')
    ->image()
    ->dimensions([
        'minWidth' => 100,
        'minHeight' => 100,
        'maxWidth' => 2000,
        'maxHeight' => 2000,
        'ratio' => 1, // Square
    ]);
```

---

## Form-Level Validation

### Form Validator Service

```php
use Laravilt\Forms\Services\FormValidator;

// Extract rules from schema
$rules = FormValidator::getRules($schema);

// Validate data
$validator = Validator::make($data, $rules);
```

### Custom Form Validation

```php
// In your controller
public function store(Request $request)
{
    $rules = FormValidator::getRules(
        ProductForm::configure(Schema::make())
    );

    $validated = $request->validate($rules);

    Product::create($validated);
}
```

---

## Real-Time Validation

### Live Validation

```php
TextInput::make('username')
    ->required()
    ->minLength(3)
    ->unique('users', 'username')
    ->live()  // Validate on every change
    ->debounce(300);  // Debounce in milliseconds
```

### Lazy Validation

```php
TextInput::make('email')
    ->required()
    ->email()
    ->unique('users', 'email')
    ->lazy();  // Validate on blur
```

---

## Server-Side Validation

### Resource Validation

In a resource, validation is automatic based on field rules:

```php
// Form fields automatically generate validation rules
TextInput::make('name')
    ->required()
    ->maxLength(255);

// Equivalent to:
// 'name' => ['required', 'string', 'max:255']
```

### API Validation

For API resources, define validation rules in the API class:

```php
class ProductApi
{
    public static function configure(ApiResource $api): ApiResource
    {
        return $api
            ->validationRules([
                'name' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric', 'min:0'],
                'sku' => ['required', 'string', 'unique:products,sku'],
            ])
            ->validationMessages([
                'name.required' => 'Product name is required.',
            ]);
    }
}
```

---

## Error Display

### Field-Level Errors

Errors are automatically displayed below each field:

```vue
<FieldWrapper :errors="errors">
  <TextInput ... />
</FieldWrapper>
```

### Form-Level Errors

```vue
<Form :schema="schema" :errors="$page.props.errors">
  <!-- Fields -->
</Form>
```

### Inertia Integration

Validation errors from Laravel are automatically shared with Inertia:

```php
// Controller
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
    ]);

    // Errors automatically sent back via Inertia
}
```

---

## Best Practices

### 1. Use Declarative Validation

```php
// Preferred: Declarative
TextInput::make('email')
    ->required()
    ->email()
    ->maxLength(255);

// Avoid: String rules
TextInput::make('email')
    ->rules('required|email|max:255');
```

### 2. Group Related Validations

```php
TextInput::make('password')
    ->required()
    ->minLength(8)
    ->confirmed()
    ->validationMessages([
        'required' => 'Password is required.',
        'min' => 'Password must be at least 8 characters.',
        'confirmed' => 'Passwords do not match.',
    ]);
```

### 3. Conditional Validation

```php
TextInput::make('business_number')
    ->requiredIf('account_type', 'business')
    ->hidden(fn (Get $get) => $get('account_type') !== 'business');
```

### 4. Reusable Validation

```php
// Create a rule class
class StrongPassword implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/[A-Z]/', $value)) {
            $fail('Password must contain at least one uppercase letter.');
        }
    }
}

// Use in field
TextInput::make('password')
    ->rules([new StrongPassword()]);
```

---

## Next Steps

- [Layouts](layouts.md) - Form layout components
- [Reactive Fields](reactive-fields.md) - Live field updates
- [Field Types](field-types.md) - All available fields
