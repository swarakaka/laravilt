---
title: Creating Entries
description: Custom PHP entry classes
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
concept: creating-entries
---

# Creating Entries

Create custom PHP entry classes for infolists.

## Basic Entry

```php
<?php

namespace App\Infolists\Entries;

use Laravilt\Infolists\Entries\Entry;

class ProgressEntry extends Entry
{
    protected string $view = 'infolist-progress-entry';

    protected int $max = 100;
    protected string $color = 'primary';

    public function max(int $max): static
    {
        $this->max = $max;
        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;
        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'max' => $this->max,
            'color' => $this->color,
        ]);
    }
}
```

## Usage

```php
<?php

use App\Infolists\Entries\ProgressEntry;

ProgressEntry::make('completion')
    ->max(100)
    ->color('success');
```

## With Closure State

```php
<?php

namespace App\Infolists\Entries;

use Laravilt\Infolists\Entries\Entry;
use Closure;

class ChartEntry extends Entry
{
    protected string $view = 'infolist-chart-entry';

    protected array|Closure $data = [];

    public function data(array|Closure $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function getState(): mixed
    {
        $data = $this->evaluate($this->data);
        return $data;
    }
}
```

## Extending Existing

```php
<?php

namespace App\Infolists\Entries;

use Laravilt\Infolists\Entries\TextEntry;

class TruncatedTextEntry extends TextEntry
{
    protected int $maxLength = 50;

    public function maxLength(int $length): static
    {
        $this->maxLength = $length;
        return $this;
    }
}
```
