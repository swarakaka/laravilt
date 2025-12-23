---
title: Sheet
description: Slide-out panel component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Sheet
vue_package: "@laravilt/support"
---

# Sheet

Slide-out panel from screen edge.

## Import

```typescript
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
    SheetClose,
} from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <Sheet>
        <SheetTrigger as-child>
            <Button>Open Sheet</Button>
        </SheetTrigger>
        <SheetContent>
            <SheetHeader>
                <SheetTitle>Sheet Title</SheetTitle>
                <SheetDescription>
                    Sheet description goes here.
                </SheetDescription>
            </SheetHeader>
            <div class="py-4">
                Sheet content...
            </div>
            <SheetFooter>
                <SheetClose as-child>
                    <Button>Close</Button>
                </SheetClose>
            </SheetFooter>
        </SheetContent>
    </Sheet>
</template>
```

## Sides

```vue
<template>
    <!-- Right (default) -->
    <Sheet>
        <SheetTrigger as-child>
            <Button>Right</Button>
        </SheetTrigger>
        <SheetContent side="right">...</SheetContent>
    </Sheet>

    <!-- Left -->
    <Sheet>
        <SheetTrigger as-child>
            <Button>Left</Button>
        </SheetTrigger>
        <SheetContent side="left">...</SheetContent>
    </Sheet>

    <!-- Top -->
    <Sheet>
        <SheetTrigger as-child>
            <Button>Top</Button>
        </SheetTrigger>
        <SheetContent side="top">...</SheetContent>
    </Sheet>

    <!-- Bottom -->
    <Sheet>
        <SheetTrigger as-child>
            <Button>Bottom</Button>
        </SheetTrigger>
        <SheetContent side="bottom">...</SheetContent>
    </Sheet>
</template>
```

## With Form

```vue
<script setup>
import { ref } from 'vue'

const name = ref('')
const email = ref('')
</script>

<template>
    <Sheet>
        <SheetTrigger as-child>
            <Button>Edit Profile</Button>
        </SheetTrigger>
        <SheetContent>
            <SheetHeader>
                <SheetTitle>Edit Profile</SheetTitle>
                <SheetDescription>
                    Update your profile information.
                </SheetDescription>
            </SheetHeader>
            <div class="grid gap-4 py-4">
                <div class="grid gap-2">
                    <Label>Name</Label>
                    <Input v-model="name" />
                </div>
                <div class="grid gap-2">
                    <Label>Email</Label>
                    <Input v-model="email" type="email" />
                </div>
            </div>
            <SheetFooter>
                <Button type="submit">Save Changes</Button>
            </SheetFooter>
        </SheetContent>
    </Sheet>
</template>
```

## Components

| Component | Description |
|-----------|-------------|
| `Sheet` | Root container |
| `SheetTrigger` | Trigger button |
| `SheetContent` | Panel content |
| `SheetHeader` | Header section |
| `SheetTitle` | Title text |
| `SheetDescription` | Description |
| `SheetFooter` | Footer actions |
| `SheetClose` | Close button |

## Props (SheetContent)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `side` | `string` | `right` | Panel side |

## Related

- [Dialog](dialog) - Modal dialogs
- [Button](button) - Trigger buttons

