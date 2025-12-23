---
title: Input Fields
description: Text-based input components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: inputs
---

# Input Fields

Text-based input components for collecting user data.

## Available Components

| Component | Description | Vue Component |
|-----------|-------------|---------------|
| `TextInput` | Single-line text (email, password, tel, url) | `Input` from shadcn/ui |
| `Textarea` | Multi-line text | `Textarea` from shadcn/ui |
| `NumberField` | Numeric input with spin buttons | Custom `NumberInput` |
| `Hidden` | Hidden field | Native hidden input |
| `PinInput` | PIN/OTP code entry | `PinInput` from shadcn/ui |

## Common Methods

All input fields share these methods:

```php
<?php

use Laravilt\Forms\Components\TextInput;

TextInput::make('name')
    ->label('Full Name')
    ->placeholder('Enter name...')
    ->helperText('Your legal name')
    ->hint('As shown on ID')
    ->required()
    ->disabled()
    ->readonly()
    ->default('John')
    ->columnSpan(2);
```

## Vue Component Pattern

All inputs use the `FieldWrapper` component:

```vue
<template>
  <FieldWrapper
    :label="label"
    :errors="errors"
    :helper-text="helperText"
    :required="required"
  >
    <Input
      :model-value="modelValue"
      @update:model-value="$emit('update:modelValue', $event)"
      :placeholder="placeholder"
      :disabled="disabled"
    />
  </FieldWrapper>
</template>
```

## Related

- [TextInput](text-input) - Single-line text
- [Textarea](textarea) - Multi-line text
- [NumberField](number-field) - Numeric input
- [Hidden](hidden) - Hidden fields
- [PinInput](pin-input) - PIN/OTP input
