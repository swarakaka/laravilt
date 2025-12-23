---
title: Agent Configuration
description: Configure AI agents
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
concept: configuration
---

# Agent Configuration

Configure AI agents for optimal performance.

## Environment Variables

```env
# Default provider
LARAVILT_AI_PROVIDER=openai

# OpenAI
OPENAI_API_KEY=your-api-key
OPENAI_MODEL=gpt-4o-mini

# Anthropic
ANTHROPIC_API_KEY=your-api-key
ANTHROPIC_MODEL=claude-sonnet-4-20250514

# Google Gemini
GOOGLE_AI_API_KEY=your-api-key
GOOGLE_AI_MODEL=gemini-2.0-flash-exp
```

## Config File

```php
<?php

// config/laravilt-ai.php
return [
    'default' => env('LARAVILT_AI_PROVIDER', 'openai'),

    'providers' => [
        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'temperature' => 0.7,
            'max_tokens' => 2048,
        ],
        'anthropic' => [
            'api_key' => env('ANTHROPIC_API_KEY'),
            'model' => env('ANTHROPIC_MODEL', 'claude-sonnet-4-20250514'),
        ],
    ],
];
```

## Model Selection

```php
<?php

use Laravilt\AI\Enums\OpenAIModel;
use Laravilt\AI\Enums\AnthropicModel;

// Set provider and model on agent
$agent
    ->provider('openai')
    ->aiModel(OpenAIModel::GPT_4O_MINI);

// Or use string
$agent
    ->provider('anthropic')
    ->aiModel('claude-sonnet-4-20250514');
```

## Provider Settings

Temperature and tokens are set in config file:

```php
<?php

// config/laravilt-ai.php
'providers' => [
    'openai' => [
        'temperature' => 0.7, // 0.0-1.0
        'max_tokens' => 2048,
    ],
],
```

## Best Practices

- Use `gpt-4o-mini` for simple queries
- Use `gpt-4o` for complex reasoning
- Set `canDelete(false)` by default
- Define clear system prompts
- Configure temperature in config file
