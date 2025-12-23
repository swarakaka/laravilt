---
title: UI Components
description: Standalone Vue 3 UI components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: frontend
vue_package: "@laravilt/support"
---

# UI Components

Standalone Vue 3 components that can be used in any project.

## Installation

```bash
npm install @laravilt/support
```

## Available Components

| Component | Description | Import |
|-----------|-------------|--------|
| Button | Button variants | `@laravilt/support` |
| Dialog | Modal dialogs | `@laravilt/support` |
| Sheet | Slide-out panels | `@laravilt/support` |
| Card | Content cards | `@laravilt/support` |
| Badge | Status badges | `@laravilt/support` |
| Alert | Alert messages | `@laravilt/support` |
| Avatar | User avatars | `@laravilt/support` |
| Dropdown | Dropdown menus | `@laravilt/support` |
| Tabs | Tab navigation | `@laravilt/support` |
| Tooltip | Tooltips | `@laravilt/support` |
| Collapsible | Collapsible content | `@laravilt/support` |
| Breadcrumb | Navigation breadcrumbs | `@laravilt/support` |
| Spinner | Loading spinners | `@laravilt/support` |

## Quick Import

```typescript
// Individual imports
import { Button } from '@laravilt/support'
import { Dialog, DialogContent, DialogTrigger } from '@laravilt/support'
import { Card, CardHeader, CardContent } from '@laravilt/support'

// Or import all
import * as UI from '@laravilt/support'
```

## Component Categories

### Feedback

- [Alert](alert) - Display messages
- [Badge](badge) - Status indicators
- [Spinner](spinner) - Loading states
- [Tooltip](tooltip) - Hover hints

### Layout

- [Card](card) - Content containers
- [Collapsible](collapsible) - Expandable content
- [Tabs](tabs) - Tab panels

### Overlays

- [Dialog](dialog) - Modal dialogs
- [Sheet](sheet) - Slide-out panels
- [Dropdown](dropdown) - Dropdown menus

### Navigation

- [Breadcrumb](breadcrumb) - Page location
- [Tabs](tabs) - Tab navigation

### Data Display

- [Avatar](avatar) - User images
- [Badge](badge) - Labels

## Related

- [Button](button) - Button component
- [Dialog](dialog) - Dialog component
- [Card](card) - Card component

