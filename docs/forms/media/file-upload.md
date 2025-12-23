---
title: FileUpload
description: Advanced file upload with image editing
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: media
vue_component: FilePond
vue_package: "vue-filepond"
---

# FileUpload

Advanced file upload with image editing, multiple files, and Spatie Media Library.

## Vue Component

Uses **FilePond** for file uploads.

```vue
<script setup>
import vueFilePond from 'vue-filepond'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import FilePondPluginImageCrop from 'filepond-plugin-image-crop'

const FilePond = vueFilePond(
  FilePondPluginImagePreview,
  FilePondPluginImageCrop
)
</script>
```

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\FileUpload;

FileUpload::make('attachment')
    ->label('Attachment');
```

## File Restrictions

```php
FileUpload::make('document')
    ->acceptedFileTypes(['application/pdf', '.docx'])
    ->maxSize(5120) // 5MB
    ->minSize(100);
```

## Multiple Files

```php
FileUpload::make('attachments')
    ->multiple()
    ->minFiles(1)
    ->maxFiles(5)
    ->reorderable();
```

## Image Upload

```php
FileUpload::make('photo')
    ->image()
    ->imagePreviewHeight(250)
    ->imageResizeTargetWidth(800)
    ->imageResizeTargetHeight(600);
```

## Image Cropping

```php
FileUpload::make('avatar')
    ->image()
    ->imageCropAspectRatio('1:1')
    ->imageEditor()
    ->circleCropper();
```

## Storage

```php
FileUpload::make('file')
    ->disk('s3')
    ->directory('uploads')
    ->visibility('private')
    ->preserveFilenames();
```

## Spatie Media Library

```php
FileUpload::make('images')
    ->collection('gallery')
    ->conversion('thumb');
```

## API Reference

| Method | Description |
|--------|-------------|
| `image()` | Restrict to images |
| `multiple()` | Allow multiple |
| `maxSize()` | Max size in KB |
| `imageEditor()` | Enable editor |
| `collection()` | Spatie collection |
| `disk()` | Storage disk |

## Related

- [RichEditor](rich-editor) - HTML editor
- [Custom Fields](../custom/introduction) - Custom uploads
