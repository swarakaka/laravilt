---
title: Panel Introduction
description: Core integration layer of Laravilt
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Panel Introduction

The Panel package is the core integration layer of Laravilt, providing a complete admin dashboard framework.

## Overview

A Panel is a self-contained admin interface that includes:

- **Resources**: CRUD entities with forms, tables, and infolists
- **Pages**: Custom standalone pages
- **Navigation**: Auto-generated sidebar navigation
- **Authentication**: Login, registration, 2FA, social auth, passkeys
- **API Access**: Auto-generated REST APIs
- **AI Integration**: AI-powered CRUD operations and search
- **Widgets**: Dashboard statistics and charts

## Key Features

### Multi-Panel Support

Run multiple independent admin panels:

```php
// Admin panel at /admin
App\Laravilt\Admin\AdminPanelProvider::class

// Customer portal at /portal
App\Laravilt\Portal\PortalPanelProvider::class
```

### Auto-Discovery

Resources, pages, and widgets are automatically discovered:

```
app/Laravilt/Admin/
├── Pages/           # Auto-discovered
├── Resources/       # Auto-discovered
└── Widgets/         # Auto-discovered
```

### API Generation

Every resource automatically gets REST API endpoints:

```
GET    /admin/api/users          # List
POST   /admin/api/users          # Create
GET    /admin/api/users/{id}     # Show
PUT    /admin/api/users/{id}     # Update
DELETE /admin/api/users/{id}     # Delete
```

## Next Steps

- [Panel Provider](panel-provider) - Configure your panel
- [Creating Panels](creating-panels) - Create new panels
- [Branding](branding) - Customize appearance
- [Panel Auth](panel-auth) - Authentication settings
- [Discovery](discovery) - Auto-discovery configuration
- [Tenancy](tenancy/overview) - Multi-tenancy support
- [Migration](migration/overview) - Migrate from Filament

## Resources

- [Introduction](concepts/resources/introduction) - Resource basics
- [Forms](concepts/resources/forms) - Form configuration
- [Tables](concepts/resources/tables) - Table configuration
- [Authorization](concepts/resources/authorization) - Access control
- [Relation Managers](concepts/resources/relation-managers) - Related records
- [Nested Resources](concepts/resources/nested-resources) - Child resources
- [API](concepts/resources/api) - REST API endpoints
- [AI](concepts/resources/ai) - AI-powered operations

## Pages

- [Introduction](concepts/pages/introduction) - Page basics
- [Forms](concepts/pages/forms) - Pages with forms
- [Widgets](concepts/pages/widgets) - Dashboard widgets
- [Tables](concepts/pages/tables) - Pages with tables
- [Infolist](concepts/pages/infolist) - Read-only displays

## Navigation

- [Introduction](concepts/navigation/introduction) - Navigation basics
- [Items](concepts/navigation/items) - Custom navigation items
- [Badges](concepts/navigation/badges) - Badges and conditions
- [Clusters](concepts/navigation/clusters) - Page grouping
