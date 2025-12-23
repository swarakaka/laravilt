---
title: Namespace Mappings
description: Filament to Laravilt namespace conversions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Namespace Mappings

## Core Resources

| Filament | Laravilt |
|----------|----------|
| `Filament\Resources\Resource` | `Laravilt\Panel\Resources\Resource` |
| `Filament\Resources\Pages\ListRecords` | `Laravilt\Panel\Pages\ListRecords` |
| `Filament\Resources\Pages\CreateRecord` | `Laravilt\Panel\Pages\CreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Laravilt\Panel\Pages\EditRecord` |

## Forms

| Filament | Laravilt |
|----------|----------|
| `Filament\Forms\Form` | `Laravilt\Schemas\Schema` |
| `Filament\Forms\Components\TextInput` | `Laravilt\Forms\Components\TextInput` |
| `Filament\Forms\Components\Select` | `Laravilt\Forms\Components\Select` |
| `Filament\Forms\Components\Section` | `Laravilt\Schemas\Components\Section` |
| `Filament\Forms\Get` | `Laravilt\Support\Utilities\Get` |
| `Filament\Forms\Set` | `Laravilt\Support\Utilities\Set` |

## Tables

| Filament | Laravilt |
|----------|----------|
| `Filament\Tables\Table` | `Laravilt\Tables\Table` |
| `Filament\Tables\Columns\TextColumn` | `Laravilt\Tables\Columns\TextColumn` |
| `Filament\Tables\Columns\BadgeColumn` | `Laravilt\Tables\Columns\BadgeColumn` |
| `Filament\Tables\Filters\*` | `Laravilt\Tables\Filters\*` |

## Actions

| Filament | Laravilt |
|----------|----------|
| `Filament\Actions\Action` | `Laravilt\Actions\Action` |
| `Filament\Actions\EditAction` | `Laravilt\Actions\EditAction` |
| `Filament\Actions\DeleteAction` | `Laravilt\Actions\DeleteAction` |

## Icons

```php
// Filament (Heroicon)
protected static ?string $navigationIcon = 'heroicon-o-users';

// Laravilt (Lucide)
protected static ?string $navigationIcon = 'Users';
```

## Next Steps

- [Overview](overview) - Migration basics
- [Post-Migration](post-migration) - Checklist and adjustments
