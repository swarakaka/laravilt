---
title: Polling
description: Auto-refresh table data
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: features
---

# Polling

Auto-refresh table data at intervals.

## Basic Usage

```php
<?php

use Laravilt\Tables\Table;

$table->poll('5s');
```

## Polling Intervals

```php
<?php

use Laravilt\Tables\Table;

$table->poll('5s');   // Every 5 seconds
$table->poll('30s');  // Every 30 seconds
$table->poll('1m');   // Every 1 minute
$table->poll('5m');   // Every 5 minutes
```

## Conditional Polling

```php
<?php

use Laravilt\Tables\Table;

$table->poll(fn () =>
    $this->hasActiveProcesses() ? '5s' : null
);
```

## Stop Polling

```php
<?php

use Laravilt\Tables\Table;

$table->poll(null); // Disable polling
```

## API Reference

| Method | Description |
|--------|-------------|
| `poll()` | Set polling interval |
