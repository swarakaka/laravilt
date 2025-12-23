---
title: Gemini Provider
description: Google Gemini models integration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
provider: gemini
---

# Gemini Provider

Integration with Google Gemini models.

## Supported Models

| Model | Description |
|-------|-------------|
| gemini-2.0-flash | Latest fast model |
| gemini-1.5-pro | High capability |
| gemini-1.5-flash | Fast responses |
| gemini-pro | Original model |

## Configuration

```env
GEMINI_API_KEY=...
GEMINI_MODEL=gemini-2.0-flash-exp
```

## Usage

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('gemini')->chat([
    ['role' => 'user', 'content' => 'Hello!'],
]);

echo $response['content'];
```

## Advanced Options

```php
<?php

use Laravilt\AI\AIManager;

$response = $ai->provider('gemini')->chat($messages, [
    'temperature' => 0.7,
    'topP' => 0.9,
    'topK' => 40,
    'maxOutputTokens' => 2048,
]);
```

## Message Conversion

Gemini uses different message format. The provider automatically converts:

```php
<?php

// Standard format (auto-converted)
$messages = [
    ['role' => 'user', 'content' => 'Hello'],
    ['role' => 'assistant', 'content' => 'Hi!'],
    ['role' => 'user', 'content' => 'How are you?'],
];

$response = $ai->provider('gemini')->chat($messages);
```
