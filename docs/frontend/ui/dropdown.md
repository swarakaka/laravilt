---
title: Dropdown Menu
description: Dropdown menu component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: DropdownMenu
vue_package: "@laravilt/support"
---

# Dropdown Menu

Context menus and dropdown actions.

## Import

```typescript
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
    DropdownMenuGroup,
    DropdownMenuShortcut,
} from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="outline">Options</Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent>
            <DropdownMenuItem>Profile</DropdownMenuItem>
            <DropdownMenuItem>Settings</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem>Logout</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
```

## With Labels

```vue
<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="outline">My Account</Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-56">
            <DropdownMenuLabel>My Account</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuGroup>
                <DropdownMenuItem>
                    <User class="mr-2 h-4 w-4" />
                    Profile
                </DropdownMenuItem>
                <DropdownMenuItem>
                    <Settings class="mr-2 h-4 w-4" />
                    Settings
                </DropdownMenuItem>
            </DropdownMenuGroup>
            <DropdownMenuSeparator />
            <DropdownMenuItem>
                <LogOut class="mr-2 h-4 w-4" />
                Logout
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
```

## With Shortcuts

```vue
<template>
    <DropdownMenuContent>
        <DropdownMenuItem>
            New Tab
            <DropdownMenuShortcut>⌘T</DropdownMenuShortcut>
        </DropdownMenuItem>
        <DropdownMenuItem>
            New Window
            <DropdownMenuShortcut>⌘N</DropdownMenuShortcut>
        </DropdownMenuItem>
    </DropdownMenuContent>
</template>
```

## Destructive Items

```vue
<template>
    <DropdownMenuContent>
        <DropdownMenuItem>Edit</DropdownMenuItem>
        <DropdownMenuItem>Duplicate</DropdownMenuItem>
        <DropdownMenuSeparator />
        <DropdownMenuItem class="text-red-600">
            <Trash class="mr-2 h-4 w-4" />
            Delete
        </DropdownMenuItem>
    </DropdownMenuContent>
</template>
```

## With Checkbox

```vue
<script setup>
import { ref } from 'vue'
import { DropdownMenuCheckboxItem } from '@laravilt/support'

const showPanel = ref(true)
</script>

<template>
    <DropdownMenuCheckboxItem v-model:checked="showPanel">
        Show Panel
    </DropdownMenuCheckboxItem>
</template>
```

## Components

| Component | Description |
|-----------|-------------|
| `DropdownMenu` | Root container |
| `DropdownMenuTrigger` | Trigger button |
| `DropdownMenuContent` | Menu content |
| `DropdownMenuItem` | Menu item |
| `DropdownMenuLabel` | Section label |
| `DropdownMenuSeparator` | Divider |
| `DropdownMenuGroup` | Item group |
| `DropdownMenuShortcut` | Keyboard shortcut |
| `DropdownMenuCheckboxItem` | Checkbox item |

## Related

- [Button](button) - Trigger buttons
- [Sheet](sheet) - Slide-out panels

