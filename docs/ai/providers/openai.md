---
title: OpenAI Provider
description: GPT models integration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
provider: openai
---

# OpenAI Provider

Integration with OpenAI GPT models.

## Supported Models

| Model | Description |
|-------|-------------|
| gpt-4o | Latest multimodal |
| gpt-4o-mini | Fast and affordable |
| gpt-4-turbo | High capability |
| gpt-4 | Original GPT-4 |
| gpt-3.5-turbo | Fast responses |
| o1-preview | Reasoning model |
| o1-mini | Compact reasoning |

## Configuration

```env
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4o-mini
```

## Usage

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('openai')->chat([
    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
    ['role' => 'user', 'content' => 'Hello!'],
]);

echo $response['content'];
print_r($response['usage']);
```

## Advanced Options

```php
<?php

use Laravilt\AI\AIManager;

$response = $ai->provider('openai')->chat($messages, [
    'temperature' => 0.8,
    'top_p' => 0.9,
    'presence_penalty' => 0.6,
    'frequency_penalty' => 0.5,
    'max_tokens' => 2048,
]);
```

## Streaming

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

foreach ($ai->provider('openai')->streamChat($messages) as $chunk) {
    echo $chunk;
    flush();
}
```
