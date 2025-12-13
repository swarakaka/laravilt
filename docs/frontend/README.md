---
title: Frontend Documentation
description: Vue 3 components and frontend architecture for Laravilt admin panels.
---

# Frontend Documentation

Laravilt's frontend is built with Vue 3, TypeScript, and Inertia.js. This documentation covers the Vue components, utilities, and patterns used in the admin panel.

## Technology Stack

- **Vue 3** - Composition API with `<script setup>` syntax
- **TypeScript** - Full type safety across the frontend
- **Inertia.js** - SPA-like experience without API complexity
- **Tailwind CSS** - Utility-first styling
- **Reka UI** - Accessible Vue component primitives
- **Lucide Icons** - Beautiful icon set

## Directory Structure

```
resources/js/
├── components/          # Reusable Vue components
│   ├── laravilt/       # Laravilt-specific components
│   └── ui/             # Base UI components (Reka UI)
├── composables/        # Vue composables (hooks)
├── layouts/            # Page layouts
├── lib/                # Utilities (utils.ts)
├── pages/              # Inertia pages
│   ├── laravilt/       # Admin panel pages
│   └── Landing/        # Public landing pages
└── types/              # TypeScript interfaces
```

## Key Components

### Navigation Components

- **NavMain.vue** - Sidebar navigation with groups, badges, and active state detection
- **NavUser.vue** - User dropdown menu
- **NavFooter.vue** - Sidebar footer content
- **AppHeader.vue** - Top header with global search

### UI Components

Located in `components/ui/`:

- **sidebar/** - Collapsible sidebar with group support
- **dialog/** - Modal dialogs
- **dropdown-menu/** - Context menus
- **button/** - Button variants
- **input/** - Form inputs
- **select/** - Dropdown selects
- **badge/** - Status badges
- **card/** - Content cards
- **tabs/** - Tab navigation

## Quick Links

- [Components](/docs/frontend/components)
- [Utilities](/docs/frontend/utilities)
- [Layouts](/docs/frontend/layouts)
- [Styling](/docs/frontend/styling)
- [TypeScript Types](/docs/frontend/types)
