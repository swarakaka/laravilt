---
title: Custom Infolist Entries
description: Creating custom Vue components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
concept: custom
---

# Custom Infolist Entries

Create custom Vue components for infolists.

## Overview

| Topic | Description |
|-------|-------------|
| [Vue Components](vue-components) | Component structure |
| [Creating Entries](creating-entries) | PHP entry classes |
| [Packages](packages) | Required packages |

## Entry Architecture

```
PHP Entry Class → JSON Schema → Vue Component
```

## Quick Start

1. Create PHP entry class
2. Define Vue component name
3. Create Vue component
4. Register component

## Example

```php
<?php

use Laravilt\Infolists\Entries\Entry;

class RatingEntry extends Entry
{
    protected string $view = 'infolist-rating-entry';

    protected int $maxStars = 5;

    public function maxStars(int $max): static
    {
        $this->maxStars = $max;
        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'maxStars' => $this->maxStars,
        ]);
    }
}
```

## Related

- [Vue Components](vue-components) - Vue setup
- [Creating Entries](creating-entries) - PHP classes
