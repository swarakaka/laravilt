---
title: Perplexity Provider
description: Perplexity Sonar models integration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
provider: perplexity
---

# Perplexity Provider

Integration with Perplexity Sonar models for real-time web search.

## Supported Models

| Model | Description |
|-------|-------------|
| sonar | Real-time web search |
| sonar-pro | Enhanced search |
| sonar-reasoning | With reasoning |

## Configuration

```env
PERPLEXITY_API_KEY=...
PERPLEXITY_MODEL=llama-3.1-sonar-small-128k-online
```

## Usage

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('perplexity')->chat([
    ['role' => 'user', 'content' => 'What are the latest Laravel 12 features?'],
]);

echo $response['content'];
```

## Real-Time Search

Perplexity models have built-in web search:

```php
<?php

use Laravilt\AI\AIManager;

// Get current information
$response = $ai->provider('perplexity')->chat([
    ['role' => 'user', 'content' => 'Current PHP version and release date?'],
]);

// Response includes up-to-date web data
echo $response['content'];
```

## Use Cases

- Current events research
- Real-time data queries
- Documentation lookups
- News and updates
