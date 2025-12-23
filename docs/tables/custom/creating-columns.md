---
title: Creating Columns
description: Create custom table columns
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: custom
---

# Creating Columns

Create custom table columns.

## Step 1: PHP Column Class

Create `app/Tables/Columns/ProgressColumn.php`:

```php
<?php

namespace App\Tables\Columns;

use Closure;
use Laravilt\Tables\Columns\Column;

class ProgressColumn extends Column
{
    protected string $view = 'tables.columns.progress';

    protected int|Closure $max = 100;
    protected string|Closure $color = 'primary';

    public function max(int|Closure $max): static
    {
        $this->max = $max;
        return $this;
    }

    public function color(string|Closure $color): static
    {
        $this->color = $color;
        return $this;
    }

    public function toLaraviltProps(): array
    {
        return array_merge(parent::toLaraviltProps(), [
            'max' => $this->evaluate($this->max),
            'color' => $this->evaluate($this->color),
        ]);
    }
}
```

## Step 2: Vue Component

Create `resources/js/components/tables/ProgressColumn.vue`:

```vue
<template>
  <div class="w-full">
    <Progress :value="percentage" :class="colorClass" />
    <span class="text-xs">{{ value }}/{{ max }}</span>
  </div>
</template>

<script setup lang="ts">
import { Progress } from '@/components/ui/progress'
import { computed } from 'vue'

const props = defineProps<{
  value: number
  max?: number
  color?: string
}>()

const percentage = computed(() => (props.value / (props.max || 100)) * 100)
</script>
```

## Step 3: Register

```typescript
import ProgressColumn from '@/components/tables/ProgressColumn.vue'

export const tableColumns = {
  'progress-column': ProgressColumn,
}
```

## Step 4: Usage

```php
<?php

use App\Tables\Columns\ProgressColumn;

ProgressColumn::make('completion')
    ->max(100)
    ->color('success');
```
