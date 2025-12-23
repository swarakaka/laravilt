---
title: Tooltip
description: Tooltip component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Tooltip
vue_package: "@laravilt/support"
---

# Tooltip

Hover hint component.

## Import

```typescript
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <TooltipProvider>
        <Tooltip>
            <TooltipTrigger as-child>
                <Button variant="outline">Hover Me</Button>
            </TooltipTrigger>
            <TooltipContent>
                <p>This is a tooltip</p>
            </TooltipContent>
        </Tooltip>
    </TooltipProvider>
</template>
```

## Positions

```vue
<template>
    <TooltipProvider>
        <Tooltip>
            <TooltipTrigger as-child>
                <Button>Top</Button>
            </TooltipTrigger>
            <TooltipContent side="top">Tooltip on top</TooltipContent>
        </Tooltip>

        <Tooltip>
            <TooltipTrigger as-child>
                <Button>Bottom</Button>
            </TooltipTrigger>
            <TooltipContent side="bottom">Tooltip on bottom</TooltipContent>
        </Tooltip>

        <Tooltip>
            <TooltipTrigger as-child>
                <Button>Left</Button>
            </TooltipTrigger>
            <TooltipContent side="left">Tooltip on left</TooltipContent>
        </Tooltip>

        <Tooltip>
            <TooltipTrigger as-child>
                <Button>Right</Button>
            </TooltipTrigger>
            <TooltipContent side="right">Tooltip on right</TooltipContent>
        </Tooltip>
    </TooltipProvider>
</template>
```

## Icon Button with Tooltip

```vue
<script setup>
import { Settings, Trash, Edit } from 'lucide-vue-next'
</script>

<template>
    <TooltipProvider>
        <div class="flex gap-2">
            <Tooltip>
                <TooltipTrigger as-child>
                    <Button variant="ghost" size="icon">
                        <Edit class="h-4 w-4" />
                    </Button>
                </TooltipTrigger>
                <TooltipContent>Edit</TooltipContent>
            </Tooltip>

            <Tooltip>
                <TooltipTrigger as-child>
                    <Button variant="ghost" size="icon">
                        <Trash class="h-4 w-4" />
                    </Button>
                </TooltipTrigger>
                <TooltipContent>Delete</TooltipContent>
            </Tooltip>

            <Tooltip>
                <TooltipTrigger as-child>
                    <Button variant="ghost" size="icon">
                        <Settings class="h-4 w-4" />
                    </Button>
                </TooltipTrigger>
                <TooltipContent>Settings</TooltipContent>
            </Tooltip>
        </div>
    </TooltipProvider>
</template>
```

## Components

| Component | Description |
|-----------|-------------|
| `TooltipProvider` | Context provider |
| `Tooltip` | Root container |
| `TooltipTrigger` | Trigger element |
| `TooltipContent` | Tooltip content |

## Props (TooltipContent)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `side` | `string` | `top` | Position |
| `sideOffset` | `number` | `4` | Offset from trigger |

## Related

- [Button](button) - With tooltips
- [Dropdown](dropdown) - Menus

