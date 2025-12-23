---
title: Architecture
description: Understanding Laravilt's modular architecture
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Architecture

Laravilt uses a modular, layered architecture.

## Package Layers

```
┌─────────────────────────────────────┐
│          LARAVILT (Meta)            │
├─────────────────────────────────────┤
│  AI  │  Plugins  │  Auth            │  ← Advanced
├─────────────────────────────────────┤
│              Panel                  │  ← Integration
├─────────────────────────────────────┤
│  Forms │ Tables │ Infolists │Widgets│  ← Core 2
├─────────────────────────────────────┤
│ Schemas │ Query-Builder │ Actions   │  ← Core 1
├─────────────────────────────────────┤
│              Support                │  ← Foundation
└─────────────────────────────────────┘
```

## Core Concepts

### Panels

Self-contained admin interfaces:

```php
$panel
    ->id('admin')
    ->path('admin')
    ->login()
    ->discoverResources(in: app_path('Laravilt/Admin/Resources'));
```

### Resources

CRUD entities with forms, tables, and actions:

```php
class UserResource extends Resource
{
    protected static string $model = User::class;

    public static function form(Schema $form): Schema { }
    public static function table(Table $table): Table { }
}
```

### Components

All UI elements use fluent builder pattern:

```php
TextInput::make('email')
    ->email()
    ->required()
    ->maxLength(255);
```

## Data Flow

```
HTTP Request
    ↓
Laravel Router → Panel Middleware → Controller
    ↓
Inertia Response (JSON props)
    ↓
Vue Component (renders UI)
```

## Frontend Stack

- **Inertia.js v2** - Laravel + Vue integration
- **Vue 3** - Reactive UI framework
- **shadcn/ui** - UI component library
- **Tailwind CSS** - Utility-first styling

## Next Steps

- [Data Flow](data-flow) - How data flows through the system
- [Packages](packages) - Package details
- [Panel](../panel/introduction) - Panel configuration
- [Support](../support/introduction) - Base utilities
