---
title: Plugin Structure
description: Plugin directory structure
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: structure
---

# Plugin Structure

Standard plugin directory layout.

## Directory Tree

```
packages/vendor/plugin-name/
├── config/
│   └── laravilt-plugin-name.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── views/
│   └── lang/
│       ├── en/
│       └── ar/
├── routes/
│   ├── web.php
│   └── api.php
├── src/
│   ├── PluginNamePlugin.php
│   ├── PluginNameServiceProvider.php
│   ├── Commands/
│   ├── Models/
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
├── tests/
│   ├── Pest.php
│   └── TestCase.php
├── composer.json
└── README.md
```

## Key Files

| File | Purpose |
|------|---------|
| `PluginNamePlugin.php` | Main plugin class |
| `PluginNameServiceProvider.php` | Service provider |
| `config/*.php` | Configuration |
| `Commands/InstallCommand.php` | Install command |

## Naming Conventions

| Item | Convention |
|------|------------|
| Plugin ID | `kebab-case` |
| Class Name | `PascalCase` |
| Namespace | `Vendor\PluginName` |
| Config File | `laravilt-plugin-name.php` |

## Related

- [Installation](installation) - Create plugins
- [Plugin Classes](../concepts/plugin-classes) - Architecture
