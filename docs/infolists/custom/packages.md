---
title: Packages
description: Required packages for infolists
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
concept: packages
---

# Packages

NPM packages used by infolist components.

## Core Packages

| Package | Purpose |
|---------|---------|
| `radix-vue` | Accessible UI primitives |
| `lucide-vue-next` | Icon library |
| `shiki` | Code syntax highlighting |
| `@vueuse/core` | Vue composables |

## Installation

```bash
npm install radix-vue lucide-vue-next shiki @vueuse/core
```

## Package Usage

### Radix Vue

```vue
<script setup>
import { Tabs, TabsList, TabsTrigger, TabsContent } from 'radix-vue'
</script>
```

### Lucide Icons

```vue
<script setup>
import { User, Mail, Phone } from 'lucide-vue-next'
</script>
```

### Shiki Highlighting

```vue
<script setup>
import { codeToHtml } from 'shiki'

const highlighted = await codeToHtml(code, {
  lang: 'php',
  theme: 'github-dark'
})
</script>
```

### VueUse Composables

```vue
<script setup>
import { useClipboard, useDark } from '@vueuse/core'

const { copy } = useClipboard()
const isDark = useDark()
</script>
```

## Tailwind CSS

```bash
npm install tailwindcss @tailwindcss/typography
```
