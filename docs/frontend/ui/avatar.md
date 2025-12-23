---
title: Avatar
description: User avatar component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Avatar
vue_package: "@laravilt/support"
---

# Avatar

User avatar with image and fallback.

## Import

```typescript
import { Avatar, AvatarImage, AvatarFallback } from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <Avatar>
        <AvatarImage src="/avatar.jpg" alt="User" />
        <AvatarFallback>JD</AvatarFallback>
    </Avatar>
</template>
```

## Sizes

```vue
<template>
    <Avatar class="h-8 w-8">
        <AvatarImage src="/avatar.jpg" />
        <AvatarFallback>SM</AvatarFallback>
    </Avatar>

    <Avatar class="h-10 w-10">
        <AvatarImage src="/avatar.jpg" />
        <AvatarFallback>MD</AvatarFallback>
    </Avatar>

    <Avatar class="h-14 w-14">
        <AvatarImage src="/avatar.jpg" />
        <AvatarFallback>LG</AvatarFallback>
    </Avatar>
</template>
```

## With Fallback

```vue
<script setup>
const getInitials = (name: string) => {
    return name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
}
</script>

<template>
    <Avatar>
        <AvatarImage :src="user.avatar" :alt="user.name" />
        <AvatarFallback>{{ getInitials(user.name) }}</AvatarFallback>
    </Avatar>
</template>
```

## Avatar Group

```vue
<template>
    <div class="flex -space-x-2">
        <Avatar v-for="user in users" :key="user.id" class="border-2 border-white">
            <AvatarImage :src="user.avatar" :alt="user.name" />
            <AvatarFallback>{{ user.initials }}</AvatarFallback>
        </Avatar>
        <Avatar v-if="moreCount > 0" class="border-2 border-white">
            <AvatarFallback>+{{ moreCount }}</AvatarFallback>
        </Avatar>
    </div>
</template>
```

## With Status

```vue
<template>
    <div class="relative">
        <Avatar>
            <AvatarImage src="/avatar.jpg" />
            <AvatarFallback>JD</AvatarFallback>
        </Avatar>
        <span
            class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 ring-2 ring-white"
        />
    </div>
</template>
```

## In User List

```vue
<template>
    <div class="flex items-center gap-3">
        <Avatar>
            <AvatarImage :src="user.avatar" />
            <AvatarFallback>{{ user.initials }}</AvatarFallback>
        </Avatar>
        <div>
            <p class="font-medium">{{ user.name }}</p>
            <p class="text-sm text-muted-foreground">{{ user.email }}</p>
        </div>
    </div>
</template>
```

## Components

| Component | Description |
|-----------|-------------|
| `Avatar` | Root container |
| `AvatarImage` | Image element |
| `AvatarFallback` | Fallback content |

## Related

- [Card](card) - User cards
- [Dropdown](dropdown) - User menus

