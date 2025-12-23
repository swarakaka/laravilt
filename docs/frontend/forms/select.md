---
title: Select
description: Select dropdown component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Select
vue_package: "@laravilt/support"
---

# Select

Dropdown select component.

## Import

```typescript
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
    SelectGroup,
    SelectLabel,
} from '@laravilt/support'
```

## Basic Usage

```vue
<script setup>
import { ref } from 'vue'

const value = ref('')
</script>

<template>
    <Select v-model="value">
        <SelectTrigger class="w-[200px]">
            <SelectValue placeholder="Select option" />
        </SelectTrigger>
        <SelectContent>
            <SelectItem value="option1">Option 1</SelectItem>
            <SelectItem value="option2">Option 2</SelectItem>
            <SelectItem value="option3">Option 3</SelectItem>
        </SelectContent>
    </Select>
</template>
```

## With Groups

```vue
<template>
    <Select v-model="value">
        <SelectTrigger class="w-[200px]">
            <SelectValue placeholder="Select fruit" />
        </SelectTrigger>
        <SelectContent>
            <SelectGroup>
                <SelectLabel>Fruits</SelectLabel>
                <SelectItem value="apple">Apple</SelectItem>
                <SelectItem value="banana">Banana</SelectItem>
            </SelectGroup>
            <SelectGroup>
                <SelectLabel>Vegetables</SelectLabel>
                <SelectItem value="carrot">Carrot</SelectItem>
                <SelectItem value="potato">Potato</SelectItem>
            </SelectGroup>
        </SelectContent>
    </Select>
</template>
```

## With Label

```vue
<script setup>
import { Label } from '@laravilt/support'
</script>

<template>
    <div class="grid gap-2">
        <Label>Country</Label>
        <Select v-model="country">
            <SelectTrigger>
                <SelectValue placeholder="Select country" />
            </SelectTrigger>
            <SelectContent>
                <SelectItem value="us">United States</SelectItem>
                <SelectItem value="uk">United Kingdom</SelectItem>
                <SelectItem value="ca">Canada</SelectItem>
            </SelectContent>
        </Select>
    </div>
</template>
```

## Disabled

```vue
<template>
    <Select disabled>
        <SelectTrigger>
            <SelectValue placeholder="Disabled" />
        </SelectTrigger>
        <SelectContent>
            <SelectItem value="1">Option 1</SelectItem>
        </SelectContent>
    </Select>
</template>
```

## Dynamic Options

```vue
<script setup>
const options = [
    { value: '1', label: 'Option 1' },
    { value: '2', label: 'Option 2' },
    { value: '3', label: 'Option 3' },
]
</script>

<template>
    <Select v-model="value">
        <SelectTrigger>
            <SelectValue placeholder="Select option" />
        </SelectTrigger>
        <SelectContent>
            <SelectItem
                v-for="option in options"
                :key="option.value"
                :value="option.value"
            >
                {{ option.label }}
            </SelectItem>
        </SelectContent>
    </Select>
</template>
```

## Components

| Component | Description |
|-----------|-------------|
| `Select` | Root container |
| `SelectTrigger` | Trigger button |
| `SelectValue` | Selected value |
| `SelectContent` | Dropdown content |
| `SelectItem` | Option item |
| `SelectGroup` | Option group |
| `SelectLabel` | Group label |

## Related

- [Input](input) - Text input
- [Checkbox](checkbox) - Checkbox

