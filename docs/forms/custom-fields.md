# Custom Fields

Learn how to create custom form fields for Laravilt forms.

## Overview

Creating custom fields allows you to:

- Build reusable field components
- Implement complex input patterns
- Integrate third-party libraries
- Create domain-specific fields

All custom fields extend the base `Field` class from the Forms package.

---

## Creating a Basic Custom Field

### Step 1: Generate Field Class

Create a new field class in `app/Forms/Components`:

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\Field;

class ColorPicker extends Field
{
    protected string $view = 'forms.components.color-picker';

    protected string|Closure $format = 'hex';

    public function format(string|Closure $format): static
    {
        $this->format = $format;
        return $this;
    }

    public function getFormat(): string
    {
        return $this->evaluate($this->format);
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'format' => $this->getFormat(),
        ]);
    }
}
```

### Step 2: Create Vue Component

Create Vue component at `resources/js/components/forms/ColorPicker.vue`:

```vue
<template>
  <FieldWrapper
    :label="label"
    :errors="errors"
    :helper-text="helperText"
    :required="required"
  >
    <div class="flex items-center gap-2">
      <input
        type="color"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :disabled="disabled"
        :readonly="readonly"
        class="h-10 w-20 cursor-pointer rounded border"
      />
      <Input
        :model-value="modelValue"
        @update:model-value="$emit('update:modelValue', $event)"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
      />
    </div>
  </FieldWrapper>
</template>

<script setup lang="ts">
import { FieldWrapper } from '@/components/forms'
import { Input } from '@/components/ui/input'

defineProps<{
  modelValue?: string
  label?: string
  placeholder?: string
  helperText?: string
  errors?: string[]
  required?: boolean
  disabled?: boolean
  readonly?: boolean
  format?: 'hex' | 'rgb' | 'hsl'
}>()

defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()
</script>
```

### Step 3: Register Component

Register in your form field registry (`resources/js/composables/useFormComponents.ts`):

```typescript
import ColorPicker from '@/components/forms/ColorPicker.vue'

export const formComponents = {
  // ... other components
  'color-picker': ColorPicker,
}
```

### Step 4: Use Your Custom Field

```php
use App\Forms\Components\ColorPicker;

ColorPicker::make('primary_color')
    ->label('Primary Brand Color')
    ->format('hex')
    ->default('#3b82f6')
    ->required();
```

---

## Extending Existing Fields

### Extend TextInput

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\TextInput;

class PhoneInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('tel')
            ->mask('(999) 999-9999')
            ->placeholder('(555) 123-4567')
            ->rules(['regex:/^\(\d{3}\) \d{3}-\d{4}$/']);
    }

    public function international(): static
    {
        $this->mask(null)
            ->placeholder('+1 555-123-4567')
            ->rules(['regex:/^\+\d{1,3}\s\d{3}-\d{3}-\d{4}$/']);

        return $this;
    }
}
```

**Usage:**

```php
use App\Forms\Components\PhoneInput;

PhoneInput::make('phone')
    ->required();

PhoneInput::make('international_phone')
    ->international();
```

---

## Adding Custom Validation

### Field with Built-in Validation

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\Field;
use App\Rules\CreditCardNumber;

class CreditCardInput extends Field
{
    protected string $view = 'forms.components.credit-card';

    protected function setUp(): void
    {
        parent::setUp();

        $this->mask('9999 9999 9999 9999')
            ->placeholder('1234 5678 9012 3456')
            ->rules([
                'required',
                'string',
                new CreditCardNumber(),
            ]);
    }

    public function getCardType(): ?string
    {
        $value = $this->getState();

        if (!$value) {
            return null;
        }

        // Detect card type
        if (preg_match('/^4/', $value)) {
            return 'visa';
        } elseif (preg_match('/^5[1-5]/', $value)) {
            return 'mastercard';
        } elseif (preg_match('/^3[47]/', $value)) {
            return 'amex';
        }

        return null;
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'cardType' => $this->getCardType(),
        ]);
    }
}
```

---

## Complex Custom Fields

### Rating Field

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\Field;

class RatingInput extends Field
{
    protected string $view = 'forms.components.rating';

    protected int|Closure $max = 5;
    protected bool|Closure $allowHalf = false;
    protected string|Closure $icon = 'Star';

    public function max(int|Closure $max): static
    {
        $this->max = $max;
        return $this;
    }

    public function allowHalf(bool|Closure $condition = true): static
    {
        $this->allowHalf = $condition;
        return $this;
    }

    public function icon(string|Closure $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function getMax(): int
    {
        return $this->evaluate($this->max);
    }

    public function isAllowHalf(): bool
    {
        return $this->evaluate($this->allowHalf);
    }

    public function getIcon(): string
    {
        return $this->evaluate($this->icon);
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'max' => $this->getMax(),
            'allowHalf' => $this->isAllowHalf(),
            'icon' => $this->getIcon(),
        ]);
    }
}
```

**Vue Component:**

```vue
<template>
  <FieldWrapper
    :label="label"
    :errors="errors"
    :helper-text="helperText"
    :required="required"
  >
    <div class="flex items-center gap-1">
      <button
        v-for="star in max"
        :key="star"
        type="button"
        @click="setRating(star)"
        @mouseenter="hoverRating = star"
        @mouseleave="hoverRating = null"
        :disabled="disabled"
        class="text-2xl transition-colors"
        :class="getStarColor(star)"
      >
        <component :is="getStarIcon(star)" class="h-6 w-6" />
      </button>
    </div>
  </FieldWrapper>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Star, StarHalf } from 'lucide-vue-next'
import { FieldWrapper } from '@/components/forms'

const props = defineProps<{
  modelValue?: number
  label?: string
  helperText?: string
  errors?: string[]
  required?: boolean
  disabled?: boolean
  max?: number
  allowHalf?: boolean
  icon?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: number): void
}>()

const hoverRating = ref<number | null>(null)

function setRating(value: number) {
  emit('update:modelValue', value)
}

function getStarColor(star: number): string {
  const rating = hoverRating.value ?? props.modelValue ?? 0
  return star <= rating ? 'text-yellow-400' : 'text-gray-300'
}

function getStarIcon(star: number) {
  return Star // or StarHalf if allowHalf and applicable
}
</script>
```

---

## Third-Party Integrations

### Tiptap Editor Field

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\Field;

class TiptapEditor extends Field
{
    protected string $view = 'forms.components.tiptap-editor';

    protected array|Closure $extensions = [];
    protected int|Closure $minHeight = 200;
    protected int|Closure $maxHeight = 600;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extensions([
            'bold',
            'italic',
            'underline',
            'heading',
            'bulletList',
            'orderedList',
            'link',
        ]);
    }

    public function extensions(array|Closure $extensions): static
    {
        $this->extensions = $extensions;
        return $this;
    }

    public function minHeight(int|Closure $height): static
    {
        $this->minHeight = $height;
        return $this;
    }

    public function maxHeight(int|Closure $height): static
    {
        $this->maxHeight = $height;
        return $this;
    }

    public function getExtensions(): array
    {
        return $this->evaluate($this->extensions);
    }

    public function getMinHeight(): int
    {
        return $this->evaluate($this->minHeight);
    }

    public function getMaxHeight(): int
    {
        return $this->evaluate($this->maxHeight);
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'extensions' => $this->getExtensions(),
            'minHeight' => $this->getMinHeight(),
            'maxHeight' => $this->getMaxHeight(),
        ]);
    }
}
```

---

## Field with Actions

### Address Lookup Field

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\Field;
use Laravilt\Actions\Action;

class AddressLookup extends Field
{
    protected string $view = 'forms.components.address-lookup';

    protected function setUp(): void
    {
        parent::setUp();

        $this->suffixAction(
            Action::make('lookup')
                ->label('Lookup')
                ->icon('Search')
                ->action(function (array $data, Set $set) {
                    $zipCode = $data['zip_code'] ?? null;

                    if (!$zipCode) {
                        return;
                    }

                    $location = Http::get("https://api.zippopotam.us/us/{$zipCode}")
                        ->json();

                    if ($location) {
                        $set('city', $location['places'][0]['place name'] ?? null);
                        $set('state', $location['places'][0]['state abbreviation'] ?? null);
                    }
                })
        );
    }
}
```

---

## Accessing Field Context

### Field with Record Access

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\Select;

class StatusSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options(function ($record) {
            // Access current record in edit mode
            if ($record?->is_published) {
                return [
                    'published' => 'Published',
                    'archived' => 'Archived',
                ];
            }

            return [
                'draft' => 'Draft',
                'published' => 'Published',
            ];
        });
    }
}
```

---

## Best Practices

### 1. Extend Existing Fields When Possible

```php
// Good: Extend existing field
class EmailInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->email()
            ->autocomplete('email')
            ->prefixIcon('Mail');
    }
}

// Avoid: Creating from scratch unnecessarily
```

### 2. Use Descriptive Names

```php
// Good
class CurrencyInput extends Field { }
class DateRangePicker extends Field { }

// Avoid
class Input1 extends Field { }
class MyField extends Field { }
```

### 3. Provide Sensible Defaults

```php
protected function setUp(): void
{
    parent::setUp();

    $this->default(now())
        ->format('Y-m-d')
        ->displayFormat('M d, Y');
}
```

### 4. Document Your Fields

```php
/**
 * Color picker input with multiple format support.
 *
 * Supports hex, rgb, and hsl formats.
 *
 * @example ColorPicker::make('brand_color')->format('hex')
 */
class ColorPicker extends Field
{
    // ...
}
```

### 5. Add Type Hints

```php
public function format(string|Closure $format): static
{
    $this->format = $format;
    return $this;
}

public function getFormat(): string
{
    return $this->evaluate($this->format);
}
```

---

## Testing Custom Fields

### Unit Test

```php
<?php

use App\Forms\Components\PhoneInput;

it('formats phone number correctly', function () {
    $field = PhoneInput::make('phone')
        ->state('5551234567');

    expect($field->getState())->toBe('5551234567');
});

it('applies validation rules', function () {
    $field = PhoneInput::make('phone');

    $rules = $field->getValidationRules();

    expect($rules)->toContain('regex:/^\(\d{3}\) \d{3}-\d{4}$/');
});
```

### Feature Test

```php
<?php

use App\Forms\Components\RatingInput;

it('renders rating input', function () {
    $field = RatingInput::make('rating')
        ->max(5)
        ->allowHalf();

    $props = $field->toLaraviltProps();

    expect($props)
        ->toHaveKey('max', 5)
        ->toHaveKey('allowHalf', true);
});
```

---

## Complete Example

### Signature Pad Field

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\Field;

class SignaturePad extends Field
{
    protected string $view = 'forms.components.signature-pad';

    protected int|Closure $width = 600;
    protected int|Closure $height = 300;
    protected string|Closure $penColor = '#000000';
    protected int|Closure $penWidth = 2;
    protected string|Closure $backgroundColor = '#ffffff';

    public function width(int|Closure $width): static
    {
        $this->width = $width;
        return $this;
    }

    public function height(int|Closure $height): static
    {
        $this->height = $height;
        return $this;
    }

    public function penColor(string|Closure $color): static
    {
        $this->penColor = $color;
        return $this;
    }

    public function penWidth(int|Closure $width): static
    {
        $this->penWidth = $width;
        return $this;
    }

    public function backgroundColor(string|Closure $color): static
    {
        $this->backgroundColor = $color;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->evaluate($this->width);
    }

    public function getHeight(): int
    {
        return $this->evaluate($this->height);
    }

    public function getPenColor(): string
    {
        return $this->evaluate($this->penColor);
    }

    public function getPenWidth(): int
    {
        return $this->evaluate($this->penWidth);
    }

    public function getBackgroundColor(): string
    {
        return $this->evaluate($this->backgroundColor);
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'penColor' => $this->getPenColor(),
            'penWidth' => $this->getPenWidth(),
            'backgroundColor' => $this->getBackgroundColor(),
        ]);
    }
}
```

**Usage:**

```php
use App\Forms\Components\SignaturePad;

SignaturePad::make('signature')
    ->label('Sign Here')
    ->required()
    ->width(800)
    ->height(400)
    ->penColor('#0000ff')
    ->penWidth(3);
```

---

## Field Registration

### Auto-Discovery

Fields in `app/Forms/Components` are automatically discovered.

### Manual Registration

Register custom fields in a service provider:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Forms\Components\CustomField;

class FormServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register custom field components
        $this->loadViewsFrom(
            resource_path('views/forms/components'),
            'forms'
        );
    }
}
```

---

## Next Steps

- [Field Types](field-types.md) - Built-in field reference
- [Validation](validation.md) - Field validation
- [Reactive Fields](reactive-fields.md) - Field dependencies
