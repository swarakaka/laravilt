---
title: Sessions
description: Chat session management
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
component: AISession
---

# Sessions

Manage chat sessions with message history.

## Create Session

```php
<?php

use Laravilt\AI\Models\AISession;

$session = AISession::create([
    'user_id' => auth()->id(),
    'metadata' => [
        'provider' => 'openai',
        'model' => 'gpt-4o-mini',
    ],
]);
```

## Add Messages

```php
<?php

use Laravilt\AI\Models\AISession;

$session->addMessage([
    'role' => 'user',
    'content' => 'Hello!',
]);

$session->addMessage([
    'role' => 'assistant',
    'content' => 'Hi! How can I help you?',
]);
```

## Load Session

```php
<?php

use Laravilt\AI\Models\AISession;
use Laravilt\AI\AIManager;

$session = AISession::find($sessionId);
$messages = $session->messages;

// Continue conversation
$ai = app(AIManager::class);
$newResponse = $ai->provider()->chat([
    ...$messages,
    ['role' => 'user', 'content' => 'What were we talking about?'],
]);
```

## Session Endpoints

```
GET    /laravilt-ai/sessions          # List sessions
POST   /laravilt-ai/sessions          # Create session
GET    /laravilt-ai/sessions/{id}     # Get session
PATCH  /laravilt-ai/sessions/{id}     # Update session
DELETE /laravilt-ai/sessions/{id}     # Delete session
```

## Session Timeout

```php
<?php

$panel->ai(function ($ai) {
    $ai->sessionTimeout(3600); // 1 hour
});
```

## Clear Old Sessions

```php
<?php

use Laravilt\AI\Models\AISession;

// Delete sessions older than 7 days
AISession::where('updated_at', '<', now()->subDays(7))->delete();
```
