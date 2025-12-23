---
title: Vue Components
description: Custom Vue components for infolists
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
concept: vue-components
vue_package: "radix-vue, lucide-vue-next"
---

# Vue Components

Building custom Vue 3 components for infolists.

## Component Structure

```vue
<script setup lang="ts">
import { computed } from 'vue'
import { Star } from 'lucide-vue-next'

interface Props {
  state: number
  maxStars: number
}

const props = defineProps<Props>()

const filledStars = computed(() =>
  Math.min(props.state, props.maxStars)
)
</script>

<template>
  <div class="flex gap-1">
    <Star
      v-for="i in maxStars"
      :key="i"
      :class="i <= filledStars ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300'"
      class="w-4 h-4"
    />
  </div>
</template>
```

## Registering Components

```typescript
// resources/js/app.ts
import InfolistRatingEntry from './Components/InfolistRatingEntry.vue'

app.component('InfolistRatingEntry', InfolistRatingEntry)
```

## Props Interface

```typescript
interface EntryProps {
  name: string
  state: any
  label?: string
  icon?: string
  tooltip?: string
  visible?: boolean
}
```

## Using Composables

```vue
<script setup lang="ts">
import { useClipboard } from '@vueuse/core'

const { copy, copied } = useClipboard()
</script>
```

## Styling with Tailwind

```vue
<template>
  <div class="rounded-lg border p-4 bg-card">
    <slot />
  </div>
</template>
```
