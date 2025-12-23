---
title: Data Flow
description: Understanding how data flows through Laravilt
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Data Flow

Understanding how data flows through Laravilt.

## Request Lifecycle

```
┌─────────────────────────────────────────────────────────────┐
│                     HTTP Request                             │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                   Laravel Router                             │
│    Routes matched via Panel configuration                    │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                  Panel Middleware                            │
│    - Authentication check                                    │
│    - Panel authorization                                     │
│    - Asset injection                                         │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                  Resource Controller                         │
│    - Retrieves data from model                               │
│    - Applies filters and sorting                             │
│    - Transforms to Inertia props                            │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                  Inertia Response                            │
│    - Serializes PHP components to JSON                       │
│    - Passes props to Vue                                     │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                   Vue Component                              │
│    - Renders UI from serialized schema                       │
│    - Handles user interactions                               │
│    - Submits forms back to server                           │
└─────────────────────────────────────────────────────────────┘
```

## Component Serialization

PHP components are serialized for the frontend:

```php
// PHP Component
TextInput::make('email')
    ->email()
    ->required()
    ->placeholder('Enter email');
```

Becomes JSON:

```json
{
  "type": "text-input",
  "name": "email",
  "inputType": "email",
  "required": true,
  "placeholder": "Enter email"
}
```

## State Management

Form state flows between server and client:

```
┌──────────────────┐     ┌──────────────────┐
│   PHP Component  │────→│  JSON Schema     │
│   Configuration  │     │  (Props)         │
└──────────────────┘     └──────────────────┘
                                ↓
                         ┌──────────────────┐
                         │  Vue Component   │
                         │  (Reactive State)│
                         └──────────────────┘
                                ↓
                         ┌──────────────────┐
                         │  Form Submission │
                         │  (POST Request)  │
                         └──────────────────┘
                                ↓
                         ┌──────────────────┐
                         │  PHP Controller  │
                         │  (Validation)    │
                         └──────────────────┘
```

## Service Providers

Key service providers in the data flow:

```php
// LaraviltServiceProvider
public function boot(): void
{
    // Register panel routes
    $this->registerPanelRoutes();

    // Register component serializers
    $this->registerSerializers();

    // Boot panel providers
    $this->bootPanelProviders();
}
```

## Traits System

Components use traits for reusable behavior:

```php
class TextInput extends Component
{
    use HasLabel;       // ->label()
    use HasPlaceholder; // ->placeholder()
    use HasValidation;  // ->required(), ->email()
    use HasVisibility;  // ->visible(), ->hidden()
    use HasState;       // ->default(), ->live()
}
```

## Next Steps

- [Architecture](architecture) - System overview
- [Packages](packages) - Package structure
- [Configuration](configuration) - Configuration options
