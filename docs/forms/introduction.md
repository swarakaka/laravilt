# Forms Introduction

The Forms package provides a powerful, declarative form builder for creating interactive forms with validation, file uploads, and reactive fields.

## Overview

Laravilt Forms offers:

- **30+ Field Types** - Text, select, date, file upload, rich editor, and more
- **Declarative Schema** - Define forms using PHP fluent syntax
- **Automatic Validation** - Laravel validation rules integration
- **Reactive Fields** - Live updates and field dependencies
- **Layout Components** - Sections, grids, tabs, wizards
- **File Uploads** - Advanced file handling with image editing
- **Vue Integration** - Seamless frontend rendering

## Basic Usage

### Defining a Form

```php
use Laravilt\Schemas\Schema;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\Toggle;
use Laravilt\Forms\Components\Section;

public static function form(Schema $form): Schema
{
    return $form
        ->schema([
            Section::make('User Information')
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
                            'editor' => 'Editor',
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

### Form Configuration

```php
$form
    // Form ID
    ->id('user-form')

    // Form action URL
    ->action('/users')

    // HTTP method
    ->method('POST')

    // Disable entire form
    ->disabled()

    // Form layout columns
    ->columns(2)

    // Form schema
    ->schema([...]);
```

---

## Field Types

### Basic Input Fields

| Field | Description |
|-------|-------------|
| `TextInput` | Single-line text (email, password, tel, url, search) |
| `Textarea` | Multi-line text |
| `NumberField` | Numeric input |
| `Hidden` | Hidden field |

### Selection Fields

| Field | Description |
|-------|-------------|
| `Select` | Dropdown with searchable, multiple, relationship |
| `Radio` | Radio button group |
| `Checkbox` | Single checkbox |
| `CheckboxList` | Multiple checkboxes |
| `Toggle` | Boolean toggle switch |
| `ToggleButtons` | Button-style toggles |

### Date & Time Fields

| Field | Description |
|-------|-------------|
| `DatePicker` | Date selection |
| `DateTimePicker` | Date and time |
| `TimePicker` | Time only |
| `DateRangePicker` | Date range |

### Advanced Fields

| Field | Description |
|-------|-------------|
| `FileUpload` | File/image upload with editing |
| `RichEditor` | WYSIWYG HTML editor |
| `MarkdownEditor` | Markdown editor |
| `CodeEditor` | Code with syntax highlighting |
| `ColorPicker` | Color selection |
| `IconPicker` | Icon selection |
| `TagsInput` | Multi-tag input |
| `KeyValue` | Key-value pairs |
| `Slider` | Range slider |
| `RateInput` | Star rating |

### Complex Fields

| Field | Description |
|-------|-------------|
| `Repeater` | Repeating field groups |
| `Builder` | Block builder with drag-and-drop |

---

## Layout Components

### Section

Group related fields:

```php
Section::make('Contact Information')
    ->description('How to reach the user')
    ->icon('Phone')
    ->collapsible()
    ->collapsed()
    ->schema([
        TextInput::make('phone'),
        TextInput::make('address'),
    ])
    ->columns(2);
```

### Grid

Column-based layout:

```php
Grid::make()
    ->columns([
        'default' => 1,
        'sm' => 2,
        'md' => 3,
        'lg' => 4,
    ])
    ->schema([
        TextInput::make('field1'),
        TextInput::make('field2'),
        TextInput::make('field3'),
        TextInput::make('field4'),
    ]);
```

### Tabs

Tabbed interface:

```php
Tabs::make()
    ->tabs([
        Tab::make('basic')
            ->label('Basic Info')
            ->icon('User')
            ->schema([...]),
        Tab::make('advanced')
            ->label('Advanced')
            ->schema([...]),
    ])
    ->persistTabInQueryString();
```

### Wizard

Multi-step form:

```php
Wizard::make()
    ->steps([
        Step::make('account')
            ->label('Account')
            ->description('Create your account')
            ->schema([...]),
        Step::make('profile')
            ->label('Profile')
            ->description('Complete your profile')
            ->schema([...]),
    ]);
```

---

## Common Field Methods

All fields share these methods:

```php
TextInput::make('name')
    // Label & help
    ->label('Full Name')
    ->helperText('Enter your legal name')
    ->hint('As shown on ID')

    // States
    ->required()
    ->disabled()
    ->readonly()
    ->hidden()
    ->visible()

    // Default value
    ->default('John Doe')

    // Placeholder
    ->placeholder('Enter name...')

    // Column span in grid
    ->columnSpan(2)
    ->columnSpanFull()

    // Validation
    ->rules(['required', 'string', 'max:255'])

    // Reactivity
    ->live()
    ->lazy();
```

---

## Validation

### Built-in Validation Methods

```php
TextInput::make('email')
    ->required()
    ->email()
    ->unique('users', 'email', ignoreRecord: true)
    ->maxLength(255);

TextInput::make('age')
    ->numeric()
    ->integer()
    ->minValue(18)
    ->maxValue(120);

TextInput::make('website')
    ->url()
    ->startsWith('https://');

TextInput::make('password')
    ->password()
    ->minLength(8)
    ->confirmed();
```

### Custom Validation Rules

```php
TextInput::make('username')
    ->rules([
        'required',
        'string',
        'min:3',
        'max:20',
        'alpha_dash',
        'unique:users,username',
        function ($attribute, $value, $fail) {
            if (in_array(strtolower($value), ['admin', 'root'])) {
                $fail('This username is reserved.');
            }
        },
    ]);
```

### Validation Messages

```php
TextInput::make('email')
    ->required()
    ->email()
    ->validationMessages([
        'required' => 'Please enter your email address.',
        'email' => 'Please enter a valid email address.',
    ]);
```

---

## Reactive Fields

### Live Updates

```php
// Update immediately on change
TextInput::make('name')
    ->live()
    ->afterStateUpdated(function ($state, $set) {
        $set('slug', Str::slug($state));
    });

// Update with debounce
TextInput::make('search')
    ->live(debounce: 500);

// Update on blur
TextInput::make('title')
    ->lazy();
```

### Field Dependencies

```php
Select::make('country')
    ->options(['US' => 'USA', 'CA' => 'Canada'])
    ->live(),

Select::make('state')
    ->options(fn (Get $get) => match ($get('country')) {
        'US' => ['CA' => 'California', 'NY' => 'New York'],
        'CA' => ['ON' => 'Ontario', 'BC' => 'British Columbia'],
        default => [],
    })
    ->dependsOn('country');
```

---

## Configuration

### Publishing Config

```bash
php artisan vendor:publish --tag=laravilt-forms-config
```

### Configuration Options

```php
// config/laravilt-forms.php
return [
    // File upload settings
    'file_upload' => [
        'disk' => 'public',
        'directory' => 'uploads',
        'max_size' => 10240, // 10MB
    ],

    // Rich editor settings
    'rich_editor' => [
        'toolbar' => ['bold', 'italic', 'heading', 'link', 'list'],
    ],
];
```

---

## Dependencies

The Forms package requires:

| Package | Purpose |
|---------|---------|
| **laravilt/support** | Base components and traits |
| **laravilt/schemas** | Layout components |
| **laravilt/actions** | Form actions |

---

## Next Steps

- [Field Types](field-types.md) - All available field types
- [Validation](validation.md) - Form validation
- [Layouts](layouts.md) - Layout components
- [Reactive Fields](reactive-fields.md) - Live updates
- [Custom Fields](custom-fields.md) - Create custom fields
