---
title: Utilities
description: TypeScript utility functions for Laravilt frontends.
---

# Frontend Utilities

Laravilt provides utility functions in `resources/js/lib/utils.ts` for common frontend operations.

## utils.ts

### cn() - Class Name Merger

Combines and deduplicates Tailwind CSS classes using `clsx` and `tailwind-merge`:

```typescript
import { cn } from '@/lib/utils'

// Basic usage
cn('px-4 py-2', 'bg-blue-500')
// => 'px-4 py-2 bg-blue-500'

// With conditionals
cn('base-class', isActive && 'active-class', isDisabled && 'opacity-50')
// => 'base-class active-class' (if isActive is true)

// Merging conflicting classes (tailwind-merge handles this)
cn('px-2', 'px-4')
// => 'px-4' (later class wins)

// With objects
cn('base', { 'conditional': condition })
// => 'base conditional' (if condition is true)
```

### urlIsActive() - Active URL Detection

Detects if a URL matches the current page for navigation highlighting:

```typescript
import { urlIsActive } from '@/lib/utils'

// Exact match
urlIsActive('/admin/users', '/admin/users')
// => true

// Nested route matching
urlIsActive('/admin/users', '/admin/users/1/edit')
// => true (prefix match for nested routes)

// Root paths only exact match
urlIsActive('/admin', '/admin/users')
// => false (prevents /admin matching all sub-routes)

// Handles query strings
urlIsActive('/admin/users', '/admin/users?page=2')
// => true

// Handles full URLs
urlIsActive('https://example.com/admin/users', '/admin/users')
// => true (extracts path for comparison)
```

**Implementation Details:**

- Normalizes URLs by removing query strings and trailing slashes
- Root paths (single segment like `/admin`) only match exactly
- Nested routes (`/admin/users`) match both exact and child routes
- Prevents partial matches (`/admin/cat` won't match `/admin/categories`)

### toUrl() - URL Extraction

Extracts URL string from Inertia link objects:

```typescript
import { toUrl } from '@/lib/utils'

// From string
toUrl('/admin/users')
// => '/admin/users'

// From Inertia URL object
toUrl({ url: '/admin/users', method: 'get' })
// => '/admin/users'
```

## Composables

### useSidebar()

Access sidebar state from anywhere in your components:

```typescript
import { useSidebar } from '@/components/ui/sidebar'

const { state, open, setOpen, toggleSidebar, isMobile } = useSidebar()

// Check if collapsed (icon-only mode)
const isCollapsed = computed(() => state.value === 'collapsed')

// Toggle sidebar
const handleToggle = () => {
    toggleSidebar()
}
```

### usePage()

Access Inertia page props reactively:

```typescript
import { usePage } from '@inertiajs/vue3'

const page = usePage()

// Access current URL
const currentUrl = computed(() => page.url)

// Access shared props
const user = computed(() => page.props.auth?.user)

// Access flash messages
const flash = computed(() => page.props.flash)
```

### useForm()

Inertia form handling with validation:

```typescript
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: '',
    password: '',
})

const submit = () => {
    form.post('/users', {
        onSuccess: () => {
            form.reset()
        },
    })
}

// Access errors
form.errors.name // Validation error for name field

// Check processing state
form.processing // true while submitting

// Reset specific fields
form.reset('password')
```

## Navigation Helpers

### Active State for Clusters

For cluster-style navigation where multiple pages share a URL prefix:

```typescript
// In NavMain.vue
const isNavItemActive = (item: NavItem): boolean => {
    const currentPath = extractPath(currentUrl.value)

    // Check activeMatchPrefix for cluster-style matching
    if (item.activeMatchPrefix) {
        const prefix = extractPath(item.activeMatchPrefix).replace(/\/$/, '')
        const normalizedCurrent = currentPath.replace(/\/$/, '')

        if (normalizedCurrent.startsWith(prefix) &&
            (normalizedCurrent[prefix.length] === '/' ||
             normalizedCurrent.length === prefix.length)) {
            return true
        }
    }

    // Fall back to regular URL matching
    return urlIsActive(item.url || item.href, currentUrl.value)
}
```

**Usage in navigation items:**

```typescript
const navItems = [
    {
        title: 'Settings',
        url: '/admin/settings/profile',
        activeMatchPrefix: '/admin/settings', // Matches all settings pages
    },
]
```

## Best Practices

### Always Use cn() for Dynamic Classes

```vue
<template>
    <!-- Good -->
    <div :class="cn('base-styles', isActive && 'active-styles')">

    <!-- Avoid -->
    <div :class="{ 'base-styles': true, 'active-styles': isActive }">
</template>
```

### Check Active State Reactively

```typescript
// Use computed for reactive URL checking
const isActive = computed(() => urlIsActive(item.url, page.url))
```

### Handle URL Edge Cases

```typescript
// Always normalize URLs before comparison
const normalizedUrl = url.split('?')[0].split('#')[0].replace(/\/$/, '')
```
