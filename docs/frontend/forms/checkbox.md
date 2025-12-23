---
title: Checkbox
description: Checkbox input component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Checkbox
vue_package: "@laravilt/support"
---

# Checkbox

Checkbox input component.

## Import

```typescript
import { Checkbox } from '@laravilt/support'
```

## Basic Usage

```vue
<script setup>
import { ref } from 'vue'
import { Checkbox } from '@laravilt/support'

const checked = ref(false)
</script>

<template>
    <Checkbox v-model:checked="checked" />
</template>
```

## With Label

```vue
<script setup>
import { Checkbox, Label } from '@laravilt/support'
</script>

<template>
    <div class="flex items-center gap-2">
        <Checkbox id="terms" v-model:checked="accepted" />
        <Label for="terms">Accept terms and conditions</Label>
    </div>
</template>
```

## Checkbox Group

```vue
<script setup>
import { ref } from 'vue'

const selected = ref<string[]>([])
</script>

<template>
    <div class="space-y-2">
        <div class="flex items-center gap-2">
            <Checkbox
                id="email"
                :checked="selected.includes('email')"
                @update:checked="toggleOption('email')"
            />
            <Label for="email">Email notifications</Label>
        </div>
        <div class="flex items-center gap-2">
            <Checkbox
                id="sms"
                :checked="selected.includes('sms')"
                @update:checked="toggleOption('sms')"
            />
            <Label for="sms">SMS notifications</Label>
        </div>
        <div class="flex items-center gap-2">
            <Checkbox
                id="push"
                :checked="selected.includes('push')"
                @update:checked="toggleOption('push')"
            />
            <Label for="push">Push notifications</Label>
        </div>
    </div>
</template>
```

## Disabled

```vue
<template>
    <div class="flex items-center gap-2">
        <Checkbox id="disabled" disabled />
        <Label for="disabled" class="text-muted-foreground">
            Disabled option
        </Label>
    </div>

    <div class="flex items-center gap-2">
        <Checkbox id="checked-disabled" disabled checked />
        <Label for="checked-disabled" class="text-muted-foreground">
            Checked and disabled
        </Label>
    </div>
</template>
```

## In Form

```vue
<template>
    <form @submit.prevent="submit" class="space-y-4">
        <div class="grid gap-2">
            <Label>Name</Label>
            <Input v-model="name" />
        </div>

        <div class="space-y-2">
            <Label>Preferences</Label>
            <div class="flex items-center gap-2">
                <Checkbox id="newsletter" v-model:checked="newsletter" />
                <Label for="newsletter">Subscribe to newsletter</Label>
            </div>
            <div class="flex items-center gap-2">
                <Checkbox id="updates" v-model:checked="updates" />
                <Label for="updates">Receive product updates</Label>
            </div>
        </div>

        <Button type="submit">Save</Button>
    </form>
</template>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `checked` | `boolean` | `false` | Checked state |
| `disabled` | `boolean` | `false` | Disabled state |
| `id` | `string` | - | Element ID |

## Related

- [Switch](switch) - Toggle switch
- [Radio](../ui/introduction) - Radio buttons

