---
title: Frontend
description: Vue 3 components and frontend architecture
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
---

# Frontend Documentation

Vue 3 components for building admin panels with Laravilt.

## Technology Stack

| Technology | Description |
|------------|-------------|
| Vue 3 | Composition API with `<script setup>` |
| TypeScript | Full type safety |
| Inertia.js v2 | SPA-like experience |
| Tailwind CSS | Utility-first styling |
| Reka UI | Accessible primitives |
| Lucide Icons | Icon library |

## Installation

```bash
npm install @laravilt/support @laravilt/schemas
```

---

## Documentation

### [UI Components](ui/introduction)

Standalone UI components for any Vue project.

| Component | Description |
|-----------|-------------|
| [Button](ui/button) | Button variants and sizes |
| [Dialog](ui/dialog) | Modal dialogs |
| [Sheet](ui/sheet) | Slide-out panels |
| [Card](ui/card) | Content cards |
| [Badge](ui/badge) | Status badges |
| [Alert](ui/alert) | Alert messages |
| [Avatar](ui/avatar) | User avatars |
| [Dropdown](ui/dropdown) | Dropdown menus |
| [Tabs](ui/tabs) | Tab navigation |
| [Tooltip](ui/tooltip) | Hover tooltips |

### [Form Components](forms/introduction)

Form input components with validation.

| Component | Description |
|-----------|-------------|
| [Input](forms/input) | Text inputs |
| [Select](forms/select) | Select dropdowns |
| [Checkbox](forms/checkbox) | Checkboxes |
| [Switch](forms/switch) | Toggle switches |

### [Chart Components](charts/introduction)

Dashboard chart components.

| Component | Description |
|-----------|-------------|
| LineChart | Line/area charts |
| BarChart | Bar charts |
| PieChart | Pie/doughnut charts |
| StatsCard | Statistics cards |

---

## Quick Start

### Import Components

```typescript
// UI Components
import { Button, Dialog, Card, Badge } from '@laravilt/support'

// Form Components
import { Input, Select, Checkbox, Switch } from '@laravilt/support'

// Chart Components
import { LineChart, BarChart, StatsCard } from '@laravilt/schemas'
```

### Example Page

```vue
<script setup lang="ts">
import { ref } from 'vue'
import { Card, CardHeader, CardTitle, CardContent } from '@laravilt/support'
import { Button } from '@laravilt/support'
import { Input, Label } from '@laravilt/support'

const name = ref('')
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Create User</CardTitle>
        </CardHeader>
        <CardContent>
            <form class="space-y-4">
                <div class="grid gap-2">
                    <Label>Name</Label>
                    <Input v-model="name" placeholder="Enter name" />
                </div>
                <Button type="submit">Create</Button>
            </form>
        </CardContent>
    </Card>
</template>
```

---

## Vue Package Mapping

| PHP Package | Vue Package |
|-------------|-------------|
| `laravilt/forms` | `@laravilt/forms` |
| `laravilt/tables` | `@laravilt/tables` |
| `laravilt/schemas` | `@laravilt/schemas` |
| `laravilt/widgets` | `@laravilt/widgets` |
| `laravilt/infolists` | `@laravilt/infolists` |
| `laravilt/notifications` | `@laravilt/notifications` |
| `laravilt/actions` | `@laravilt/actions` |
| `laravilt/support` | `@laravilt/support` |

---

## Related Documentation

- [Introduction](introduction) - Frontend overview
- [Styling](styling) - Tailwind CSS configuration
- [Layouts](layouts) - Page layouts
- [Utilities](utilities) - Helper functions
- [App Components](components) - Application components (NavMain, Page, Form, Table)

## Support

- [Discord Community](https://discord.gg/gyRhbVUXEZ)
- [GitHub Issues](https://github.com/laravilt/laravilt/issues)

