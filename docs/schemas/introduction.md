# Schemas Introduction

The Schemas package provides layout components for organizing form fields and infolist entries into structured, visually appealing interfaces.

## Overview

Schemas are the foundation for organizing components in:

- **Forms** - Structure form fields with sections, tabs, and grids
- **Infolists** - Display read-only data with organized layouts
- **Pages** - Create complex page layouts

The Schemas package provides:

- **Section** - Collapsible sections with headings
- **Grid** - Responsive multi-column layouts
- **Tabs** - Tabbed interfaces
- **Fieldset** - HTML fieldset grouping
- **Columns** - Two-column layouts
- **Split** - Responsive split layouts
- **Wizard** - Multi-step workflows
- **Step** - Individual wizard steps

---

## Basic Usage

### Simple Schema

```php
use Laravilt\Schemas\Schema;
use Laravilt\Schemas\Components\Section;
use Laravilt\Forms\Components\TextInput;

Schema::make()
    ->schema([
        Section::make('User Information')
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
            ]),
    ]);
```

### Schema with Multiple Sections

```php
Schema::make()
    ->schema([
        Section::make('Basic Information')
            ->description('Enter basic details')
            ->icon('User')
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
            ]),

        Section::make('Address')
            ->description('Enter your address')
            ->icon('MapPin')
            ->collapsible()
            ->schema([
                TextInput::make('street'),
                TextInput::make('city'),
                TextInput::make('zip'),
            ]),
    ]);
```

---

## Section Component

Visually organized container with heading, description, and icon.

### Basic Section

```php
use Laravilt\Schemas\Components\Section;

Section::make('Contact Details')
    ->description('How to reach you')
    ->icon('Phone')
    ->schema([
        TextInput::make('phone'),
        TextInput::make('email'),
    ]);
```

### Collapsible Section

```php
Section::make('Advanced Settings')
    ->description('Optional configuration')
    ->collapsible()
    ->collapsed()  // Start collapsed
    ->schema([
        Toggle::make('enable_notifications'),
        Toggle::make('enable_emails'),
    ]);
```

### Section with Columns

```php
Section::make('Personal Details')
    ->columns(2)  // Two-column layout
    ->schema([
        TextInput::make('first_name'),
        TextInput::make('last_name'),
        TextInput::make('email')->columnSpanFull(),
    ]);
```

### Responsive Columns

```php
Section::make('Product Details')
    ->columns([
        'default' => 1,  // 1 column on mobile
        'sm' => 2,       // 2 columns on tablets
        'lg' => 3,       // 3 columns on desktop
    ])
    ->schema([...]);
```

---

## Grid Component

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

---

## Tabs Component

Organize content into tabbed sections.

### Basic Tabs

```php
use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;

Tabs::make('product_tabs')
    ->tabs([
        Tab::make('details')
            ->label('Details')
            ->schema([
                TextInput::make('name'),
                Textarea::make('description'),
            ]),

        Tab::make('pricing')
            ->label('Pricing')
            ->schema([
                TextInput::make('price'),
                TextInput::make('cost'),
            ]),
    ]);
```

### Tabs with Icons and Badges

```php
Tabs::make('tabs')
    ->tabs([
        Tab::make('general')
            ->label('General')
            ->icon('Settings')
            ->schema([...]),

        Tab::make('inventory')
            ->label('Inventory')
            ->icon('Package')
            ->badge(fn ($record) => $record?->low_stock ? 'Low' : null)
            ->schema([...]),
    ]);
```

### Persist Tab in URL

```php
Tabs::make('tabs')
    ->tabs([...])
    ->persistTabInQueryString();
```

---

## Wizard Component

Multi-step form workflow.

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
    ]);
```

### Wizard with Icons

```php
Wizard::make()
    ->steps([
        Step::make('details')
            ->label('Details')
            ->icon('Package')
            ->schema([...]),

        Step::make('pricing')
            ->label('Pricing')
            ->icon('DollarSign')
            ->schema([...]),
    ]);
```

### Skippable Wizard

```php
Wizard::make()
    ->steps([...])
    ->skippable()
    ->submitButtonLabel('Complete')
    ->nextButtonLabel('Continue')
    ->previousButtonLabel('Back');
```

---

## Split Component

Responsive split layout with customizable widths.

### Basic Split

```php
use Laravilt\Schemas\Components\Split;

Split::make()
    ->fromBreakpoint('md')
    ->startSchema([
        TextInput::make('name'),
        TextInput::make('email'),
    ])
    ->endSchema([
        FileUpload::make('avatar')->image(),
    ]);
```

### Custom Column Widths

```php
Split::make()
    ->fromBreakpoint('md')
    ->startColumnSpan('md:col-span-8')
    ->endColumnSpan('md:col-span-4')
    ->startSchema([...])
    ->endSchema([...]);
```

---

## Fieldset Component

HTML fieldset for semantic grouping.

### Basic Fieldset

```php
use Laravilt\Schemas\Components\Fieldset;

Fieldset::make('shipping')
    ->label('Shipping Address')
    ->schema([
        TextInput::make('shipping_street'),
        TextInput::make('shipping_city'),
    ]);
```

---

## Columns Component

Simple two-column wrapper.

```php
use Laravilt\Schemas\Components\Columns;

Columns::make()
    ->schema([
        TextInput::make('first_name'),
        TextInput::make('last_name'),
    ]);
```

---

## Nested Layouts

Schemas support unlimited nesting for complex interfaces:

```php
Schema::make()
    ->schema([
        Section::make('Product Information')
            ->columns(2)
            ->schema([
                TextInput::make('name')->columnSpanFull(),
                TextInput::make('sku'),
                TextInput::make('price'),

                Tabs::make('content')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('description')
                            ->schema([
                                RichEditor::make('description'),
                            ]),

                        Tab::make('specs')
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

        Section::make('Pricing')
            ->collapsible()
            ->schema([
                Split::make()
                    ->startSchema([
                        TextInput::make('price'),
                        TextInput::make('cost'),
                    ])
                    ->endSchema([
                        TextInput::make('stock'),
                        Toggle::make('track_inventory'),
                    ]),
            ]),
    ]);
```

---

## Schema Methods

### Data Filling

```php
$schema = Schema::make()
    ->schema([...])
    ->fill(['name' => 'John', 'email' => 'john@example.com']);
```

### Column Configuration

```php
$schema = Schema::make()
    ->columns(2)  // Global column layout
    ->schema([...]);
```

### Validation Extraction

```php
$rules = $schema->getValidationRules();
$messages = $schema->getValidationMessages();
$attributes = $schema->getValidationAttributes();
```

---

## Responsive Design

All layout components support responsive breakpoints:

```php
// Tailwind breakpoints
'default' => 1,  // 0px (mobile)
'sm' => 2,       // 640px
'md' => 3,       // 768px
'lg' => 4,       // 1024px
'xl' => 5,       // 1280px
'2xl' => 6,      // 1536px
```

### Example

```php
Grid::make()
    ->columns([
        'default' => 1,  // Stack on mobile
        'md' => 2,       // 2 columns on tablets
        'lg' => 3,       // 3 columns on desktop
    ])
    ->schema([...]);
```

---

## Component Reference

| Component | Purpose | Key Features |
|-----------|---------|--------------|
| **Section** | Group fields | Collapsible, icons, columns |
| **Grid** | Multi-column | Responsive, column spanning |
| **Tabs** | Tabbed interface | Icons, badges, persistence |
| **Wizard** | Multi-step | Navigation, skippable steps |
| **Split** | Two-column split | Responsive, custom widths |
| **Fieldset** | HTML fieldset | Semantic grouping |
| **Columns** | Simple two-column | Basic wrapper |
| **Step** | Wizard step | Labels, icons, descriptions |
| **Tab** | Tab panel | Labels, icons, badges |

---

## Best Practices

### 1. Logical Grouping

```php
Section::make('Personal Information')
    ->schema([...]),

Section::make('Address Information')
    ->schema([...]),
```

### 2. Use Icons for Visual Hierarchy

```php
Section::make('Account')->icon('User'),
Section::make('Security')->icon('Lock'),
```

### 3. Collapse Advanced Options

```php
Section::make('Advanced')
    ->collapsible()
    ->collapsed()
    ->schema([...]);
```

### 4. Mobile-First Responsive

```php
Grid::make()
    ->columns([
        'default' => 1,  // Mobile first
        'md' => 2,
    ]);
```

### 5. Provide Descriptions

```php
Section::make('Billing')
    ->description('Configure billing settings')
    ->schema([...]);
```

---

## Complete Example

```php
use Laravilt\Schemas\Schema;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;
use Laravilt\Schemas\Components\Grid;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Textarea;
use Laravilt\Forms\Components\FileUpload;

Schema::make()
    ->schema([
        Section::make('Basic Information')
            ->description('Product details')
            ->icon('Package')
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('sku')->required(),
                TextInput::make('slug')->required(),
            ]),

        Tabs::make('content')
            ->tabs([
                Tab::make('description')
                    ->label('Description')
                    ->icon('FileText')
                    ->schema([
                        Textarea::make('short_description'),
                        RichEditor::make('description'),
                    ]),

                Tab::make('media')
                    ->label('Media')
                    ->icon('Image')
                    ->schema([
                        FileUpload::make('images')
                            ->multiple()
                            ->image(),
                    ]),
            ]),

        Section::make('Pricing & Inventory')
            ->icon('DollarSign')
            ->columns(3)
            ->schema([
                TextInput::make('price')->numeric()->prefix('$'),
                TextInput::make('cost')->numeric()->prefix('$'),
                TextInput::make('stock')->numeric(),
            ]),

        Section::make('Settings')
            ->collapsible()
            ->collapsed()
            ->schema([
                Grid::make()->columns(2)
                    ->schema([
                        Toggle::make('is_active'),
                        Toggle::make('is_featured'),
                    ]),
            ]),
    ]);
```

---

## Next Steps

- [Forms Layouts](../forms/layouts.md) - Using schemas in forms
- [Infolists](../infolists/introduction.md) - Using schemas for data display
