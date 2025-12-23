---
title: AI Providers
description: Multi-provider AI support
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
concept: providers
---

# AI Providers

Multi-provider support for AI integrations.

## Supported Providers

| Provider | Models |
|----------|--------|
| [OpenAI](openai) | GPT-4o, GPT-4, GPT-3.5 |
| [Anthropic](anthropic) | Claude Sonnet 4, Opus 4, 3.5 |
| [Gemini](gemini) | Gemini 2.0, 1.5 Pro/Flash |
| [DeepSeek](deepseek) | Chat, Coder, Reasoner |
| [Perplexity](perplexity) | Sonar, Sonar Pro |

## Configuration

```php
<?php

// config/laravilt-ai.php
return [
    'default_provider' => env('AI_DEFAULT_PROVIDER', 'openai'),

    'providers' => [
        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'temperature' => 0.7,
            'max_tokens' => 4096,
        ],
        'anthropic' => [
            'api_key' => env('ANTHROPIC_API_KEY'),
            'model' => env('ANTHROPIC_MODEL', 'claude-sonnet-4-20250514'),
        ],
    ],
];
```

## Using Providers

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

// Use specific provider
$response = $ai->provider('anthropic')->chat($messages);

// Check if configured
if ($ai->isConfigured()) {
    // AI is ready
}
```
