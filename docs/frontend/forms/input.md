---
title: Input
description: Text input component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Input
vue_package: "@laravilt/support"
---

# Input

Text input component.

## Import

```typescript
import { Input } from '@laravilt/support'
```

## Basic Usage

```vue
<script setup>
import { ref } from 'vue'
import { Input } from '@laravilt/support'

const value = ref('')
</script>

<template>
    <Input v-model="value" placeholder="Enter text..." />
</template>
```

## Types

```vue
<template>
    <Input type="text" placeholder="Text" />
    <Input type="email" placeholder="Email" />
    <Input type="password" placeholder="Password" />
    <Input type="number" placeholder="Number" />
    <Input type="tel" placeholder="Phone" />
    <Input type="url" placeholder="URL" />
    <Input type="search" placeholder="Search" />
</template>
```

## With Label

```vue
<script setup>
import { Input, Label } from '@laravilt/support'
</script>

<template>
    <div class="grid gap-2">
        <Label for="email">Email</Label>
        <Input id="email" type="email" placeholder="Enter email" />
    </div>
</template>
```

## With Icon

```vue
<script setup>
import { Mail, Lock, Search } from 'lucide-vue-next'
</script>

<template>
    <div class="relative">
        <Mail class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
        <Input class="pl-9" placeholder="Email" />
    </div>

    <div class="relative">
        <Search class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
        <Input class="pl-9" placeholder="Search..." />
    </div>
</template>
```

## Disabled

```vue
<template>
    <Input disabled value="Disabled input" />
</template>
```

## With Error

```vue
<template>
    <div class="grid gap-2">
        <Label for="email">Email</Label>
        <Input
            id="email"
            type="email"
            class="border-red-500"
            placeholder="Enter email"
        />
        <p class="text-sm text-red-500">Invalid email address</p>
    </div>
</template>
```

## File Input

```vue
<template>
    <Input type="file" accept="image/*" />
</template>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | `string` | `text` | Input type |
| `placeholder` | `string` | - | Placeholder |
| `disabled` | `boolean` | `false` | Disabled state |
| `modelValue` | `string` | - | v-model value |

## Related

- [Label](../ui/introduction) - Form label
- [Button](../ui/button) - Submit button

