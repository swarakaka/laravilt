---
title: Vue Components
description: Table Vue component patterns
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: custom
---

# Vue Components

Vue component patterns for tables.

## Table Component

```vue
<script setup lang="ts">
import {
  useVueTable,
  getCoreRowModel,
  getSortedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
} from '@tanstack/vue-table'

const table = useVueTable({
  data: props.records,
  columns: props.columns,
  getCoreRowModel: getCoreRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
})
</script>
```

## Column Cell Component

```vue
<script setup lang="ts">
defineProps<{
  value: unknown
  record: Record<string, unknown>
  column: ColumnDef
}>()
</script>

<template>
  <div class="table-cell">
    <slot :value="value" :record="record" />
  </div>
</template>
```

## Row Actions Component

```vue
<script setup lang="ts">
import { DropdownMenu } from '@/components/ui/dropdown-menu'
import { MoreHorizontal } from 'lucide-vue-next'

defineProps<{
  record: Record<string, unknown>
  actions: Action[]
}>()
</script>
```

## Bulk Selection

```vue
<script setup>
import { Checkbox } from '@/components/ui/checkbox'

const selectedRows = ref<Set<string>>(new Set())

function toggleAll(checked: boolean) {
  if (checked) {
    records.value.forEach(r => selectedRows.value.add(r.id))
  } else {
    selectedRows.value.clear()
  }
}
</script>
```
