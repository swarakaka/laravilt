# Field Types

Complete reference for all form field types available in Laravilt.

## Text Input

Single-line text input with various types.

```php
use Laravilt\Forms\Components\TextInput;

// Basic text
TextInput::make('name')
    ->label('Full Name')
    ->placeholder('Enter your name')
    ->required()
    ->maxLength(255);

// Email
TextInput::make('email')
    ->email()
    ->autocomplete('email');

// Password
TextInput::make('password')
    ->password()
    ->autocomplete('new-password')
    ->revealable(); // Show/hide toggle

// URL
TextInput::make('website')
    ->url()
    ->prefix('https://');

// Phone
TextInput::make('phone')
    ->tel()
    ->mask('(999) 999-9999');

// Search
TextInput::make('search')
    ->search()
    ->live(debounce: 300);
```

### TextInput Options

```php
TextInput::make('field')
    // Input type
    ->type('text') // text, email, password, tel, url, search

    // Affixes
    ->prefix('$')
    ->suffix('.00')
    ->prefixIcon('DollarSign')
    ->suffixIcon('Info')

    // Character limits
    ->minLength(3)
    ->maxLength(100)
    ->characterCount() // Show character count

    // Input mask
    ->mask('999-99-9999') // SSN format

    // Autocomplete
    ->autocomplete('email')

    // Read-only with copy
    ->readOnly()
    ->copyable();
```

---

## Textarea

Multi-line text input.

```php
use Laravilt\Forms\Components\Textarea;

Textarea::make('description')
    ->label('Description')
    ->rows(5)
    ->minLength(10)
    ->maxLength(1000)
    ->characterCount()
    ->autosize(); // Auto-expand
```

---

## Number Field

Numeric input with controls.

```php
use Laravilt\Forms\Components\NumberField;

NumberField::make('quantity')
    ->label('Quantity')
    ->minValue(1)
    ->maxValue(100)
    ->step(1)
    ->default(1);

NumberField::make('price')
    ->label('Price')
    ->prefix('$')
    ->minValue(0)
    ->maxValue(99999.99)
    ->step(0.01);
```

---

## Select

Dropdown selection with advanced features.

```php
use Laravilt\Forms\Components\Select;

// Basic select
Select::make('country')
    ->label('Country')
    ->options([
        'us' => 'United States',
        'ca' => 'Canada',
        'uk' => 'United Kingdom',
    ])
    ->required();

// Searchable
Select::make('user_id')
    ->label('User')
    ->options(User::pluck('name', 'id'))
    ->searchable()
    ->preload();

// Multiple selection
Select::make('tags')
    ->label('Tags')
    ->multiple()
    ->options(Tag::pluck('name', 'id'))
    ->minItems(1)
    ->maxItems(5);

// Relationship
Select::make('category_id')
    ->relationship('category', 'name')
    ->searchable()
    ->preload()
    ->createOptionForm([
        TextInput::make('name')->required(),
    ]);

// Grouped options
Select::make('timezone')
    ->options([
        'America' => [
            'America/New_York' => 'New York',
            'America/Los_Angeles' => 'Los Angeles',
        ],
        'Europe' => [
            'Europe/London' => 'London',
            'Europe/Paris' => 'Paris',
        ],
    ]);

// Dynamic options
Select::make('state')
    ->options(fn (Get $get) =>
        State::where('country_id', $get('country_id'))
            ->pluck('name', 'id')
    )
    ->dependsOn('country_id');
```

### Select Options

```php
Select::make('field')
    // Behavior
    ->searchable()
    ->preload() // Load all options upfront
    ->allowHtml() // Allow HTML in options
    ->native(false) // Use custom dropdown

    // Multiple
    ->multiple()
    ->minItems(1)
    ->maxItems(10)

    // Options loading
    ->optionsLimit(50) // Limit shown options
    ->noSearchResultsMessage('No results found')
    ->loadingMessage('Loading...')

    // Create new option
    ->createOptionForm([...])
    ->createOptionUsing(fn ($data) => Category::create($data)->id)
    ->createOptionAction(fn (Action $action) => $action->modalHeading('New Category'));
```

---

## Radio

Radio button group.

```php
use Laravilt\Forms\Components\Radio;

Radio::make('payment_method')
    ->label('Payment Method')
    ->options([
        'credit_card' => 'Credit Card',
        'paypal' => 'PayPal',
        'bank_transfer' => 'Bank Transfer',
    ])
    ->descriptions([
        'credit_card' => 'Visa, Mastercard, Amex',
        'paypal' => 'Pay with your PayPal account',
        'bank_transfer' => 'Direct bank transfer',
    ])
    ->required()
    ->inline(); // Horizontal layout
```

---

## Checkbox

Single checkbox or checkbox group.

```php
use Laravilt\Forms\Components\Checkbox;
use Laravilt\Forms\Components\CheckboxList;

// Single checkbox
Checkbox::make('agree_terms')
    ->label('I agree to the terms and conditions')
    ->required()
    ->accepted(); // Must be checked

// Checkbox list
CheckboxList::make('permissions')
    ->label('Permissions')
    ->options([
        'create' => 'Create',
        'read' => 'Read',
        'update' => 'Update',
        'delete' => 'Delete',
    ])
    ->columns(2)
    ->bulkToggleable(); // Select all/none
```

---

## Toggle

Boolean toggle switch.

```php
use Laravilt\Forms\Components\Toggle;

Toggle::make('is_active')
    ->label('Active')
    ->default(true)
    ->onColor('success')
    ->offColor('danger')
    ->onIcon('Check')
    ->offIcon('X');

Toggle::make('notifications')
    ->label('Enable Notifications')
    ->helperText('Receive email notifications')
    ->inline(false); // Label above toggle
```

---

## Date Picker

Date selection with various formats.

```php
use Laravilt\Forms\Components\DatePicker;
use Laravilt\Forms\Components\DateTimePicker;
use Laravilt\Forms\Components\TimePicker;

// Date only
DatePicker::make('birth_date')
    ->label('Date of Birth')
    ->format('Y-m-d')
    ->displayFormat('M d, Y')
    ->native(false)
    ->closeOnDateSelection();

// Date and time
DateTimePicker::make('scheduled_at')
    ->label('Schedule For')
    ->minDate(now())
    ->maxDate(now()->addYear())
    ->minutesStep(15)
    ->seconds(false);

// Time only
TimePicker::make('start_time')
    ->label('Start Time')
    ->format('H:i')
    ->seconds(false);

// Date range
DateRangePicker::make('date_range')
    ->label('Date Range')
    ->startFieldName('start_date')
    ->endFieldName('end_date')
    ->minDate(now()->subYear())
    ->maxDate(now()->addYear());
```

### DatePicker Options

```php
DatePicker::make('date')
    // Format
    ->format('Y-m-d') // Storage format
    ->displayFormat('F j, Y') // Display format

    // Constraints
    ->minDate('2020-01-01')
    ->maxDate('2030-12-31')
    ->disabledDates(['2024-12-25', '2024-01-01'])

    // First day of week (0=Sunday, 1=Monday)
    ->firstDayOfWeek(1)

    // UI options
    ->native(false) // Use custom picker
    ->closeOnDateSelection()
    ->weekStartsOnMonday();
```

---

## File Upload

Advanced file upload with image editing.

```php
use Laravilt\Forms\Components\FileUpload;

// Basic file upload
FileUpload::make('document')
    ->label('Document')
    ->acceptedFileTypes(['application/pdf', '.doc', '.docx'])
    ->maxSize(5120) // 5MB
    ->directory('documents');

// Image upload
FileUpload::make('image')
    ->label('Image')
    ->image()
    ->imagePreview()
    ->maxSize(2048);

// Avatar with cropping
FileUpload::make('avatar')
    ->label('Profile Picture')
    ->image()
    ->avatar()
    ->imageCrop()
    ->imageEditor()
    ->circleCropper();

// Multiple files
FileUpload::make('gallery')
    ->label('Gallery Images')
    ->image()
    ->multiple()
    ->minFiles(1)
    ->maxFiles(10)
    ->reorderable();
```

### FileUpload Options

```php
FileUpload::make('file')
    // Storage
    ->disk('public')
    ->directory('uploads')
    ->visibility('public')
    ->preserveFilenames()

    // Constraints
    ->acceptedFileTypes(['image/*', 'application/pdf'])
    ->maxSize(10240) // KB
    ->minSize(100) // KB
    ->maxFiles(5)
    ->minFiles(1)

    // Image specific
    ->image()
    ->imagePreview()
    ->imageResize(800, 600, 'contain') // contain, cover, force
    ->imageCrop(16/9) // Aspect ratio
    ->imageEditor()

    // Actions
    ->downloadable()
    ->deletable()
    ->reorderable()
    ->openable() // Open in new tab
    ->previewable();
```

---

## Rich Editor

WYSIWYG HTML editor.

```php
use Laravilt\Forms\Components\RichEditor;

RichEditor::make('content')
    ->label('Content')
    ->toolbarButtons([
        'bold',
        'italic',
        'underline',
        'strike',
        'heading',
        'bulletList',
        'orderedList',
        'link',
        'image',
        'blockquote',
        'codeBlock',
        'undo',
        'redo',
    ])
    ->minHeight(300)
    ->maxHeight(600)
    ->showCharacterCount()
    ->showWordCount()
    ->fileAttachmentsDisk('public')
    ->fileAttachmentsDirectory('attachments');
```

---

## Markdown Editor

Markdown with preview.

```php
use Laravilt\Forms\Components\MarkdownEditor;

MarkdownEditor::make('readme')
    ->label('README')
    ->toolbarButtons([
        'bold',
        'italic',
        'heading',
        'link',
        'bulletList',
        'codeBlock',
        'preview',
    ])
    ->minHeight(200);
```

---

## Code Editor

Code with syntax highlighting.

```php
use Laravilt\Forms\Components\CodeEditor;

CodeEditor::make('code')
    ->label('Code')
    ->language('php') // php, javascript, css, html, json, etc.
    ->lineNumbers()
    ->minHeight(300)
    ->theme('github-dark');
```

---

## Color Picker

Color selection.

```php
use Laravilt\Forms\Components\ColorPicker;

ColorPicker::make('color')
    ->label('Brand Color')
    ->format('hex') // hex, rgb, rgba, hsl
    ->swatches([
        '#3b82f6',
        '#22c55e',
        '#f59e0b',
        '#ef4444',
    ]);
```

---

## Tags Input

Multi-tag input.

```php
use Laravilt\Forms\Components\TagsInput;

TagsInput::make('tags')
    ->label('Tags')
    ->placeholder('Add tags...')
    ->suggestions(['PHP', 'Laravel', 'Vue', 'React'])
    ->separator(',')
    ->splitKeys(['Tab', 'Enter', ',']);
```

---

## Key-Value

Key-value pairs editor.

```php
use Laravilt\Forms\Components\KeyValue;

KeyValue::make('metadata')
    ->label('Metadata')
    ->keyLabel('Key')
    ->valueLabel('Value')
    ->keyPlaceholder('Enter key')
    ->valuePlaceholder('Enter value')
    ->addActionLabel('Add Row')
    ->reorderable();
```

---

## Slider

Range slider.

```php
use Laravilt\Forms\Components\Slider;

Slider::make('volume')
    ->label('Volume')
    ->min(0)
    ->max(100)
    ->step(5)
    ->default(50)
    ->showValue(); // Show current value
```

---

## Rate Input

Star rating.

```php
use Laravilt\Forms\Components\RateInput;

RateInput::make('rating')
    ->label('Rating')
    ->min(1)
    ->max(5)
    ->allowHalf()
    ->default(3);
```

---

## Repeater

Repeating field groups.

```php
use Laravilt\Forms\Components\Repeater;

Repeater::make('addresses')
    ->label('Addresses')
    ->schema([
        TextInput::make('street')->required(),
        TextInput::make('city')->required(),
        Select::make('state')->options([...]),
        TextInput::make('zip'),
    ])
    ->columns(2)
    ->minItems(1)
    ->maxItems(5)
    ->defaultItems(1)
    ->addActionLabel('Add Address')
    ->reorderable()
    ->collapsible()
    ->cloneable();
```

---

## Builder

Block builder with drag-and-drop.

```php
use Laravilt\Forms\Components\Builder;
use Laravilt\Forms\Components\Builder\Block;

Builder::make('content')
    ->label('Page Content')
    ->blocks([
        Block::make('heading')
            ->label('Heading')
            ->icon('Heading')
            ->schema([
                TextInput::make('text')->required(),
                Select::make('level')
                    ->options(['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3']),
            ]),
        Block::make('paragraph')
            ->label('Paragraph')
            ->icon('AlignLeft')
            ->schema([
                RichEditor::make('content'),
            ]),
        Block::make('image')
            ->label('Image')
            ->icon('Image')
            ->schema([
                FileUpload::make('image')->image(),
                TextInput::make('alt'),
            ]),
    ])
    ->addActionLabel('Add Block')
    ->reorderable()
    ->collapsible()
    ->cloneable()
    ->blockNumbers();
```

---

## Hidden Field

Hidden form field.

```php
use Laravilt\Forms\Components\Hidden;

Hidden::make('user_id')
    ->default(auth()->id());
```

---

## Next Steps

- [Validation](validation.md) - Form validation rules
- [Layouts](layouts.md) - Layout components
- [Reactive Fields](reactive-fields.md) - Live updates
