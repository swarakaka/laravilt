---
title: AI Features FAQ
description: AI integration questions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: faq
---

# AI Features FAQ

Common questions about AI integration.

## Setup

### How do I enable AI features?

Set your API key in `.env`:

```env
LARAVILT_AI_PROVIDER=openai
OPENAI_API_KEY=your-api-key
```

### What providers are supported?

| Provider | Models |
|----------|--------|
| OpenAI | GPT-4, GPT-4o, GPT-3.5 |
| Anthropic | Claude 3.5, Claude 3 |
| Google | Gemini Pro, Gemini Flash |
| DeepSeek | DeepSeek Chat |
| Perplexity | Sonar, Sonar Pro |

### How do I switch providers?

```php
<?php

use Laravilt\AI\Facades\AI;

AI::provider('anthropic')
    ->model('claude-3-5-sonnet')
    ->chat($messages);
```

## Chat

### How do I create a chat?

```php
<?php

use Laravilt\AI\Facades\AI;

$response = AI::chat([
    ['role' => 'user', 'content' => 'Hello!'],
]);
```

### How do I stream responses?

```php
<?php

use Laravilt\AI\Facades\AI;

AI::chat($messages)
    ->stream(function ($chunk) {
        echo $chunk;
    });
```

## Tools

### How do I use AI tools?

```php
<?php

use Laravilt\AI\Facades\AI;
use Laravilt\AI\Tools\SearchTool;

AI::tools([
    SearchTool::make(),
])
->chat($messages);
```

### How do I create custom tools?

```php
<?php

use Laravilt\AI\Tools\Tool;

Tool::make('weather')
    ->description('Get weather info')
    ->parameters([
        'city' => ['type' => 'string', 'required' => true],
    ])
    ->execute(fn ($params) => getWeather($params['city']));
```

## Agents

### How do I create an AI agent?

```php
<?php

use Laravilt\AI\Agent;

Agent::make('assistant')
    ->instructions('You are a helpful assistant.')
    ->tools([...])
    ->run($input);
```

## Related

- [AI Documentation](../ai/introduction)
- [Providers](../ai/providers/introduction)
- [Tools](../ai/tools/introduction)

