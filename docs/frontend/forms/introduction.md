---
title: Form Components
description: Vue 3 form input components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_package: "@laravilt/support"
---

# Form Components

Standalone Vue 3 form input components.

## Installation

```bash
npm install @laravilt/support
```

## Available Components

| Component | Description | Import |
|-----------|-------------|--------|
| Input | Text input | `@laravilt/support` |
| Textarea | Multi-line input | `@laravilt/support` |
| Select | Dropdown select | `@laravilt/support` |
| Checkbox | Checkbox input | `@laravilt/support` |
| Switch | Toggle switch | `@laravilt/support` |
| Radio | Radio buttons | `@laravilt/support` |
| Label | Form label | `@laravilt/support` |

## Quick Example

```vue
<script setup lang="ts">
import { ref } from 'vue'
import { Input, Label, Button } from '@laravilt/support'

const email = ref('')
</script>

<template>
    <form @submit.prevent="submit">
        <div class="grid gap-4">
            <div class="grid gap-2">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    v-model="email"
                    type="email"
                    placeholder="Enter email"
                />
            </div>
            <Button type="submit">Submit</Button>
        </div>
    </form>
</template>
```

## Form Layout

```vue
<template>
    <form class="space-y-4">
        <div class="grid gap-2">
            <Label>Name</Label>
            <Input v-model="name" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="grid gap-2">
                <Label>First Name</Label>
                <Input v-model="firstName" />
            </div>
            <div class="grid gap-2">
                <Label>Last Name</Label>
                <Input v-model="lastName" />
            </div>
        </div>

        <div class="flex items-center gap-2">
            <Checkbox id="terms" v-model="terms" />
            <Label for="terms">Accept terms</Label>
        </div>

        <Button type="submit">Submit</Button>
    </form>
</template>
```

## Related

- [Input](input) - Text input
- [Select](select) - Select dropdown
- [Checkbox](checkbox) - Checkbox input
- [Switch](switch) - Toggle switch

