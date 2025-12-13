---
title: Vue Components
description: Documentation for Laravilt's Vue 3 components.
---

# Vue Components

Laravilt provides a comprehensive set of Vue 3 components for building admin panels.

## Navigation Components

### NavMain.vue

The main sidebar navigation component with support for:

- **Navigation Groups** - Collapsible groups with icons and labels
- **Badge Support** - Display counts or status badges on items
- **Active State Detection** - Automatic highlighting based on current URL
- **Cluster Support** - `activeMatchPrefix` for matching URL prefixes

```vue
<script setup lang="ts">
import NavMain from '@/components/NavMain.vue'
import { Home, Users, Settings } from 'lucide-vue-next'

const navItems = [
    {
        title: 'Dashboard',
        url: '/admin',
        icon: Home,
    },
    {
        type: 'group',
        title: 'Users',
        icon: Users,
        items: [
            { title: 'All Users', url: '/admin/users' },
            { title: 'Roles', url: '/admin/roles' },
        ],
    },
]
</script>

<template>
    <NavMain :items="navItems" />
</template>
```

#### NavItem Interface

```typescript
interface NavItem {
    title: string
    url?: string
    href?: string
    icon?: Component
    type?: 'group'
    items?: NavItem[]
    collapsed?: boolean
    badge?: string
    badgeCount?: number
    badgeColor?: 'primary' | 'success' | 'danger' | 'warning' | 'info' | 'gray'
    activeMatchPrefix?: string  // For cluster-style URL matching
}
```

### AppHeader.vue

The top header component featuring:

- **Global Search** - Searchable navigation and records
- **Breadcrumbs** - Current location display
- **User Menu** - Profile, settings, and logout
- **Theme Toggle** - Light/dark mode switching

### AppSidebar.vue

The main sidebar container with:

- **Collapsible State** - Icon-only mode when collapsed
- **Dropdown Navigation** - Groups show as dropdowns when collapsed
- **Persistent State** - Remembers collapsed/expanded state

## UI Components

### Button

Multiple button variants:

```vue
<script setup>
import { Button } from '@/components/ui/button'
</script>

<template>
    <Button variant="default">Default</Button>
    <Button variant="destructive">Delete</Button>
    <Button variant="outline">Outline</Button>
    <Button variant="ghost">Ghost</Button>
    <Button variant="link">Link</Button>
</template>
```

### Dialog

Modal dialogs for confirmations and forms:

```vue
<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button>Open Dialog</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Confirm Action</DialogTitle>
                <DialogDescription>
                    Are you sure you want to proceed?
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button variant="outline">Cancel</Button>
                <Button>Confirm</Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
```

### Badge

Status badges with color variants:

```vue
<script setup>
import { Badge } from '@/components/ui/badge'
</script>

<template>
    <Badge variant="default">Default</Badge>
    <Badge variant="primary">Primary</Badge>
    <Badge variant="success">Success</Badge>
    <Badge variant="danger">Danger</Badge>
    <Badge variant="warning">Warning</Badge>
    <Badge variant="info">Info</Badge>
</template>
```

### Card

Content cards with header, content, and footer:

```vue
<script setup>
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Card Title</CardTitle>
            <CardDescription>Card description</CardDescription>
        </CardHeader>
        <CardContent>
            <p>Card content goes here.</p>
        </CardContent>
        <CardFooter>
            <Button>Action</Button>
        </CardFooter>
    </Card>
</template>
```

### Sidebar

Collapsible sidebar with groups:

```vue
<script setup>
import {
    Sidebar,
    SidebarContent,
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuBadge,
    useSidebar,
} from '@/components/ui/sidebar'
</script>

<template>
    <Sidebar>
        <SidebarContent>
            <SidebarGroup>
                <SidebarGroupLabel>Navigation</SidebarGroupLabel>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton>
                            <HomeIcon />
                            <span>Dashboard</span>
                        </SidebarMenuButton>
                        <SidebarMenuBadge>
                            <Badge>New</Badge>
                        </SidebarMenuBadge>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>
        </SidebarContent>
    </Sidebar>
</template>
```

### Dropdown Menu

Context menus and dropdown actions:

```vue
<script setup>
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="outline">Options</Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent>
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem>Edit</DropdownMenuItem>
            <DropdownMenuItem>Duplicate</DropdownMenuItem>
            <DropdownMenuItem class="text-red-500">Delete</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
```

## Laravilt Components

Located in `components/laravilt/`:

### Page.vue

The main page component for resource list views with:

- **View Toggle** - Switch between table, grid, and API views
- **Infinite Scroll** - Load more data as you scroll
- **Filters** - Advanced filtering interface
- **Bulk Actions** - Select and act on multiple records
- **Sorting** - Click column headers to sort

### Form.vue

Dynamic form rendering with:

- **Field Types** - All 30+ field types supported
- **Validation** - Real-time validation feedback
- **Conditional Fields** - Show/hide based on conditions
- **Sections & Tabs** - Organized form layouts

### Table.vue

Data table component with:

- **Sortable Columns** - Click to sort
- **Searchable** - Global and column search
- **Selectable Rows** - Checkbox selection
- **Row Actions** - Edit, view, delete actions
- **Reorderable** - Drag and drop row ordering

## Best Practices

### Use Composition API

Always use Vue 3 Composition API with `<script setup>`:

```vue
<script setup lang="ts">
import { ref, computed } from 'vue'

const count = ref(0)
const doubled = computed(() => count.value * 2)
</script>
```

### Type Your Props

Use TypeScript interfaces for props:

```vue
<script setup lang="ts">
interface Props {
    title: string
    count?: number
    items: Array<{ id: number; name: string }>
}

const props = withDefaults(defineProps<Props>(), {
    count: 0,
})
</script>
```

### Use Inertia Links

For navigation, use Inertia's `Link` component:

```vue
<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <Link href="/admin/users">View Users</Link>
</template>
```
