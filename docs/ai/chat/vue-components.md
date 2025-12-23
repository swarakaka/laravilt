---
title: Vue Components
description: Chat Vue components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
vue_component: AIChat
vue_package: "@vueuse/core, radix-vue"
---

# Vue Components

Chat interface Vue components.

## AIChat Component

```vue
<script setup lang="ts">
import { AIChat } from '@laravilt/ai'
</script>

<template>
  <AIChat
    :provider="openai"
    :model="gpt-4o-mini"
    placeholder="Ask me anything..."
  />
</template>
```

## With Session

```vue
<script setup lang="ts">
import { ref } from 'vue'
import { AIChat } from '@laravilt/ai'

const sessionId = ref<string | null>(null)
</script>

<template>
  <AIChat
    v-model:session-id="sessionId"
    :provider="openai"
  />
</template>
```

## Custom Message Renderer

```vue
<script setup lang="ts">
import { AIChat } from '@laravilt/ai'
</script>

<template>
  <AIChat>
    <template #message="{ message }">
      <div :class="message.role">
        {{ message.content }}
      </div>
    </template>
  </AIChat>
</template>
```

## Chat Props

| Prop | Type | Description |
|------|------|-------------|
| `provider` | string | AI provider |
| `model` | string | AI model |
| `sessionId` | string | Session ID |
| `placeholder` | string | Input placeholder |
| `systemPrompt` | string | System message |

## Chat Events

| Event | Description |
|-------|-------------|
| `@message` | New message sent |
| `@response` | Response received |
| `@error` | Error occurred |
| `@stream` | Stream chunk received |

## Styling

```css
.ai-chat {
  @apply flex flex-col h-full;
}

.ai-chat-messages {
  @apply flex-1 overflow-y-auto p-4;
}

.ai-chat-input {
  @apply border-t p-4;
}
```
