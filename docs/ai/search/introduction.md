---
title: Global Search
description: AI-powered search
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
vue_component: GlobalSearch
vue_package: "radix-vue"
---

# Global Search

AI-powered global search with natural language understanding.

## Overview

| Topic | Description |
|-------|-------------|
| [Configuration](configuration) | Setup and options |
| [Vue Components](vue-components) | Frontend integration |

## Features

- Search across all resources
- Natural language queries
- Keyboard shortcuts (⌘K)
- AI-powered understanding
- Real-time results

## Enable Global Search

```php
<?php

use Laravilt\Panel\Panel;

Panel::make()
    ->globalSearch()
    ->globalSearchKeyBindings(['ctrl+k', 'cmd+k'])
    ->globalSearchUseAI()
    ->globalSearchDebounce(300);
```

## AI Search Examples

| Query | AI Understanding |
|-------|-----------------|
| "orders from last week" | Filters by date |
| "products under $50" | Filters by price |
| "low stock items" | Finds low inventory |
| "pending shipments" | Filters by status |

## Keyboard Shortcuts

| Shortcut | Action |
|----------|--------|
| `⌘K` / `Ctrl+K` | Open search |
| `↑` / `↓` | Navigate results |
| `Enter` | Select result |
| `Esc` | Close search |
| `Tab` | Toggle AI mode |

## API Endpoint

```
GET /laravilt-ai/search?q=query&useAI=true
```

## Related

- [Configuration](configuration) - Setup options
- [Vue Components](vue-components) - Frontend
