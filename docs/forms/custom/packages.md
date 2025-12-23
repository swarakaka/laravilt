---
title: Third-Party Packages
description: Integrating npm packages into custom fields
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: custom
---

# Third-Party Packages

Integrate npm packages into custom form fields.

## Recommended Packages

### Core UI

| Package | Purpose | Install |
|---------|---------|---------|
| radix-vue | UI primitives | `npm i radix-vue` |
| lucide-vue-next | Icons | `npm i lucide-vue-next` |
| @vueuse/core | Composables | `npm i @vueuse/core` |

### Rich Text Editors

| Package | Purpose | Install |
|---------|---------|---------|
| @tiptap/vue-3 | WYSIWYG editor | `npm i @tiptap/vue-3 @tiptap/starter-kit` |
| @milkdown/vue | Markdown editor | `npm i @milkdown/core @milkdown/vue` |

### File Handling

| Package | Purpose | Install |
|---------|---------|---------|
| vue-filepond | File uploads | `npm i vue-filepond filepond` |
| @uppy/vue | Advanced uploads | `npm i @uppy/core @uppy/vue` |

### Date & Time

| Package | Purpose | Install |
|---------|---------|---------|
| v-calendar | Date picker | `npm i v-calendar@next` |
| vue-datepicker | Date/time | `npm i @vuepic/vue-datepicker` |

### Specialized

| Package | Purpose | Install |
|---------|---------|---------|
| vue-color | Color picker | `npm i vue-color` |
| signature_pad | Signatures | `npm i signature_pad` |
| monaco-editor | Code editor | `npm i monaco-editor` |

## Example: Tiptap Editor

```vue
<template>
  <FieldWrapper :label="label" :errors="errors">
    <EditorContent :editor="editor" />
  </FieldWrapper>
</template>

<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

const props = defineProps<{ modelValue: string }>()
const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
  content: props.modelValue,
  extensions: [StarterKit],
  onUpdate: ({ editor }) => {
    emit('update:modelValue', editor.getHTML())
  },
})
</script>
```

## Example: Signature Pad

```vue
<template>
  <FieldWrapper :label="label" :errors="errors">
    <canvas ref="canvas" />
    <Button @click="clear">Clear</Button>
  </FieldWrapper>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import SignaturePad from 'signature_pad'

const canvas = ref<HTMLCanvasElement>()
let signaturePad: SignaturePad

onMounted(() => {
  signaturePad = new SignaturePad(canvas.value!)
})

function clear() {
  signaturePad.clear()
}
</script>
```

## Related

- [Vue Components](vue-components) - Component patterns
- [Creating Fields](creating-fields) - Field class creation
