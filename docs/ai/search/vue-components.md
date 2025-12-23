---
title: Search Vue Components
description: Global search Vue components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
vue_component: GlobalSearch
vue_package: "radix-vue, @vueuse/core"
---

# Search Vue Components

Vue components for global search.

## GlobalSearch Component

```vue
<script setup lang="ts">
import { GlobalSearch } from '@laravilt/ai'

const handleSelect = (result, group) => {
    console.log('Selected:', result)
}
</script>

<template>
  <GlobalSearch
    placeholder="Search products, orders..."
    @select="handleSelect"
  />
</template>
```

## With Custom Trigger

```vue
<script setup lang="ts">
import { ref } from 'vue'
import { GlobalSearch } from '@laravilt/ai'
import { Search } from 'lucide-vue-next'

const searchRef = ref()

const openSearch = () => {
    searchRef.value?.open()
}
</script>

<template>
  <button @click="openSearch">
    <Search class="h-5 w-5" />
    <span>Search</span>
    <kbd>⌘K</kbd>
  </button>

  <GlobalSearch ref="searchRef" />
</template>
```

## Search Result Types

```typescript
interface SearchResult {
  id: string | number
  title: string
  subtitle?: string
  url: string
  icon?: string
}

interface SearchGroup {
  resource: string
  label: string
  icon: string
  url: string
  aiAnswer?: string
  results: SearchResult[]
}
```

## Component Props

| Prop | Type | Description |
|------|------|-------------|
| `placeholder` | string | Input placeholder |
| `useAI` | boolean | Enable AI mode |
| `debounce` | number | Debounce delay |

## Events

| Event | Description |
|-------|-------------|
| `@select` | Result selected |
| `@search` | Search query changed |
| `@close` | Modal closed |

## Styling

```css
.global-search-modal {
  @apply bg-white dark:bg-gray-800;
}

.global-search-result {
  @apply hover:bg-gray-100 dark:hover:bg-gray-700;
}

.global-search-ai-answer {
  @apply bg-blue-50 dark:bg-blue-900/20;
}
```
