---
title: Packages
description: Third-party Vue packages for tables
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: custom
---

# Packages

Third-party Vue packages for tables.

## Core Packages

```bash
npm install @tanstack/vue-table radix-vue
```

## TanStack Table

```vue
<script setup>
import {
  useVueTable,
  FlexRender,
  getCoreRowModel,
} from '@tanstack/vue-table'

const table = useVueTable({
  data,
  columns,
  getCoreRowModel: getCoreRowModel(),
})
</script>
```

## Drag & Drop (VueUse)

```bash
npm install @vueuse/integrations sortablejs
```

```vue
<script setup>
import { useSortable } from '@vueuse/integrations/useSortable'

const el = ref<HTMLElement | null>(null)
useSortable(el, items)
</script>
```

## Virtual Scrolling

```bash
npm install @tanstack/vue-virtual
```

```vue
<script setup>
import { useVirtualizer } from '@tanstack/vue-virtual'

const virtualizer = useVirtualizer({
  count: rows.length,
  getScrollElement: () => tableRef.value,
  estimateSize: () => 40,
})
</script>
```

## Export (SheetJS)

```bash
npm install xlsx
```

```typescript
import * as XLSX from 'xlsx'

function exportToExcel(data: any[], filename: string) {
  const ws = XLSX.utils.json_to_sheet(data)
  const wb = XLSX.utils.book_new()
  XLSX.utils.book_append_sheet(wb, ws, 'Sheet1')
  XLSX.writeFile(wb, `${filename}.xlsx`)
}
```
