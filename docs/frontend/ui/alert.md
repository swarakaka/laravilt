---
title: Alert
description: Alert message component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_component: Alert
vue_package: "@laravilt/support"
---

# Alert

Display alert messages.

## Import

```typescript
import { Alert, AlertTitle, AlertDescription } from '@laravilt/support'
```

## Basic Usage

```vue
<template>
    <Alert>
        <AlertTitle>Heads up!</AlertTitle>
        <AlertDescription>
            This is an informational alert message.
        </AlertDescription>
    </Alert>
</template>
```

## Variants

```vue
<template>
    <Alert variant="default">
        <AlertTitle>Default</AlertTitle>
        <AlertDescription>Default alert message.</AlertDescription>
    </Alert>

    <Alert variant="success">
        <AlertTitle>Success</AlertTitle>
        <AlertDescription>Operation completed.</AlertDescription>
    </Alert>

    <Alert variant="warning">
        <AlertTitle>Warning</AlertTitle>
        <AlertDescription>Please review this.</AlertDescription>
    </Alert>

    <Alert variant="destructive">
        <AlertTitle>Error</AlertTitle>
        <AlertDescription>Something went wrong.</AlertDescription>
    </Alert>
</template>
```

## With Icon

```vue
<script setup>
import { Alert, AlertTitle, AlertDescription } from '@laravilt/support'
import { AlertCircle, CheckCircle, Info } from 'lucide-vue-next'
</script>

<template>
    <Alert variant="destructive">
        <AlertCircle class="h-4 w-4" />
        <AlertTitle>Error</AlertTitle>
        <AlertDescription>
            Your session has expired. Please login again.
        </AlertDescription>
    </Alert>

    <Alert variant="success">
        <CheckCircle class="h-4 w-4" />
        <AlertTitle>Success</AlertTitle>
        <AlertDescription>
            Your changes have been saved.
        </AlertDescription>
    </Alert>
</template>
```

## Dismissible

```vue
<script setup>
import { ref } from 'vue'

const showAlert = ref(true)
</script>

<template>
    <Alert v-if="showAlert" variant="warning">
        <AlertTitle>Warning</AlertTitle>
        <AlertDescription>
            This action cannot be undone.
        </AlertDescription>
        <Button
            variant="ghost"
            size="icon"
            class="absolute right-2 top-2"
            @click="showAlert = false"
        >
            <X class="h-4 w-4" />
        </Button>
    </Alert>
</template>
```

## Components

| Component | Description |
|-----------|-------------|
| `Alert` | Root container |
| `AlertTitle` | Title text |
| `AlertDescription` | Description |

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `default` | Alert style |

## Related

- [Badge](badge) - Status badges
- [Card](card) - Content cards

