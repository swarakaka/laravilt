---
title: Plugin Components
description: Generate plugin components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: components
---

# Plugin Components

Generate components within plugins.

## Generate Command

```bash
php artisan laravilt:make {plugin} {type} {name}
```

## Available Types

| Type | Description |
|------|-------------|
| `resource` | Panel Resource |
| `migration` | Database Migration |
| `model` | Eloquent Model |
| `controller` | Controller |
| `command` | Artisan Command |
| `job` | Queue Job |
| `event` | Event Class |
| `listener` | Event Listener |
| `notification` | Notification |
| `seeder` | Database Seeder |
| `factory` | Model Factory |
| `test` | Test Class |
| `lang` | Language File |
| `route` | Route File |

## Examples

```bash
# Model
php artisan laravilt:make blog-manager model Post

# Migration (creates create_posts_table)
php artisan laravilt:make blog-manager migration Post

# Resource (creates full CRUD structure)
php artisan laravilt:make blog-manager resource Post

# Command
php artisan laravilt:make blog-manager command SyncPosts

# Test
php artisan laravilt:make blog-manager test PostTest

# Language file
php artisan laravilt:make blog-manager lang en
```

## Output Locations

| Type | Path |
|------|------|
| Resource | `src/Resources/{Plural}/` |
| Model | `src/Models/` |
| Migration | `database/migrations/` |
| Controller | `src/Http/Controllers/` |
| Command | `src/Commands/` |
| Job | `src/Jobs/` |
| Event | `src/Events/` |
| Listener | `src/Listeners/` |
| Notification | `src/Notifications/` |
| Seeder | `database/seeders/` |
| Factory | `database/factories/` |
| Test | `tests/Feature/` |
| Lang | `resources/lang/{name}/` |
| Route | `routes/` |

## Related

- [Models](models) - Model generation
- [Resources](resources) - Resource generation

