# Form Layouts

Laravilt provides powerful layout components for organizing form fields into structured, visually appealing interfaces.

## Overview

Layout components are provided by the **Schemas package** and work seamlessly with form fields:

- **Section** - Collapsible, titled sections
- **Grid** - Responsive multi-column grids
- **Tabs** - Tabbed interface
- **Fieldset** - HTML fieldset grouping
- **Columns** - Two-column layout
- **Split** - Responsive split layout
- **Wizard** - Multi-step forms

All layout components support unlimited nesting and responsive design.

---

## Section

Visually organized container for grouping related fields.

### Basic Section

```php
use Laravilt\Schemas\Components\Section;
use Laravilt\Forms\Components\TextInput;

Section::make('User Information')
    ->description('Basic user details')
    ->schema([
        TextInput::make('name')->required(),
        TextInput::make('email')->email()->required(),
    ]);
```

### Section with Icon

```php
Section::make('Contact Details')
    ->icon('Phone')
    ->description('How to reach the user')
    ->schema([
        TextInput::make('phone'),
        TextInput::make('address'),
    ]);
```

### Collapsible Section

```php
Section::make('Advanced Settings')
    ->description('Optional configuration')
    ->icon('Settings')
    ->collapsible()
    ->collapsed()  // Start collapsed
    ->schema([
        Toggle::make('enable_notifications'),
        Toggle::make('enable_emails'),
    ]);
```

### Section with Columns

```php
Section::make('Personal Information')
    ->columns(2)  // Two-column layout
    ->schema([
        TextInput::make('first_name'),
        TextInput::make('last_name'),
        TextInput::make('email')->columnSpanFull(),
        TextInput::make('phone'),
        TextInput::make('mobile'),
    ]);
```

### Responsive Columns

```php
Section::make('Product Details')
    ->columns([
        'default' => 1,  // 1 column on mobile
        'sm' => 2,       // 2 columns on small screens
        'lg' => 3,       // 3 columns on large screens
    ])
    ->schema([
        TextInput::make('name'),
        TextInput::make('sku'),
        TextInput::make('price'),
    ]);
```

### Section Options

```php
Section::make('name')
    ->heading('Section Title')           // Custom heading
    ->description('Helper text')         // Description below title
    ->icon('User')                       // Lucide icon name
    ->columns(2)                         // Column layout
    ->collapsible()                      // Enable collapse
    ->collapsed(false)                   // Default expanded
    ->visible(fn (Get $get) => ...)     // Conditional visibility
    ->schema([...]);                     // Nested components
```

---

## Grid

Multi-column responsive grid layout.

### Basic Grid

```php
use Laravilt\Schemas\Components\Grid;

Grid::make()
    ->columns(3)
    ->schema([
        TextInput::make('field1'),
        TextInput::make('field2'),
        TextInput::make('field3'),
    ]);
```

### Responsive Grid

```php
Grid::make()
    ->columns([
        'default' => 1,
        'sm' => 2,
        'md' => 3,
        'lg' => 4,
    ])
    ->schema([
        TextInput::make('name')->columnSpan(2),
        TextInput::make('email'),
        TextInput::make('phone'),
    ]);
```

### Column Spanning

```php
Grid::make()
    ->columns(6)
    ->schema([
        TextInput::make('title')->columnSpan(6),        // Full width
        TextInput::make('sku')->columnSpan(2),
        TextInput::make('price')->columnSpan(2),
        TextInput::make('stock')->columnSpan(2),
        Textarea::make('description')->columnSpanFull(), // Full width
    ]);
```

### Nested Grids

```php
Section::make('Product Information')
    ->schema([
        Grid::make()->columns(2)
            ->schema([
                TextInput::make('name'),
                TextInput::make('sku'),
            ]),
        Grid::make()->columns(3)
            ->schema([
                TextInput::make('price'),
                TextInput::make('cost'),
                TextInput::make('stock'),
            ]),
    ]);
```

---

## Tabs

Tabbed interface for organizing content into sections.

### Basic Tabs

```php
use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;

Tabs::make('product_tabs')
    ->tabs([
        Tab::make('details')
            ->label('Details')
            ->schema([
                TextInput::make('name')->required(),
                Textarea::make('description'),
            ]),

        Tab::make('pricing')
            ->label('Pricing')
            ->schema([
                TextInput::make('price')->numeric()->required(),
                TextInput::make('cost')->numeric(),
            ]),

        Tab::make('inventory')
            ->label('Inventory')
            ->schema([
                TextInput::make('sku')->required(),
                TextInput::make('stock_quantity')->numeric(),
            ]),
    ]);
```

### Tabs with Icons

```php
Tabs::make('settings_tabs')
    ->tabs([
        Tab::make('general')
            ->label('General')
            ->icon('Settings')
            ->schema([...]),

        Tab::make('security')
            ->label('Security')
            ->icon('Lock')
            ->schema([...]),

        Tab::make('notifications')
            ->label('Notifications')
            ->icon('Bell')
            ->schema([...]),
    ]);
```

### Tabs with Badges

```php
Tab::make('inventory')
    ->label('Inventory')
    ->icon('Package')
    ->badge(fn ($record) => $record?->low_stock ? 'Low Stock' : null)
    ->schema([
        TextInput::make('stock_quantity'),
    ]);
```

### Persist Tab in URL

```php
Tabs::make('product_tabs')
    ->tabs([...])
    ->persistTabInQueryString();  // Tab state saved in URL
```

### Default Active Tab

```php
Tabs::make('tabs')
    ->tabs([...])
    ->activeTab(1);  // Second tab active by default
```

---

## Fieldset

HTML fieldset for grouping related fields with a legend.

### Basic Fieldset

```php
use Laravilt\Schemas\Components\Fieldset;

Fieldset::make('shipping')
    ->label('Shipping Address')
    ->schema([
        TextInput::make('shipping_street'),
        TextInput::make('shipping_city'),
        TextInput::make('shipping_zip'),
    ]);
```

### Fieldset Options

```php
Fieldset::make('billing')
    ->label('Billing Information')
    ->legend('Enter billing details')  // Alias for label
    ->schema([...]);
```

---

## Columns

Simple two-column layout wrapper.

### Basic Columns

```php
use Laravilt\Schemas\Components\Columns;

Columns::make()
    ->schema([
        TextInput::make('first_name'),
        TextInput::make('last_name'),
    ]);
```

---

## Split

Responsive split layout with customizable column widths.

### Basic Split

```php
use Laravilt\Schemas\Components\Split;

Split::make()
    ->fromBreakpoint('md')  // Split on medium screens and up
    ->startSchema([
        TextInput::make('name'),
        TextInput::make('email'),
    ])
    ->endSchema([
        FileUpload::make('avatar')
            ->image()
            ->avatar(),
    ]);
```

### Custom Column Widths

```php
Split::make()
    ->fromBreakpoint('md')
    ->startColumnSpan('md:col-span-8')  // 8/12 width
    ->endColumnSpan('md:col-span-4')    // 4/12 width
    ->startSchema([
        // Main content (wider)
        TextInput::make('title'),
        RichEditor::make('content'),
    ])
    ->endSchema([
        // Sidebar (narrower)
        Select::make('status'),
        DatePicker::make('published_at'),
    ]);
```

### Left/Right Aliases

```php
Split::make()
    ->fromBreakpoint('lg')
    ->leftSchema([...])   // Alias for startSchema
    ->rightSchema([...])  // Alias for endSchema
```

---

## Wizard

Multi-step form wizard with navigation.

### Basic Wizard

```php
use Laravilt\Schemas\Components\Wizard;
use Laravilt\Schemas\Components\Step;

Wizard::make()
    ->steps([
        Step::make('account')
            ->label('Account')
            ->description('Create your account')
            ->schema([
                TextInput::make('email')->email()->required(),
                TextInput::make('password')->password()->required(),
            ]),

        Step::make('profile')
            ->label('Profile')
            ->description('Complete your profile')
            ->schema([
                TextInput::make('name')->required(),
                FileUpload::make('avatar')->image(),
            ]),

        Step::make('preferences')
            ->label('Preferences')
            ->description('Set your preferences')
            ->schema([
                Select::make('timezone'),
                Toggle::make('notifications'),
            ]),
    ]);
```

### Wizard with Icons

```php
Wizard::make()
    ->steps([
        Step::make('details')
            ->label('Product Details')
            ->description('Basic information')
            ->icon('Package')
            ->schema([...]),

        Step::make('pricing')
            ->label('Pricing')
            ->description('Set prices')
            ->icon('DollarSign')
            ->schema([...]),

        Step::make('images')
            ->label('Images')
            ->description('Upload photos')
            ->icon('Image')
            ->schema([...]),
    ]);
```

### Skippable Wizard

```php
Wizard::make()
    ->steps([...])
    ->skippable();  // Allow skipping optional steps
```

### Custom Button Labels

```php
Wizard::make()
    ->steps([...])
    ->submitButtonLabel('Complete Setup')
    ->nextButtonLabel('Continue')
    ->previousButtonLabel('Go Back');
```

---

## Nested Layouts

Layout components support unlimited nesting for complex forms.

### Example: Nested Layouts

```php
Schema::make()
    ->schema([
        Section::make('Product Information')
            ->description('Enter product details')
            ->icon('Package')
            ->columns(2)
            ->schema([
                TextInput::make('name')->columnSpanFull(),
                TextInput::make('sku'),
                TextInput::make('barcode'),

                Tabs::make('content_tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('description')
                            ->label('Description')
                            ->schema([
                                RichEditor::make('description'),
                            ]),

                        Tab::make('specifications')
                            ->label('Specifications')
                            ->schema([
                                Grid::make()->columns(3)
                                    ->schema([
                                        TextInput::make('weight'),
                                        TextInput::make('height'),
                                        TextInput::make('width'),
                                    ]),
                            ]),
                    ]),
            ]),

        Section::make('Pricing & Inventory')
            ->icon('DollarSign')
            ->collapsible()
            ->schema([
                Split::make()
                    ->fromBreakpoint('md')
                    ->leftSchema([
                        TextInput::make('price')->numeric()->required(),
                        TextInput::make('cost')->numeric(),
                    ])
                    ->rightSchema([
                        TextInput::make('stock_quantity')->numeric(),
                        Toggle::make('track_inventory'),
                    ]),
            ]),
    ]);
```

---

## Responsive Design

### Mobile-First Approach

```php
Grid::make()
    ->columns([
        'default' => 1,  // Stack on mobile
        'sm' => 2,       // 2 columns on small screens
        'lg' => 3,       // 3 columns on large screens
    ])
    ->schema([...]);
```

### Breakpoint Values

| Breakpoint | Min Width |
|------------|-----------|
| `default` | 0px (mobile) |
| `sm` | 640px |
| `md` | 768px |
| `lg` | 1024px |
| `xl` | 1280px |
| `2xl` | 1536px |

### Column Span Responsive

```php
TextInput::make('title')
    ->columnSpan([
        'default' => 12,  // Full width on mobile
        'md' => 8,        // 8/12 on medium screens
        'lg' => 6,        // 6/12 on large screens
    ]);
```

---

## Conditional Layouts

### Conditional Visibility

```php
Section::make('Shipping Details')
    ->visible(fn (Get $get) => $get('requires_shipping'))
    ->schema([
        TextInput::make('shipping_method'),
        TextInput::make('tracking_number'),
    ]);
```

### Dynamic Sections

```php
Section::make('Advanced Options')
    ->heading(fn ($record) => $record ? 'Edit Options' : 'Add Options')
    ->description(fn (Get $get) =>
        $get('is_premium')
            ? 'Premium features available'
            : 'Upgrade for more options'
    )
    ->schema([...]);
```

---

## Best Practices

### 1. Logical Grouping

Group related fields in sections:

```php
Section::make('Personal Information')
    ->schema([
        TextInput::make('first_name'),
        TextInput::make('last_name'),
        TextInput::make('email'),
    ]),

Section::make('Address')
    ->schema([
        TextInput::make('street'),
        TextInput::make('city'),
        TextInput::make('zip'),
    ]);
```

### 2. Use Icons for Visual Hierarchy

```php
Section::make('Account')->icon('User'),
Section::make('Security')->icon('Lock'),
Section::make('Billing')->icon('CreditCard'),
```

### 3. Collapse Advanced Options

```php
Section::make('Advanced Settings')
    ->collapsible()
    ->collapsed()  // Hide by default
    ->schema([...]);
```

### 4. Responsive Layouts

Always consider mobile users:

```php
Grid::make()
    ->columns([
        'default' => 1,  // Stack on mobile
        'md' => 2,       // Side-by-side on tablets+
    ])
    ->schema([...]);
```

### 5. Provide Descriptions

Help users understand sections:

```php
Section::make('API Configuration')
    ->description('Configure external API integrations')
    ->schema([...]);
```

### 6. Use Wizards for Complex Flows

Break multi-page forms into steps:

```php
Wizard::make()
    ->steps([
        Step::make('basics')->label('Basic Info'),
        Step::make('details')->label('Details'),
        Step::make('review')->label('Review'),
    ]);
```

---

## Layout Component Reference

| Component | Purpose | Key Features |
|-----------|---------|--------------|
| **Section** | Group related fields | Collapsible, icons, descriptions |
| **Grid** | Multi-column layout | Responsive, column spanning |
| **Tabs** | Tabbed interface | Icons, badges, URL persistence |
| **Fieldset** | HTML fieldset | Legend, semantic grouping |
| **Columns** | Two-column layout | Simple wrapper |
| **Split** | Responsive split | Custom widths, breakpoints |
| **Wizard** | Multi-step forms | Navigation, progress, icons |

---

## Complete Example

```php
use Laravilt\Schemas\Schema;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Components\Grid;
use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Textarea;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Forms\Components\FileUpload;

Schema::make()
    ->schema([
        Section::make('Basic Information')
            ->description('Enter product details')
            ->icon('Package')
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('sku')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
            ]),

        Tabs::make('product_content')
            ->tabs([
                Tab::make('description')
                    ->label('Description')
                    ->icon('FileText')
                    ->schema([
                        Textarea::make('short_description')
                            ->rows(3),

                        RichEditor::make('description')
                            ->toolbarButtons(['bold', 'italic', 'link']),
                    ]),

                Tab::make('media')
                    ->label('Media')
                    ->icon('Image')
                    ->schema([
                        FileUpload::make('images')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->reorderable(),
                    ]),
            ]),

        Section::make('Pricing & Inventory')
            ->icon('DollarSign')
            ->columns(3)
            ->schema([
                TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->required(),

                TextInput::make('cost')
                    ->numeric()
                    ->prefix('$'),

                TextInput::make('stock_quantity')
                    ->numeric()
                    ->default(0),
            ]),

        Section::make('Settings')
            ->icon('Settings')
            ->collapsible()
            ->collapsed()
            ->schema([
                Grid::make()->columns(2)
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),

                        Toggle::make('is_featured')
                            ->label('Featured'),

                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft'),
                    ]),
            ]),
    ]);
```

---

## Next Steps

- [Reactive Fields](reactive-fields.md) - Dynamic field interactions
- [Validation](validation.md) - Form validation rules
- [Field Types](field-types.md) - All available fields
