# Support Package Introduction

The Support package is the foundation layer for all Laravilt packages, providing base components, utilities, contracts, and traits for building consistent, reusable components across the entire ecosystem.

## Overview

Laravilt Support offers:

- **Base Component Class** - Foundation for all Laravilt components
- **Reusable Traits** - 11 concerns for common component behaviors
- **State Management** - Get/Set utilities with dot notation
- **Multi-Platform Serialization** - Support for Blade, API, and Flutter
- **Contracts & Interfaces** - Consistent component contracts
- **Developer Tools** - Artisan commands and AI integration
- **i18n Support** - RTL language detection and translations

---

## Base Component Class

All Laravilt components extend the base `Component` class which provides:

### Factory Pattern

```php
use Laravilt\Support\Component;

class CustomComponent extends Component
{
    protected string $view = 'components.custom-component';

    protected function setUp(): void
    {
        // Component initialization
    }
}

// Usage
$component = CustomComponent::make('field_name')
    ->label('Field Label')
    ->placeholder('Enter value');
```

### Multi-Platform Serialization

Components serialize to multiple formats for different platforms:

```php
// Blade + Vue.js (Inertia)
$component->toLaraviltProps();

// REST API
$component->toApiProps();

// Flutter mobile apps
$component->toFlutterProps();
```

---

## Utilities

### Get Utility

Safely retrieve nested array values using dot notation:

```php
use Laravilt\Support\Utilities\Get;

$data = [
    'user' => [
        'name' => 'John Doe',
        'address' => [
            'city' => 'New York'
        ]
    ]
];

$get = new Get($data);
$name = $get('user.name'); // 'John Doe'
$city = $get('user.address.city'); // 'New York'
$country = $get('user.address.country', 'USA'); // Default value

// Static usage
$email = Get::value($data, 'user.email', null);
```

**Injected in Closures:**

```php
TextInput::make('state')
    ->visible(fn (Get $get) => $get('country') === 'US');
```

### Set Utility

Safely set nested array values with change tracking:

```php
use Laravilt\Support\Utilities\Set;

$data = [];
$set = new Set($data);

$set('user.name', 'John Doe');
$set('user.address.city', 'New York');

// Check if any changes made
if ($set->hasChanges()) {
    // React to changes
}
```

**Injected in Closures:**

```php
TextInput::make('full_name')
    ->afterStateUpdated(function (Set $set, $state) {
        $set('display_name', strtoupper($state));
    });
```

### Translator Utility

RTL/LTR language detection and management:

```php
use Laravilt\Support\Utilities\Translator;

// Check if locale is RTL
Translator::isRTL('ar'); // true
Translator::isRTL('en'); // false

// Get text direction
Translator::direction('he'); // 'rtl'
Translator::direction('en'); // 'ltr'

// Get all RTL locales
$rtlLocales = Translator::getRTLLocales();
// ['ar', 'he', 'fa', 'ur', 'yi', 'ji', 'iw']

// Add custom RTL locale
Translator::addRTLLocale('ku'); // Kurdish
```

---

## Reusable Traits (Concerns)

The Support package provides 11 traits that add common functionality to components:

### EvaluatesClosures

Evaluates closures with automatic dependency injection:

```php
use Laravilt\Support\Concerns\EvaluatesClosures;

class CustomComponent extends Component
{
    use EvaluatesClosures;

    public function visible(Closure|bool $condition): static
    {
        $this->visible = $condition;
        return $this;
    }

    public function isVisible(): bool
    {
        return $this->evaluate($this->visible);
    }
}
```

**Automatic Injection:**
- `Get $get` - Get utility instance
- `Set $set` - Set utility instance
- `$data` - Current component data
- `$record` - Current record (in resources)

### InteractsWithState

Core state management:

```php
use Laravilt\Support\Concerns\InteractsWithState;

TextInput::make('name')
    ->state('John Doe')        // Set state
    ->default('Anonymous');     // Set default

$value = $component->getState();
$hasValue = $component->hasState();
```

### CanBeDisabled

Conditional disable functionality:

```php
use Laravilt\Support\Concerns\CanBeDisabled;

TextInput::make('email')
    ->disabled()                           // Always disabled
    ->disabled(fn () => auth()->guest())   // Conditional
    ->disabled(fn (Get $get) => $get('role') === 'admin');

$isDisabled = $component->isDisabled();
$isEnabled = $component->isEnabled();
```

### CanBeReadonly

Readonly state management:

```php
use Laravilt\Support\Concerns\CanBeReadonly;

TextInput::make('created_at')
    ->readonly()
    ->readonly(fn ($record) => $record->isLocked());

$isReadonly = $component->isReadonly();
```

### CanBeRequired

Mark fields as required:

```php
use Laravilt\Support\Concerns\CanBeRequired;

TextInput::make('email')
    ->required()
    ->required(fn (Get $get) => $get('contact_method') === 'email');

$isRequired = $component->isRequired();
```

### HasVisibility

Control component visibility:

```php
use Laravilt\Support\Concerns\HasVisibility;

TextInput::make('ssn')
    ->visible(fn () => auth()->user()->isAdmin())
    ->hidden(fn (Get $get) => $get('country') !== 'US');

$isVisible = $component->isVisible();
$isHidden = $component->isHidden();
```

### HasLabel

Label management with auto-generation:

```php
use Laravilt\Support\Concerns\HasLabel;

TextInput::make('first_name')
    ->label('First Name');

TextInput::make('user_email');
// Auto-generates label: "User Email"

$label = $component->getLabel();
```

### HasId

Custom ID with auto-generation:

```php
use Laravilt\Support\Concerns\HasId;

TextInput::make('email')
    ->id('custom-email-field');

TextInput::make('name');
// Auto-generates: "laravilt-name-{hash}"

$id = $component->getId();
```

### HasPlaceholder

Placeholder text support:

```php
use Laravilt\Support\Concerns\HasPlaceholder;

TextInput::make('email')
    ->placeholder('user@example.com')
    ->placeholder(fn () => auth()->user()->email);

$placeholder = $component->getPlaceholder();
```

### HasHelperText

Helper/hint text:

```php
use Laravilt\Support\Concerns\HasHelperText;

TextInput::make('password')
    ->helperText('Must be at least 8 characters')
    ->hint('Include numbers and symbols'); // Alias

$helperText = $component->getHelperText();
```

### HasColumnSpan

Grid column spanning:

```php
use Laravilt\Support\Concerns\HasColumnSpan;

TextInput::make('description')
    ->columnSpanFull()           // Span all columns
    ->columnSpan(2)              // Span 2 columns
    ->columnSpan('md:col-span-3'); // Tailwind classes

$span = $component->getColumnSpan();
```

---

## Contracts and Interfaces

### Buildable Contract

Factory pattern interface:

```php
interface Buildable
{
    public static function make(string $name): static;
}
```

### Serializable Contract

Multi-platform serialization:

```php
interface Serializable
{
    public function toLaraviltProps(): array;  // Blade + Vue.js
    public function toApiProps(): array;       // REST API
    public function toFlutterProps(): array;   // Flutter apps
}
```

### InertiaSerializable Contract

Inertia.js integration:

```php
interface InertiaSerializable
{
    public function toInertiaProps(): array;
}
```

### FlutterSerializable Contract

Flutter app serialization:

```php
interface FlutterSerializable
{
    public function toFlutterProps(): array;
}
```

### HasLabel Contract

Label interface:

```php
interface HasLabel
{
    public function label(string|Closure $label): static;
    public function getLabel(): ?string;
}
```

### HasState Contract

State management interface:

```php
interface HasState
{
    public function state(mixed $state): static;
    public function getState(): mixed;
}
```

---

## Creating Custom Components

### Artisan Command

```bash
# Create custom component
php artisan make:component RatingInput

# Overwrite existing
php artisan make:component RatingInput --force
```

**Generated Files:**
- Component class: `app/Components/RatingInput.php`
- Blade view: `resources/views/components/rating-input.blade.php`

### Example Custom Component

```php
<?php

namespace App\Components;

use Laravilt\Support\Component;

class RatingInput extends Component
{
    protected string $view = 'components.rating-input';

    protected int $maxRating = 5;
    protected string $color = 'yellow';

    public function maxRating(int $rating): static
    {
        $this->maxRating = $rating;
        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;
        return $this;
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'maxRating' => $this->maxRating,
            'color' => $this->color,
        ]);
    }
}
```

**Usage:**

```php
RatingInput::make('rating')
    ->label('Product Rating')
    ->maxRating(5)
    ->color('yellow')
    ->default(4);
```

---

## Color Palette

Predefined color constants for UI components:

```php
use Laravilt\Support\Colors\Color;

// Semantic colors
Color::Primary;    // #3b82f6 (Blue)
Color::Secondary;  // #6b7280 (Gray)
Color::Success;    // #10b981 (Green)
Color::Danger;     // #ef4444 (Red)
Color::Warning;    // #f59e0b (Amber)
Color::Info;       // #0ea5e9 (Sky)

// Get all colors
$colors = Color::all();

// Get semantic colors only
$semanticColors = Color::semantic();
```

---

## Image Size Enum

Predefined image sizes with pixel mappings:

```php
use Laravilt\Support\Enums\ImageSize;

ImageSize::ExtraSmall;      // 'xs' - 24px
ImageSize::Small;           // 'sm' - 32px
ImageSize::Medium;          // 'md' - 40px
ImageSize::Large;           // 'lg' - 48px
ImageSize::ExtraLarge;      // 'xl' - 56px
ImageSize::TwoExtraLarge;   // '2xl' - 64px

// Get pixel size
$size = ImageSize::Large->getSize(); // 48

// Get CSS size
$cssSize = ImageSize::Large->getCssSize(); // '48px'
```

---

## Serialization

### Laravilt Format (Blade + Vue)

```php
$component->toLaraviltProps();
```

**Output:**
```php
[
    'component' => 'text_input',
    'id' => 'laravilt-field-hash',
    'name' => 'field_name',
    'state' => 'current_value',
    'label' => 'Field Label',
    'placeholder' => 'Enter value',
    'helperText' => 'Helpful hint',
    'hidden' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => true,
    'columnSpan' => 2,
    'rtl' => false,
    'theme' => 'light',
    'locale' => 'en',
    'meta' => [],
]
```

### API Format

```php
$component->toApiProps();
```

**Output:**
```php
[
    'type' => 'TextInput',
    'name' => 'field_name',
    'value' => 'current_value',
    'label' => 'Field Label',
    'helperText' => 'Helpful hint',
    'meta' => [],
]
```

### Flutter Format

```php
$component->toFlutterProps();
```

**Output:**
```php
[
    'widget' => 'TextInput',
    'name' => 'field_name',
    'value' => 'current_value',
    'label' => 'Field Label',
    'helperText' => 'Helpful hint',
    'isRTL' => false,
    'meta' => [],
]
```

### ComponentSerializer Utility

```php
use Laravilt\Support\LaraviltCore\Bridge\ComponentSerializer;

// Serialize single component
ComponentSerializer::toLaravilt($component);
ComponentSerializer::toApi($component);
ComponentSerializer::toFlutter($component);

// Serialize multiple components
ComponentSerializer::serializeMany($components, 'laravilt');
ComponentSerializer::serializeMany($components, 'api');
ComponentSerializer::serializeMany($components, 'flutter');

// To JSON
$json = ComponentSerializer::toJson($component, 'laravilt');
```

---

## Complete Example

### Building a Custom Form Field

```php
<?php

namespace App\Components;

use Laravilt\Support\Component;
use Laravilt\Support\Concerns\CanBeDisabled;
use Laravilt\Support\Concerns\CanBeRequired;
use Laravilt\Support\Concerns\HasLabel;
use Laravilt\Support\Concerns\HasPlaceholder;
use Laravilt\Support\Concerns\HasHelperText;
use Laravilt\Support\Concerns\InteractsWithState;
use Laravilt\Support\Utilities\Get;

class SliderInput extends Component
{
    use CanBeDisabled;
    use CanBeRequired;
    use HasLabel;
    use HasPlaceholder;
    use HasHelperText;
    use InteractsWithState;

    protected string $view = 'components.slider-input';

    protected int $min = 0;
    protected int $max = 100;
    protected int $step = 1;
    protected bool $showValue = true;
    protected string $color = 'primary';

    public function min(int $min): static
    {
        $this->min = $min;
        return $this;
    }

    public function max(int $max): static
    {
        $this->max = $max;
        return $this;
    }

    public function step(int $step): static
    {
        $this->step = $step;
        return $this;
    }

    public function showValue(bool $show = true): static
    {
        $this->showValue = $show;
        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;
        return $this;
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'min' => $this->min,
            'max' => $this->max,
            'step' => $this->step,
            'showValue' => $this->showValue,
            'color' => $this->color,
        ]);
    }
}
```

**Usage:**

```php
SliderInput::make('volume')
    ->label('Volume Level')
    ->helperText('Adjust the volume')
    ->min(0)
    ->max(100)
    ->step(5)
    ->showValue()
    ->color('primary')
    ->default(50)
    ->required();
```

---

## Blade Components

### Component Wrapper

```blade
<x-laravilt-component name="my-component" :data="$componentData" />
```

### Vue Component Wrapper

```blade
<x-laravilt-vue-component component="Tabs" :props="$tabsData" />
```

### Link Component

```blade
<x-laravilt-link href="/dashboard" method="GET">
    Dashboard
</x-laravilt-link>
```

### Modal Component

```blade
<x-laravilt-modal name="confirm-delete" :open="true" title="Confirm Deletion">
    Are you sure you want to delete this item?
</x-laravilt-modal>
```

---

## Best Practices

### 1. Use Traits for Common Behaviors

```php
// Good: Compose with traits
class CustomField extends Component
{
    use HasLabel;
    use HasPlaceholder;
    use InteractsWithState;
}

// Avoid: Reinventing common functionality
class CustomField extends Component
{
    protected $label;
    public function label($label) { ... } // Don't reimplement
}
```

### 2. Leverage Closure Evaluation

```php
// Good: Dynamic, context-aware values
->visible(fn (Get $get) => $get('show_advanced'))
->disabled(fn () => now()->isSunday())

// Avoid: Static values when dynamic is needed
->visible(true)  // Can't respond to state changes
```

### 3. Follow Fluent Interface Pattern

```php
// Good: All setters return $this
public function customOption(string $value): static
{
    $this->customOption = $value;
    return $this;
}

// Avoid: Breaking the chain
public function customOption(string $value): void
{
    $this->customOption = $value;
}
```

### 4. Use Multi-Platform Serialization

```php
// Good: Support all platforms
public function toLaraviltProps(): array
{
    return array_merge(parent::toLaraviltProps(), [
        'customProp' => $this->customProp,
    ]);
}

public function toApiProps(): array
{
    return array_merge(parent::toApiProps(), [
        'customProp' => $this->customProp,
    ]);
}
```

### 5. Provide Sensible Defaults

```php
protected function setUp(): void
{
    $this->min = 0;
    $this->max = 100;
    $this->step = 1;
    $this->showValue = true;
}
```

---

## API Reference

### Component Base Class

```php
Component::make(string $name): static
->getName(): string
->meta(array $meta): static
->getMeta(): array
->getComponentType(): string
->render(): string
->toLaraviltProps(): array
->toApiProps(): array
->toFlutterProps(): array
->toArray(): array
->toJson($options = 0): string
```

### Get Utility

```php
new Get(array $data)
->__invoke(string $key, mixed $default = null): mixed
Get::value(array $data, string $key, mixed $default = null): mixed
```

### Set Utility

```php
new Set(array &$data)
->__invoke(string $key, mixed $value): void
->hasChanges(): bool
```

### Translator Utility

```php
Translator::isRTL(?string $locale = null): bool
Translator::direction(?string $locale = null): string
Translator::getRTLLocales(): array
Translator::addRTLLocale(string $locale): void
```

### ComponentSerializer

```php
ComponentSerializer::toLaravilt(Component $component): array
ComponentSerializer::toApi(Component $component): array
ComponentSerializer::toFlutter(Component $component): array
ComponentSerializer::serializeMany(array $components, string $format): array
ComponentSerializer::toJson(Component $component, string $format): string
```

---

## Next Steps

- [Forms](../forms/introduction.md) - Building forms with components
- [Schemas](../schemas/introduction.md) - Layout components
- [Panel](../panel/introduction.md) - Panel configuration
