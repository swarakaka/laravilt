---
title: Switch
description: Toggle switch component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Switch
vue_package: "@laravilt/support"
---

# Switch

Toggle switch component.

## Import

```typescript
import { Switch } from '@laravilt/support'
```

## Basic Usage

```vue
<script setup>
import { ref } from 'vue'
import { Switch } from '@laravilt/support'

const enabled = ref(false)
</script>

<template>
    <Switch v-model:checked="enabled" />
</template>
```

## With Label

```vue
<script setup>
import { Switch, Label } from '@laravilt/support'
</script>

<template>
    <div class="flex items-center gap-2">
        <Switch id="notifications" v-model:checked="notifications" />
        <Label for="notifications">Enable notifications</Label>
    </div>
</template>
```

## Settings List

```vue
<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <Label>Email Notifications</Label>
                <p class="text-sm text-muted-foreground">
                    Receive email updates
                </p>
            </div>
            <Switch v-model:checked="emailNotifications" />
        </div>

        <div class="flex items-center justify-between">
            <div>
                <Label>Push Notifications</Label>
                <p class="text-sm text-muted-foreground">
                    Receive push updates
                </p>
            </div>
            <Switch v-model:checked="pushNotifications" />
        </div>

        <div class="flex items-center justify-between">
            <div>
                <Label>Marketing Emails</Label>
                <p class="text-sm text-muted-foreground">
                    Receive marketing content
                </p>
            </div>
            <Switch v-model:checked="marketingEmails" />
        </div>
    </div>
</template>
```

## Disabled

```vue
<template>
    <div class="flex items-center gap-2">
        <Switch disabled />
        <Label class="text-muted-foreground">Disabled</Label>
    </div>

    <div class="flex items-center gap-2">
        <Switch disabled checked />
        <Label class="text-muted-foreground">Disabled (on)</Label>
    </div>
</template>
```

## In Card

```vue
<template>
    <Card>
        <CardHeader>
            <CardTitle>Notifications</CardTitle>
            <CardDescription>
                Manage your notification preferences
            </CardDescription>
        </CardHeader>
        <CardContent class="space-y-4">
            <div class="flex items-center justify-between">
                <Label>All notifications</Label>
                <Switch v-model:checked="allNotifications" />
            </div>
            <div class="flex items-center justify-between">
                <Label>Email digest</Label>
                <Switch v-model:checked="emailDigest" />
            </div>
        </CardContent>
    </Card>
</template>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `checked` | `boolean` | `false` | Checked state |
| `disabled` | `boolean` | `false` | Disabled state |
| `id` | `string` | - | Element ID |

## Related

- [Checkbox](checkbox) - Checkbox input
- [Card](../ui/card) - Content cards

