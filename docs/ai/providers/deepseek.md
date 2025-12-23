---
title: DeepSeek Provider
description: DeepSeek models integration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
provider: deepseek
---

# DeepSeek Provider

Integration with DeepSeek models.

## Supported Models

| Model | Description |
|-------|-------------|
| deepseek-chat | General chat |
| deepseek-coder | Code generation |
| deepseek-reasoner | R1 reasoning model |

## Configuration

```env
DEEPSEEK_API_KEY=...
DEEPSEEK_MODEL=deepseek-chat
```

## Usage

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('deepseek')->chat([
    ['role' => 'user', 'content' => 'Write a Laravel migration'],
]);

echo $response['content'];
```

## Code Generation

```php
<?php

use Laravilt\AI\AIManager;

$response = $ai->provider('deepseek')->chat([
    ['role' => 'system', 'content' => 'You are an expert Laravel developer.'],
    ['role' => 'user', 'content' => 'Create a User model with relationships'],
], [
    'model' => 'deepseek-coder',
]);
```

## Reasoning Model

```php
<?php

use Laravilt\AI\AIManager;

$response = $ai->provider('deepseek')->chat([
    ['role' => 'user', 'content' => 'Solve this complex problem...'],
], [
    'model' => 'deepseek-reasoner',
]);
```
