---
title: Button
description: Button component with variants
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Button
vue_package: "@laravilt/support"
---

# Button

Button component with multiple variants and sizes.

## Import

```typescript
import { Button } from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <Button>Click Me</Button>
</template>
```

## Variants

```vue
<template>
    <Button variant="default">Default</Button>
    <Button variant="primary">Primary</Button>
    <Button variant="secondary">Secondary</Button>
    <Button variant="destructive">Destructive</Button>
    <Button variant="outline">Outline</Button>
    <Button variant="ghost">Ghost</Button>
    <Button variant="link">Link</Button>
</template>
```

## Sizes

```vue
<template>
    <Button size="sm">Small</Button>
    <Button size="default">Default</Button>
    <Button size="lg">Large</Button>
    <Button size="icon">
        <PlusIcon />
    </Button>
</template>
```

## With Icon

```vue
<script setup>
import { Button } from '@laravilt/support'
import { Plus, Download } from 'lucide-vue-next'
</script>

<template>
    <Button>
        <Plus class="mr-2 h-4 w-4" />
        Add Item
    </Button>

    <Button variant="outline">
        <Download class="mr-2 h-4 w-4" />
        Download
    </Button>
</template>
```

## Loading State

```vue
<script setup>
import { ref } from 'vue'
import { Button } from '@laravilt/support'

const loading = ref(false)
</script>

<template>
    <Button :disabled="loading">
        <Spinner v-if="loading" class="mr-2" />
        {{ loading ? 'Loading...' : 'Submit' }}
    </Button>
</template>
```

## As Link

```vue
<template>
    <Button as="a" href="/dashboard">
        Go to Dashboard
    </Button>
</template>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `default` | Button style |
| `size` | `string` | `default` | Button size |
| `disabled` | `boolean` | `false` | Disabled state |
| `as` | `string` | `button` | HTML element |

## Variants

| Value | Description |
|-------|-------------|
| `default` | Default style |
| `primary` | Primary action |
| `secondary` | Secondary action |
| `destructive` | Danger/delete |
| `outline` | Bordered |
| `ghost` | No background |
| `link` | Link style |

## Related

- [Dialog](dialog) - Use with dialogs
- [Dropdown](dropdown) - Dropdown triggers

