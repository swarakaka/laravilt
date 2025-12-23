---
title: Custom Fields
description: Create custom form components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: custom
---

# Custom Fields

Create custom form fields with Vue.js components.

## Overview

Custom fields require:

1. **PHP Field Class** - Extends `Laravilt\Forms\Components\Field`
2. **Vue Component** - Renders the field UI
3. **Registration** - Register in form components

## Required Packages

```bash
# Core Vue packages
npm install vue@3
npm install @vueuse/core

# UI Components (shadcn/ui)
npm install radix-vue
npm install class-variance-authority
npm install clsx tailwind-merge

# Icons
npm install lucide-vue-next
```

## File Structure

```
app/Forms/Components/
└── ColorPicker.php

resources/js/components/forms/
└── ColorPicker.vue
```

## PHP Field Class

```php
<?php

namespace App\Forms\Components;

use Laravilt\Forms\Components\Field;

class ColorPicker extends Field
{
    protected string $view = 'forms.components.color-picker';

    protected string $format = 'hex';

    public function format(string $format): static
    {
        $this->format = $format;
        return $this;
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'format' => $this->format,
        ]);
    }
}
```

## Vue Component

```vue
<template>
  <FieldWrapper
    :label="label"
    :errors="errors"
    :helper-text="helperText"
    :required="required"
  >
    <input
      type="color"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :disabled="disabled"
    />
  </FieldWrapper>
</template>

<script setup lang="ts">
import { FieldWrapper } from '@/components/forms'

defineProps<{
  modelValue?: string
  label?: string
  errors?: string[]
  helperText?: string
  required?: boolean
  disabled?: boolean
  format?: 'hex' | 'rgb'
}>()

defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()
</script>
```

## Related

- [Creating Fields](creating-fields) - Step-by-step guide
- [Vue Components](vue-components) - Component patterns
- [Packages](packages) - Third-party integrations
