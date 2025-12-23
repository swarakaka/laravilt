---
title: Dialog
description: Modal dialog component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Dialog
vue_package: "@laravilt/support"
---

# Dialog

Modal dialog for confirmations and forms.

## Import

```typescript
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    DialogClose,
} from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button>Open Dialog</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Dialog Title</DialogTitle>
                <DialogDescription>
                    Dialog description goes here.
                </DialogDescription>
            </DialogHeader>
            <p>Dialog content...</p>
            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">Cancel</Button>
                </DialogClose>
                <Button>Confirm</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
```

## Controlled Dialog

```vue
<script setup>
import { ref } from 'vue'

const open = ref(false)
</script>

<template>
    <Button @click="open = true">Open</Button>

    <Dialog v-model:open="open">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Controlled Dialog</DialogTitle>
            </DialogHeader>
            <p>This dialog is controlled externally.</p>
            <DialogFooter>
                <Button @click="open = false">Close</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
```

## Confirmation Dialog

```vue
<script setup>
import { ref } from 'vue'

const showConfirm = ref(false)

const handleDelete = () => {
    // Delete logic
    showConfirm.value = false
}
</script>

<template>
    <Dialog v-model:open="showConfirm">
        <DialogTrigger as-child>
            <Button variant="destructive">Delete</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Delete Item</DialogTitle>
                <DialogDescription>
                    Are you sure? This action cannot be undone.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">Cancel</Button>
                </DialogClose>
                <Button variant="destructive" @click="handleDelete">
                    Delete
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
```

## With Form

```vue
<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button>Create User</Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Create User</DialogTitle>
            </DialogHeader>
            <form @submit.prevent="submit">
                <div class="grid gap-4 py-4">
                    <Input v-model="name" placeholder="Name" />
                    <Input v-model="email" type="email" placeholder="Email" />
                </div>
                <DialogFooter>
                    <Button type="submit">Create</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
```

## Components

| Component | Description |
|-----------|-------------|
| `Dialog` | Root container |
| `DialogTrigger` | Trigger button |
| `DialogContent` | Dialog content |
| `DialogHeader` | Header section |
| `DialogTitle` | Title text |
| `DialogDescription` | Description text |
| `DialogFooter` | Footer actions |
| `DialogClose` | Close button |

## Related

- [Sheet](sheet) - Slide-out panel
- [Button](button) - Trigger buttons

