# AI Package Introduction

The AI package provides enterprise-grade AI integration for Laravilt applications with multi-provider support, streaming capabilities, and resource-aware querying.

## Overview

Laravilt AI offers:

- **Multi-Provider Support** - OpenAI, Anthropic Claude, Google Gemini, DeepSeek, Perplexity
- **Real-time Streaming** - Server-Sent Events (SSE) for live responses
- **Tool Calling** - Function calling with automatic tool generation
- **Global Search** - AI-powered Cmd/Ctrl+K spotlight search
- **Chat Interface** - Full-featured chat UI with session management
- **Resource AI Agents** - Per-resource AI capabilities with CRUD operations
- **Session Management** - Persistent chat sessions with message history

---

## Supported Providers

### OpenAI

Models supported:
- GPT-4o
- GPT-4o Mini
- GPT-4 Turbo
- GPT-4
- GPT-3.5 Turbo
- O1 Preview
- O1 Mini

### Anthropic Claude

Models supported:
- Claude Sonnet 4
- Claude Opus 4
- Claude 3.5 Sonnet
- Claude 3.5 Haiku
- Claude 3 Opus
- Claude 3 Sonnet
- Claude 3 Haiku

### Google Gemini

Models supported:
- Gemini 2.0 Flash
- Gemini 1.5 Pro
- Gemini 1.5 Flash
- Gemini Pro

### DeepSeek

Models supported:
- DeepSeek Chat
- DeepSeek Coder
- DeepSeek Reasoner (R1)

### Perplexity

Models supported:
- Sonar
- Sonar Pro
- Sonar Reasoning

---

## Configuration

### Environment Variables

```env
# OpenAI
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4o-mini

# Anthropic
ANTHROPIC_API_KEY=sk-ant-...
ANTHROPIC_MODEL=claude-sonnet-4-20250514

# Google Gemini
GEMINI_API_KEY=...
GEMINI_MODEL=gemini-2.0-flash-exp

# DeepSeek
DEEPSEEK_API_KEY=...
DEEPSEEK_MODEL=deepseek-chat

# Perplexity
PERPLEXITY_API_KEY=...
PERPLEXITY_MODEL=llama-3.1-sonar-small-128k-online
```

### Config File

```php
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
            'temperature' => 0.7,
            'max_tokens' => 4096,
        ],

        'gemini' => [
            'api_key' => env('GEMINI_API_KEY'),
            'model' => env('GEMINI_MODEL', 'gemini-2.0-flash-exp'),
            'temperature' => 0.7,
            'max_tokens' => 4096,
        ],
    ],
];
```

---

## Basic Usage

### Simple Chat

```php
use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('openai')->chat([
    ['role' => 'user', 'content' => 'Hello! How can you help me?'],
]);

echo $response['content']; // AI response
print_r($response['usage']); // Token usage stats
```

### With System Message

```php
$response = $ai->provider('openai')->chat([
    ['role' => 'system', 'content' => 'You are a helpful assistant for a Laravel application.'],
    ['role' => 'user', 'content' => 'How do I create a migration?'],
]);
```

### Streaming Responses

```php
foreach ($ai->provider('openai')->streamChat($messages) as $chunk) {
    echo $chunk; // Real-time text chunks
    flush();
}
```

---

## Resource AI Agents

Configure AI capabilities for each resource:

### Basic AI Agent

```php
<?php

namespace App\Laravilt\Admin\Resources\Product;

use Laravilt\Panel\Resources\Resource;
use Laravilt\AI\AIAgent;
use Laravilt\AI\AIColumn;

class ProductResource extends Resource
{
    public static function ai(AIAgent $agent): AIAgent
    {
        return $agent
            ->name('product_assistant')
            ->description('AI assistant for managing products')
            ->searchable(['name', 'description', 'sku'])
            ->columns([
                AIColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),

                AIColumn::make('price')
                    ->type('decimal')
                    ->filterable()
                    ->sortable(),

                AIColumn::make('stock_quantity')
                    ->type('integer')
                    ->filterable()
                    ->sortable(),

                AIColumn::make('is_active')
                    ->type('boolean')
                    ->filterable(),
            ])
            ->systemPrompt('You are a helpful product management assistant. Help users find, create, update, and manage products.')
            ->canCreate(true)
            ->canUpdate(true)
            ->canDelete(false)
            ->canQuery(true);
    }
}
```

### CRUD Capabilities

```php
$agent
    ->canCreate(true)   // Allow AI to create records
    ->canUpdate(true)   // Allow AI to update records
    ->canDelete(true)   // Allow AI to delete records
    ->canQuery(true)    // Allow AI to query records
```

### Custom Provider per Resource

```php
use Laravilt\AI\Enums\OpenAIModel;

$agent
    ->provider('openai')
    ->aiModel(OpenAIModel::GPT_4O)
    ->temperature(0.5)
    ->maxTokens(2000);
```

---

## Tool Calling

### Automatic Tool Generation

The AI package automatically generates tools for resources:

- **QueryTool** - Search and filter records
- **CreateTool** - Create new records
- **UpdateTool** - Update existing records
- **DeleteTool** - Delete records

### Example Tool Usage

```php
$response = $ai->provider('openai')->chatWithTools(
    messages: [
        ['role' => 'user', 'content' => 'Show me the 5 most expensive active products'],
    ],
    tools: $resourceAgent->getTools()
);

// AI automatically calls QueryTool with parameters:
// {
//     "search": "",
//     "filters": {"is_active": true},
//     "orderBy": "price",
//     "orderDirection": "desc",
//     "limit": 5
// }
```

### Custom Tools

```php
use Laravilt\AI\Tool;

$customTool = new class extends Tool {
    protected string $name = 'calculate_discount';
    protected string $description = 'Calculate discount price for a product';

    protected function getParameters(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'price' => [
                    'type' => 'number',
                    'description' => 'Original price',
                ],
                'discount_percent' => [
                    'type' => 'number',
                    'description' => 'Discount percentage (0-100)',
                ],
            ],
            'required' => ['price', 'discount_percent'],
        ];
    }

    public function handle(array $parameters): mixed
    {
        $price = $parameters['price'];
        $discount = $parameters['discount_percent'];
        return $price * (1 - $discount / 100);
    }
};

$agent->tools([$customTool]);
```

---

## Global Search

### Configure Global Search

```php
use Laravilt\AI\GlobalSearch;

app(GlobalSearch::class)
    ->registerResource(
        id: 'products',
        model: Product::class,
        searchableFields: ['name', 'sku', 'description'],
        label: 'Products'
    )
    ->limit(5)
    ->useAI(true);
```

### AI-Powered Search

The global search automatically detects:
- Natural language questions ("most expensive products")
- Specific queries ("products with low stock")
- Simple searches (fallback to database/Scout)

### Search Modes

**AI Tools Mode:**
- Activated for complex queries
- Uses AI to determine query parameters
- Supports ordering, filtering, limiting

**Term Extraction Mode:**
- Activated for simple searches
- AI extracts search terms
- Fast fallback to database search

---

## Chat Interface

### Using the Chat UI

The AI package includes a full-featured chat interface:

**Features:**
- Real-time streaming responses
- Session management
- Provider/model selection
- @ mentions for resource context
- Message history
- Copy messages
- Markdown rendering
- Typing indicators
- Responsive design

### Enable Chat in Panel

```php
use Laravilt\AI\AIManager;

$panel->ai(function (AIManager $ai) {
    $ai->chat(enabled: true)
        ->defaultProvider('openai')
        ->defaultModel('gpt-4o-mini')
        ->sessionTimeout(3600); // 1 hour
});
```

### @ Mentions

Reference resources in chat:

```
User: Show me @Products with low stock
AI: [Queries products with stock_quantity < 10]

User: Create a new @User with name John Doe
AI: [Creates user record]
```

---

## Streaming with Tool Calling

### Real-time Responses with Tools

```php
$messages = [
    ['role' => 'user', 'content' => 'Find the 3 cheapest products'],
];

$tools = $agent->getTools();

foreach ($ai->provider()->streamChatWithTools($messages, $tools) as $event) {
    if ($event['type'] === 'text') {
        echo $event['content'];
    } elseif ($event['type'] === 'tool_call') {
        // Execute tool
        $result = $event['tool']->handle($event['arguments']);
        // Add result to messages
        $messages[] = [
            'role' => 'tool',
            'content' => json_encode($result),
            'tool_call_id' => $event['id'],
        ];
    }
}
```

---

## Session Management

### Create Session

```php
use Laravilt\AI\Models\AISession;

$session = AISession::create([
    'user_id' => auth()->id(),
    'metadata' => [
        'provider' => 'openai',
        'model' => 'gpt-4o-mini',
    ],
]);
```

### Add Messages

```php
$session->addMessage([
    'role' => 'user',
    'content' => 'Hello!',
]);

$session->addMessage([
    'role' => 'assistant',
    'content' => 'Hi! How can I help you?',
]);
```

### Load Session

```php
$session = AISession::find($sessionId);
$messages = $session->messages;

// Continue conversation
$newResponse = $ai->provider()->chat([
    ...$messages,
    ['role' => 'user', 'content' => 'What were we talking about?'],
]);
```

---

## Provider-Specific Features

### OpenAI

```php
$response = $ai->provider('openai')->chat($messages, [
    'temperature' => 0.8,
    'top_p' => 0.9,
    'presence_penalty' => 0.6,
    'frequency_penalty' => 0.5,
]);
```

### Anthropic Claude

```php
// System messages separate from conversation
$response = $ai->provider('anthropic')->chat([
    ['role' => 'user', 'content' => 'Question'],
], [
    'system' => 'You are a helpful assistant.',
]);
```

### Google Gemini

```php
// Automatic message format conversion
$response = $ai->provider('gemini')->chat($messages, [
    'temperature' => 0.7,
    'topP' => 0.9,
    'topK' => 40,
]);
```

---

## API Endpoints

### Chat Endpoints

```
POST /laravilt-ai/chat
POST /laravilt-ai/stream
```

**Request:**
```json
{
    "messages": [
        {"role": "user", "content": "Hello"}
    ],
    "provider": "openai",
    "model": "gpt-4o-mini"
}
```

**Response:**
```json
{
    "content": "Hello! How can I assist you today?",
    "usage": {
        "prompt_tokens": 10,
        "completion_tokens": 12,
        "total_tokens": 22
    }
}
```

### Session Endpoints

```
GET    /laravilt-ai/sessions          # List sessions
POST   /laravilt-ai/sessions          # Create session
GET    /laravilt-ai/sessions/{id}     # Get session
PATCH  /laravilt-ai/sessions/{id}     # Update session
DELETE /laravilt-ai/sessions/{id}     # Delete session
```

### Search Endpoint

```
GET /laravilt-ai/search?q=query
```

---

## Complete Example

### E-commerce Product Assistant

```php
<?php

namespace App\Laravilt\Admin\Resources\Product;

use Laravilt\Panel\Resources\Resource;
use Laravilt\AI\AIAgent;
use Laravilt\AI\AIColumn;
use Laravilt\AI\Tool;
use Laravilt\AI\Enums\OpenAIModel;

class ProductResource extends Resource
{
    public static function ai(AIAgent $agent): AIAgent
    {
        return $agent
            ->name('product_assistant')
            ->description('AI assistant for managing e-commerce products')
            ->searchable(['name', 'description', 'sku'])
            ->columns([
                AIColumn::make('id')
                    ->type('integer')
                    ->sortable(),

                AIColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),

                AIColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),

                AIColumn::make('price')
                    ->type('decimal')
                    ->filterable()
                    ->sortable(),

                AIColumn::make('cost')
                    ->type('decimal')
                    ->filterable(),

                AIColumn::make('stock_quantity')
                    ->type('integer')
                    ->label('Stock')
                    ->filterable()
                    ->sortable(),

                AIColumn::make('is_active')
                    ->type('boolean')
                    ->label('Active')
                    ->filterable(),

                AIColumn::make('is_featured')
                    ->type('boolean')
                    ->label('Featured')
                    ->filterable(),

                AIColumn::make('category_id')
                    ->type('integer')
                    ->filterable()
                    ->relationship('category'),

                AIColumn::make('created_at')
                    ->type('datetime')
                    ->sortable(),
            ])
            ->systemPrompt('
                You are a helpful e-commerce product management assistant.
                Help users find products, manage inventory, and analyze product data.
                Always provide clear, concise responses.
                When creating products, ensure all required fields are provided.
                When querying products, use appropriate filters and ordering.
            ')
            ->canCreate(true)
            ->canUpdate(true)
            ->canDelete(false)
            ->canQuery(true)
            ->provider('openai')
            ->aiModel(OpenAIModel::GPT_4O_MINI)
            ->temperature(0.5)
            ->maxTokens(2000)
            ->tools([
                new class extends Tool {
                    protected string $name = 'calculate_profit_margin';
                    protected string $description = 'Calculate profit margin for a product';

                    protected function getParameters(): array
                    {
                        return [
                            'type' => 'object',
                            'properties' => [
                                'price' => ['type' => 'number', 'description' => 'Selling price'],
                                'cost' => ['type' => 'number', 'description' => 'Cost price'],
                            ],
                            'required' => ['price', 'cost'],
                        ];
                    }

                    public function handle(array $parameters): mixed
                    {
                        $price = $parameters['price'];
                        $cost = $parameters['cost'];
                        $margin = (($price - $cost) / $price) * 100;
                        return round($margin, 2) . '%';
                    }
                },

                new class extends Tool {
                    protected string $name = 'check_low_stock';
                    protected string $description = 'Check if product stock is low (below threshold)';

                    protected function getParameters(): array
                    {
                        return [
                            'type' => 'object',
                            'properties' => [
                                'stock_quantity' => ['type' => 'integer', 'description' => 'Current stock'],
                                'threshold' => ['type' => 'integer', 'description' => 'Low stock threshold', 'default' => 10],
                            ],
                            'required' => ['stock_quantity'],
                        ];
                    }

                    public function handle(array $parameters): mixed
                    {
                        $stock = $parameters['stock_quantity'];
                        $threshold = $parameters['threshold'] ?? 10;
                        return $stock < $threshold;
                    }
                },
            ]);
    }
}
```

---

## Best Practices

### 1. Use System Prompts

```php
->systemPrompt('
    Clear instructions for the AI assistant.
    Define the role, capabilities, and behavior.
    Provide examples if needed.
')
```

### 2. Configure CRUD Permissions

```php
->canCreate(auth()->user()->can('create', Product::class))
->canUpdate(auth()->user()->can('update', Product::class))
->canDelete(false) // Disable dangerous operations
```

### 3. Use Appropriate Models

```php
// Fast responses for simple queries
->aiModel(OpenAIModel::GPT_4O_MINI)

// Complex reasoning tasks
->aiModel(OpenAIModel::GPT_4O)
```

### 4. Enable Streaming for Better UX

```php
// In Vue component
for await (const chunk of streamChat(messages)) {
    displayChunk(chunk)
}
```

### 5. Handle Errors Gracefully

```php
try {
    $response = $ai->provider()->chat($messages);
} catch (\Exception $e) {
    // Fallback to database search
    $results = Product::search($query)->get();
}
```

---

## Next Steps

- [Plugins](../plugins/introduction.md) - Plugin system
- [Panel](../panel/introduction.md) - Panel configuration
- [Tables](../tables/introduction.md) - Table integration
