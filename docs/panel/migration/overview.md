---
title: Migrating from Filament
description: Convert Filament PHP apps to Laravilt
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Migrating from Filament

Automated migration tool to convert Filament PHP v3/v4 to Laravilt.

## Prerequisites

- Working Filament PHP v3 or v4 application
- Laravilt packages installed
- Backup of current codebase

## Quick Start

```bash
php artisan laravilt:filament
```

This will:
1. Scan your `app/Filament` directory
2. Display available resources, pages, widgets
3. Let you select components to migrate
4. Generate Laravilt-compatible files

## Command Options

```bash
# Custom source directory
php artisan laravilt:filament --source=app/Filament/Admin

# Custom target directory
php artisan laravilt:filament --target=app/Laravilt/Backend

# Set panel name
php artisan laravilt:filament --panel=Admin

# Preview changes without modifying files
php artisan laravilt:filament --dry-run

# Overwrite existing files
php artisan laravilt:filament --force

# Migrate all (skip interactive)
php artisan laravilt:filament --all
```

## Full Example

```bash
php artisan laravilt:filament \
    --source=app/Filament/Admin/Resources \
    --target=app/Laravilt/Admin \
    --panel=Admin \
    --force \
    --all
```

## Next Steps

- [Namespace Mappings](namespace-mappings) - Class mappings
- [Post-Migration](post-migration) - Checklist and adjustments
