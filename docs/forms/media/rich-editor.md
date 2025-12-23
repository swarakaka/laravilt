---
title: RichEditor
description: WYSIWYG HTML editor
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: RichEditor
vue_component: FormRichEditor
vue_package: "@tiptap/vue-3"
---

# RichEditor

WYSIWYG HTML editor with Tiptap.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\RichEditor;

RichEditor::make('content')
    ->label('Content');
```

## Toolbar Configuration

```php
<?php

use Laravilt\Forms\Components\RichEditor;

RichEditor::make('body')
    ->toolbarButtons([
        'bold', 'italic', 'underline',
        'link', 'orderedList', 'bulletList',
        'h2', 'h3', 'blockquote',
    ]);
```

## Height Configuration

```php
<?php

use Laravilt\Forms\Components\RichEditor;

RichEditor::make('article')
    ->minHeight(200)
    ->maxHeight(500);
```

## Vue Component

Uses Tiptap editor:

```vue
<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `toolbarButtons()` | Set toolbar buttons |
| `minHeight()` | Minimum height |
| `maxHeight()` | Maximum height |
| `fileAttachmentsDisk()` | Attachments disk |
