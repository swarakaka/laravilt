---
title: Card
description: Content card component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Card
vue_package: "@laravilt/support"
---

# Card

Content container with header and footer.

## Import

```typescript
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
    CardAction,
} from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <Card>
        <CardHeader>
            <CardTitle>Card Title</CardTitle>
            <CardDescription>Card description</CardDescription>
        </CardHeader>
        <CardContent>
            <p>Card content goes here.</p>
        </CardContent>
        <CardFooter>
            <Button>Action</Button>
        </CardFooter>
    </Card>
</template>
```

## With Action

```vue
<template>
    <Card>
        <CardHeader>
            <div class="flex items-center justify-between">
                <CardTitle>Users</CardTitle>
                <CardAction>
                    <Button size="sm">Add User</Button>
                </CardAction>
            </div>
        </CardHeader>
        <CardContent>
            <p>User list...</p>
        </CardContent>
    </Card>
</template>
```

## Stats Card

```vue
<template>
    <Card>
        <CardHeader class="pb-2">
            <CardDescription>Total Revenue</CardDescription>
            <CardTitle class="text-3xl">$45,231</CardTitle>
        </CardHeader>
        <CardContent>
            <p class="text-xs text-muted-foreground">
                +20.1% from last month
            </p>
        </CardContent>
    </Card>
</template>
```

## Grid of Cards

```vue
<template>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <Card v-for="item in items" :key="item.id">
            <CardHeader>
                <CardTitle>{{ item.title }}</CardTitle>
            </CardHeader>
            <CardContent>
                {{ item.description }}
            </CardContent>
        </Card>
    </div>
</template>
```

## With Image

```vue
<template>
    <Card class="overflow-hidden">
        <img
            src="/image.jpg"
            alt="Cover"
            class="h-48 w-full object-cover"
        />
        <CardHeader>
            <CardTitle>Image Card</CardTitle>
        </CardHeader>
        <CardContent>
            <p>Card with cover image.</p>
        </CardContent>
    </Card>
</template>
```

## Components

| Component | Description |
|-----------|-------------|
| `Card` | Root container |
| `CardHeader` | Header section |
| `CardTitle` | Title text |
| `CardDescription` | Description |
| `CardContent` | Main content |
| `CardFooter` | Footer actions |
| `CardAction` | Header actions |

## Related

- [Badge](badge) - Status badges
- [Button](button) - Action buttons

