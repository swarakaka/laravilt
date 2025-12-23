---
title: Badge
description: Status badge component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Badge
vue_package: "@laravilt/support"
---

# Badge

Status indicator badges.

## Import

```typescript
import { Badge } from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <Badge>Default</Badge>
</template>
```

## Variants

```vue
<template>
    <Badge variant="default">Default</Badge>
    <Badge variant="primary">Primary</Badge>
    <Badge variant="secondary">Secondary</Badge>
    <Badge variant="success">Success</Badge>
    <Badge variant="warning">Warning</Badge>
    <Badge variant="danger">Danger</Badge>
    <Badge variant="info">Info</Badge>
    <Badge variant="outline">Outline</Badge>
</template>
```

## With Icon

```vue
<script setup>
import { Badge } from '@laravilt/support'
import { Check, X, Clock } from 'lucide-vue-next'
</script>

<template>
    <Badge variant="success">
        <Check class="mr-1 h-3 w-3" />
        Approved
    </Badge>

    <Badge variant="danger">
        <X class="mr-1 h-3 w-3" />
        Rejected
    </Badge>

    <Badge variant="warning">
        <Clock class="mr-1 h-3 w-3" />
        Pending
    </Badge>
</template>
```

## In Table

```vue
<template>
    <table>
        <tr v-for="user in users" :key="user.id">
            <td>{{ user.name }}</td>
            <td>
                <Badge :variant="user.active ? 'success' : 'secondary'">
                    {{ user.active ? 'Active' : 'Inactive' }}
                </Badge>
            </td>
        </tr>
    </table>
</template>
```

## Notification Count

```vue
<template>
    <Button variant="ghost" class="relative">
        <Bell class="h-5 w-5" />
        <Badge
            v-if="count > 0"
            variant="danger"
            class="absolute -right-1 -top-1 h-5 w-5 p-0"
        >
            {{ count }}
        </Badge>
    </Button>
</template>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `default` | Badge style |

## Variants

| Value | Description |
|-------|-------------|
| `default` | Default gray |
| `primary` | Primary blue |
| `secondary` | Secondary gray |
| `success` | Success green |
| `warning` | Warning yellow |
| `danger` | Danger red |
| `info` | Info sky |
| `outline` | Bordered |

## Related

- [Button](button) - With badges
- [Card](card) - In cards

