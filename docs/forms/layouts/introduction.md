---
title: Layout Components
description: Form structure and organization
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: layouts
---

# Layout Components

Structure and organize form fields.

## Available Components

| Component | Description | Vue Pattern |
|-----------|-------------|-------------|
| `Section` | Grouped fields with header | Card component |
| `Grid` | Column-based layout | CSS Grid |
| `Tabs` | Tabbed interface | Tabs from shadcn/ui |
| `Wizard` | Multi-step form | Stepper component |
| `Fieldset` | HTML fieldset | Native fieldset |

## Section

```php
<?php

use Laravilt\Schemas\Components\Section;
use Laravilt\Forms\Components\TextInput;

Section::make('Contact Information')
    ->description('How to reach the user')
    ->icon('Phone')
    ->collapsible()
    ->schema([
        TextInput::make('phone'),
        TextInput::make('address'),
    ])
    ->columns(2);
```

## Grid

```php
<?php

use Laravilt\Schemas\Components\Grid;

Grid::make()
    ->columns([
        'default' => 1,
        'sm' => 2,
        'lg' => 4,
    ])
    ->schema([...]);
```

## Tabs

```php
<?php

use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;

Tabs::make()
    ->tabs([
        Tab::make('basic')
            ->label('Basic')
            ->icon('User')
            ->schema([...]),
        Tab::make('advanced')
            ->label('Advanced')
            ->schema([...]),
    ]);
```

## Wizard

```php
<?php

use Laravilt\Schemas\Components\Wizard;
use Laravilt\Schemas\Components\Step;

Wizard::make()
    ->steps([
        Step::make('account')
            ->label('Account')
            ->schema([...]),
        Step::make('profile')
            ->label('Profile')
            ->schema([...]),
    ]);
```

## Vue Components

```vue
<script setup>
import { Tabs, TabsList, TabsTrigger, TabsContent } from '@/components/ui/tabs'
import { Card, CardHeader, CardContent } from '@/components/ui/card'
</script>
```

## Related

- [Section](section) - Field grouping
- [Grid](grid) - Column layouts
- [Tabs](tabs) - Tabbed forms
- [Wizard](wizard) - Multi-step forms
