---
title: Media Fields
description: File upload and rich content editors
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: media
---

# Media Fields

Components for file uploads and rich content editing.

## Available Components

| Component | Description | Vue Package |
|-----------|-------------|-------------|
| `FileUpload` | File/image upload | FilePond |
| `RichEditor` | WYSIWYG HTML editor | Tiptap |
| `MarkdownEditor` | Markdown editor | Tiptap + Markdown |
| `CodeEditor` | Code with syntax | Monaco Editor |

## Required Packages

```bash
# FilePond for file uploads
npm install filepond vue-filepond

# Tiptap for rich editing
npm install @tiptap/vue-3 @tiptap/starter-kit

# Monaco for code editing (optional)
npm install monaco-editor
```

## Spatie Media Library

FileUpload integrates with Spatie Media Library:

```bash
composer require spatie/laravel-medialibrary
```

```php
FileUpload::make('images')
    ->collection('product-images')
    ->multiple();
```

## Vue Component Pattern

```vue
<template>
  <FieldWrapper :label="label" :errors="errors">
    <FilePond
      ref="pond"
      :files="modelValue"
      @updatefiles="handleUpdate"
      :allow-multiple="multiple"
      :accepted-file-types="acceptedTypes"
    />
  </FieldWrapper>
</template>

<script setup>
import vueFilePond from 'vue-filepond'
import 'filepond/dist/filepond.min.css'
</script>
```

## Related

- [FileUpload](file-upload) - File uploads
- [RichEditor](rich-editor) - HTML editor
- [MarkdownEditor](markdown-editor) - Markdown
- [CodeEditor](code-editor) - Code editing
