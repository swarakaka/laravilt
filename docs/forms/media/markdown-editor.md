---
title: MarkdownEditor
description: Markdown editor with preview
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: MarkdownEditor
vue_component: FormMarkdownEditor
vue_package: "@tiptap/vue-3"
---

# MarkdownEditor

Markdown editor with live preview.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\MarkdownEditor;

MarkdownEditor::make('content')
    ->label('Content');
```

## Toolbar Configuration

```php
<?php

use Laravilt\Forms\Components\MarkdownEditor;

MarkdownEditor::make('readme')
    ->toolbarButtons([
        'bold', 'italic', 'strike',
        'link', 'heading', 'bulletList',
        'orderedList', 'codeBlock', 'table',
    ]);
```

## Height Configuration

```php
<?php

use Laravilt\Forms\Components\MarkdownEditor;

MarkdownEditor::make('documentation')
    ->minHeight(300);
```

## Vue Component

Uses Tiptap with markdown:

```vue
<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
// markdown output mode
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `toolbarButtons()` | Set toolbar |
| `minHeight()` | Minimum height |
