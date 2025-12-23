---
title: Frontend
description: Vue 3 components for Laravilt
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
---

# Frontend

Vue 3 components and utilities for building admin panels.

## Technology Stack

| Technology | Description |
|------------|-------------|
| Vue 3 | Composition API with `<script setup>` |
| TypeScript | Full type safety |
| Inertia.js | SPA-like experience |
| Tailwind CSS | Utility-first styling |
| Reka UI | Accessible primitives |
| Lucide Icons | Icon set |

## Installation

```bash
npm install @laravilt/support
```

## Documentation

### UI Components

- [Introduction](ui/introduction) - All UI components
- [Button](ui/button) - Button variants
- [Dialog](ui/dialog) - Modal dialogs
- [Sheet](ui/sheet) - Slide-out panels
- [Card](ui/card) - Content cards
- [Badge](ui/badge) - Status badges
- [Alert](ui/alert) - Alert messages
- [Avatar](ui/avatar) - User avatars
- [Dropdown](ui/dropdown) - Dropdown menus
- [Tabs](ui/tabs) - Tab navigation
- [Tooltip](ui/tooltip) - Tooltips

### Form Components

- [Introduction](forms/introduction) - Form components
- [Input](forms/input) - Text inputs
- [Select](forms/select) - Select dropdowns
- [Checkbox](forms/checkbox) - Checkboxes
- [Switch](forms/switch) - Toggle switches

### Chart Components

- [Introduction](charts/introduction) - Chart components
- [Line Chart](charts/line) - Line charts
- [Bar Chart](charts/bar) - Bar charts
- [Pie Chart](charts/pie) - Pie charts

## Quick Example

```vue
<script setup lang="ts">
import { Button } from '@laravilt/support'
import { Badge } from '@laravilt/support'
</script>

<template>
    <Button variant="primary">
        Click Me
        <Badge>New</Badge>
    </Button>
</template>
```

## Related

- [Styling](styling) - Tailwind CSS
- [Layouts](layouts) - Page layouts
- [Utilities](utilities) - Helper functions

