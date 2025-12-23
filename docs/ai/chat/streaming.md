---
title: Streaming
description: Real-time AI responses
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
concept: streaming
---

# Streaming

Real-time streaming responses using SSE.

## Basic Streaming

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

foreach ($ai->provider('openai')->streamChat($messages) as $chunk) {
    echo $chunk;
    flush();
}
```

## Streaming with Callback

```php
<?php

use Laravilt\AI\AIManager;

$provider = $ai->provider('openai');

$provider->streamChatRealtime(
    messages: [['role' => 'user', 'content' => 'Write a story']],
    callback: function ($chunk) {
        echo $chunk;
        flush();
    }
);
```

## Streaming with Tools

```php
<?php

use Laravilt\AI\AIManager;

$messages = [
    ['role' => 'user', 'content' => 'Find the 3 cheapest products'],
];

$tools = $agent->getTools();

foreach ($ai->provider()->streamChatWithTools($messages, $tools) as $event) {
    if ($event['type'] === 'text') {
        echo $event['content'];
    } elseif ($event['type'] === 'tool_call') {
        $result = $event['tool']->handle($event['arguments']);
        $messages[] = [
            'role' => 'tool',
            'content' => json_encode($result),
            'tool_call_id' => $event['id'],
        ];
    }
}
```

## Vue Integration

```vue
<script setup lang="ts">
import { ref } from 'vue'

const response = ref('')

async function streamChat(messages: Message[]) {
  const eventSource = new EventSource('/laravilt-ai/stream')

  eventSource.onmessage = (event) => {
    response.value += event.data
  }
}
</script>
```

## Best Practices

- Enable streaming for better UX
- Handle connection errors gracefully
- Show typing indicators
- Buffer chunks for smooth display
