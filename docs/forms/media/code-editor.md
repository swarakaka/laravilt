---
title: CodeEditor
description: Code editor with syntax highlighting
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: CodeEditor
vue_component: FormCodeEditor
vue_package: "codemirror, @codemirror/vue"
---

# CodeEditor

Code editor with syntax highlighting.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\CodeEditor;

CodeEditor::make('code')
    ->label('Source Code');
```

## Language Support

```php
<?php

use Laravilt\Forms\Components\CodeEditor;

CodeEditor::make('php_code')->language('php');
CodeEditor::make('js_code')->language('javascript');
CodeEditor::make('config')->language('json');
CodeEditor::make('template')->language('html');
CodeEditor::make('styles')->language('css');
```

## Configuration

```php
<?php

use Laravilt\Forms\Components\CodeEditor;

CodeEditor::make('code')
    ->lineNumbers()
    ->minHeight(200)
    ->maxHeight(500)
    ->theme('github-dark');
```

## Vue Component

Uses CodeMirror:

```vue
<script setup>
import { Codemirror } from 'vue-codemirror'
import { javascript } from '@codemirror/lang-javascript'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `language()` | Set language |
| `lineNumbers()` | Show line numbers |
| `minHeight()` | Minimum height |
| `theme()` | Editor theme |
| `readOnly()` | Read-only mode |
