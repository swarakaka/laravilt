---
title: Anthropic Provider
description: Claude models integration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
provider: anthropic
---

# Anthropic Provider

Integration with Anthropic Claude models.

## Supported Models

| Model | Description |
|-------|-------------|
| claude-sonnet-4 | Latest balanced |
| claude-opus-4 | Most capable |
| claude-3.5-sonnet | Fast and smart |
| claude-3.5-haiku | Fastest |
| claude-3-opus | Previous flagship |
| claude-3-sonnet | Balanced |
| claude-3-haiku | Compact |

## Configuration

```env
ANTHROPIC_API_KEY=sk-ant-...
ANTHROPIC_MODEL=claude-sonnet-4-20250514
```

## Usage

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('anthropic')->chat([
    ['role' => 'user', 'content' => 'Hello!'],
], [
    'system' => 'You are a helpful assistant.',
]);

echo $response['content'];
```

## System Messages

Claude handles system messages separately:

```php
<?php

use Laravilt\AI\AIManager;

$response = $ai->provider('anthropic')->chat([
    ['role' => 'user', 'content' => 'Question'],
], [
    'system' => 'You are an expert in Laravel.',
    'temperature' => 0.7,
    'max_tokens' => 4096,
]);
```

## Streaming

```php
<?php

use Laravilt\AI\AIManager;

foreach ($ai->provider('anthropic')->streamChat($messages) as $chunk) {
    echo $chunk;
    flush();
}
```
