---
title: AI Chat
description: Chat interface with streaming
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
vue_component: AIChat
vue_package: "@vueuse/core"
---

# AI Chat

Full-featured chat interface with streaming.

## Overview

| Topic | Description |
|-------|-------------|
| [Streaming](streaming) | Real-time responses |
| [Sessions](sessions) | Message persistence |
| [Vue Components](vue-components) | Frontend integration |

## Features

- Real-time streaming responses
- Session management
- Provider/model selection
- @ mentions for resource context
- Message history
- Copy messages
- Markdown rendering
- Dark mode support

## Enable Chat in Panel

```php
<?php

use Laravilt\AI\AIManager;

$panel->ai(function (AIManager $ai) {
    $ai->chat(enabled: true)
        ->defaultProvider('openai')
        ->defaultModel('gpt-4o-mini')
        ->sessionTimeout(3600);
});
```

## @ Mentions

Reference resources in chat:

```
User: Show me @Products with low stock
AI: [Queries products with stock_quantity < 10]

User: Create a new @User with name John Doe
AI: [Creates user record]
```

## API Endpoints

```
POST /laravilt-ai/chat      # Send message
POST /laravilt-ai/stream    # Stream response
```

## Related

- [Streaming](streaming) - Real-time responses
- [Sessions](sessions) - Message persistence
