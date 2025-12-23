---
title: AI Package
description: Enterprise-grade AI integration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
vue_component: AIChat
vue_package: "@vueuse/core"
---

# AI Package

Enterprise-grade AI integration for Laravilt applications.

## Features

| Feature | Description |
|---------|-------------|
| [Providers](providers/introduction) | OpenAI, Anthropic, Gemini, DeepSeek |
| [Agents](agents/introduction) | Resource-aware AI assistants |
| [Tools](tools/introduction) | Function calling & CRUD |
| [Chat](chat/introduction) | Streaming chat interface |
| [Search](search/introduction) | AI-powered global search |

## Quick Start

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('openai')->chat([
    ['role' => 'user', 'content' => 'Hello!'],
]);

echo $response['content'];
```

## Configuration

```env
# Default provider
AI_DEFAULT_PROVIDER=openai

# OpenAI
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4o-mini

# Anthropic
ANTHROPIC_API_KEY=sk-ant-...
ANTHROPIC_MODEL=claude-sonnet-4-20250514
```

## Use Cases

- Chat Interface - AI conversations with streaming
- Resource Agents - CRUD operations via AI
- Global Search - Natural language search
- Tool Calling - Custom function execution
