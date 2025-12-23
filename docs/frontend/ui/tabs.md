---
title: Tabs
description: Tab navigation component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Tabs
vue_package: "@laravilt/support"
---

# Tabs

Tab navigation component.

## Import

```typescript
import { Tabs, TabsList, TabsTrigger, TabsContent } from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <Tabs default-value="account">
        <TabsList>
            <TabsTrigger value="account">Account</TabsTrigger>
            <TabsTrigger value="password">Password</TabsTrigger>
        </TabsList>
        <TabsContent value="account">
            Account settings content...
        </TabsContent>
        <TabsContent value="password">
            Password settings content...
        </TabsContent>
    </Tabs>
</template>
```

## With Icons

```vue
<script setup>
import { Tabs, TabsList, TabsTrigger, TabsContent } from '@laravilt/support'
import { User, Lock, Bell } from 'lucide-vue-next'
</script>

<template>
    <Tabs default-value="profile">
        <TabsList>
            <TabsTrigger value="profile">
                <User class="mr-2 h-4 w-4" />
                Profile
            </TabsTrigger>
            <TabsTrigger value="security">
                <Lock class="mr-2 h-4 w-4" />
                Security
            </TabsTrigger>
            <TabsTrigger value="notifications">
                <Bell class="mr-2 h-4 w-4" />
                Notifications
            </TabsTrigger>
        </TabsList>
        <TabsContent value="profile">...</TabsContent>
        <TabsContent value="security">...</TabsContent>
        <TabsContent value="notifications">...</TabsContent>
    </Tabs>
</template>
```

## Controlled Tabs

```vue
<script setup>
import { ref } from 'vue'

const activeTab = ref('account')
</script>

<template>
    <Tabs v-model="activeTab">
        <TabsList>
            <TabsTrigger value="account">Account</TabsTrigger>
            <TabsTrigger value="settings">Settings</TabsTrigger>
        </TabsList>
        <TabsContent value="account">...</TabsContent>
        <TabsContent value="settings">...</TabsContent>
    </Tabs>

    <p>Active: {{ activeTab }}</p>
</template>
```

## Full Width

```vue
<template>
    <Tabs default-value="tab1" class="w-full">
        <TabsList class="w-full">
            <TabsTrigger value="tab1" class="flex-1">Tab 1</TabsTrigger>
            <TabsTrigger value="tab2" class="flex-1">Tab 2</TabsTrigger>
            <TabsTrigger value="tab3" class="flex-1">Tab 3</TabsTrigger>
        </TabsList>
        <TabsContent value="tab1">...</TabsContent>
        <TabsContent value="tab2">...</TabsContent>
        <TabsContent value="tab3">...</TabsContent>
    </Tabs>
</template>
```

## Components

| Component | Description |
|-----------|-------------|
| `Tabs` | Root container |
| `TabsList` | Tab buttons container |
| `TabsTrigger` | Tab button |
| `TabsContent` | Tab content panel |

## Props (Tabs)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `defaultValue` | `string` | - | Default tab |
| `modelValue` | `string` | - | Controlled value |

## Related

- [Card](card) - With tabs
- [Button](button) - Tab triggers

