---
title: Creating Fields
description: Step-by-step guide to create custom fields
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: custom
---

# Creating Custom Fields

Step-by-step guide to create custom form fields.

## Step 1: PHP Field Class

Create `app/Forms/Components/RatingInput.php`:

```php
<?php

namespace App\Forms\Components;

use Closure;
use Laravilt\Forms\Components\Field;

class RatingInput extends Field
{
    protected string $view = 'forms.components.rating';

    protected int|Closure $max = 5;
    protected bool|Closure $allowHalf = false;

    public function max(int|Closure $max): static
    {
        $this->max = $max;
        return $this;
    }

    public function allowHalf(bool|Closure $allow = true): static
    {
        $this->allowHalf = $allow;
        return $this;
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'max' => $this->evaluate($this->max),
            'allowHalf' => $this->evaluate($this->allowHalf),
        ]);
    }
}
```

## Step 2: Vue Component

Create `resources/js/components/forms/RatingInput.vue`:

```vue
<template>
  <FieldWrapper :label="label" :errors="errors" :required="required">
    <div class="flex gap-1">
      <button
        v-for="star in max"
        :key="star"
        type="button"
        @click="setRating(star)"
        :disabled="disabled"
        class="text-2xl"
      >
        <Star
          :class="star <= modelValue ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300'"
          class="h-6 w-6"
        />
      </button>
    </div>
  </FieldWrapper>
</template>

<script setup lang="ts">
import { Star } from 'lucide-vue-next'
import { FieldWrapper } from '@/components/forms'

const props = defineProps<{
  modelValue?: number
  label?: string
  errors?: string[]
  required?: boolean
  disabled?: boolean
  max?: number
  allowHalf?: boolean
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: number): void
}>()

function setRating(value: number) {
  emit('update:modelValue', value)
}
</script>
```

## Step 3: Register Component

In `resources/js/composables/useFormComponents.ts`:

```typescript
import RatingInput from '@/components/forms/RatingInput.vue'

export const formComponents = {
  'rating-input': RatingInput,
}
```

## Step 4: Usage

```php
<?php

use App\Forms\Components\RatingInput;

RatingInput::make('rating')
    ->label('Your Rating')
    ->max(5)
    ->required();
```

## Extending Existing Fields

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\TextInput;

class PhoneInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->tel()
            ->mask('(999) 999-9999')
            ->placeholder('(555) 123-4567');
    }
}
```

## Related

- [Vue Components](vue-components) - Component patterns
- [Packages](packages) - Third-party integrations
