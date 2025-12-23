---
title: Vue Components
description: Vue.js component patterns for custom fields
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: custom
---

# Vue Components

Patterns for creating Vue.js form field components.

## Base Structure

All field components follow this pattern:

```vue
<template>
  <FieldWrapper
    :label="label"
    :errors="errors"
    :helper-text="helperText"
    :hint="hint"
    :required="required"
  >
    <!-- Your input component -->
  </FieldWrapper>
</template>

<script setup lang="ts">
import { FieldWrapper } from '@/components/forms'

interface Props {
  modelValue?: unknown
  label?: string
  placeholder?: string
  helperText?: string
  hint?: string
  errors?: string[]
  required?: boolean
  disabled?: boolean
  readonly?: boolean
}

const props = defineProps<Props>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: unknown): void
}>()
</script>
```

## Using shadcn/ui

```vue
<script setup>
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
</script>
```

## Using Lucide Icons

```vue
<script setup>
import { Star, Check, X } from 'lucide-vue-next'
</script>

<template>
  <Star class="h-5 w-5 text-yellow-400" />
</template>
```

## Using VueUse

```vue
<script setup>
import { useDebounceFn, useVModel } from '@vueuse/core'

const props = defineProps<{ modelValue: string }>()
const emit = defineEmits(['update:modelValue'])

// Two-way binding helper
const value = useVModel(props, 'modelValue', emit)

// Debounced input
const debouncedUpdate = useDebounceFn((val) => {
  emit('update:modelValue', val)
}, 300)
</script>
```

## Composables

Create reusable field logic:

```typescript
// composables/useFieldState.ts
import { computed } from 'vue'

export function useFieldState(props: { disabled?: boolean; readonly?: boolean }) {
  const isInteractive = computed(() => !props.disabled && !props.readonly)

  return { isInteractive }
}
```

## Registration

Register in `resources/js/composables/useFormComponents.ts`:

```typescript
import ColorPicker from '@/components/forms/ColorPicker.vue'
import RatingInput from '@/components/forms/RatingInput.vue'

export const formComponents = {
  'color-picker': ColorPicker,
  'rating-input': RatingInput,
}
```

## Related

- [Creating Fields](creating-fields) - PHP field class
- [Packages](packages) - Third-party packages
