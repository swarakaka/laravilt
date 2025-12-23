# Laravilt Documentation

Laravilt is a modern, modular admin panel framework for Laravel 12+ with Vue 3 (Inertia.js v2) frontend. Build admin panels, dashboards, and CRUD applications with minimal code.

## Requirements

| Requirement | Version |
|-------------|---------|
| PHP | 8.2+ |
| Laravel | 12.x |
| Node.js | 18+ |
| Database | MySQL 8.0+, PostgreSQL 13+, SQLite 3.35+ |

## Quick Start

```bash
composer require laravilt/laravilt
php artisan laravilt:install
npm install && npm run build
```

---

## Documentation Structure

### Getting Started

| Document | Description |
|----------|-------------|
| [Installation](getting-started/installation.md) | Setup and installation |
| [Quick Start](getting-started/quick-start.md) | Build your first panel |
| [Architecture](getting-started/architecture.md) | System overview |

### Core Packages

#### Panel

Build admin panels with resources, pages, and navigation.

| Document | Description |
|----------|-------------|
| [Introduction](panel/introduction.md) | Panel overview |
| [Concepts](panel/concepts/) | Resources, Pages, Navigation |
| [Tenancy](panel/tenancy/) | Multi-tenancy support |

#### Forms

30+ form components with validation and reactivity.

| Document | Description |
|----------|-------------|
| [Introduction](forms/introduction.md) | Forms overview |
| [Inputs](forms/inputs/) | Text, Textarea, RichEditor |
| [Selection](forms/selection/) | Select, Checkbox, Radio |
| [DateTime](forms/datetime/) | Date, Time, DateTime pickers |
| [Media](forms/media/) | FileUpload, ImageUpload |
| [Validation](forms/validation/) | Rules and messages |
| [Reactive](forms/reactive/) | Dependent fields |

#### Tables

Powerful data tables with sorting, filtering, and actions.

| Document | Description |
|----------|-------------|
| [Introduction](tables/introduction.md) | Tables overview |
| [Columns](tables/columns/) | Text, Badge, Image columns |
| [Filters](tables/filters/) | Select, Date, Boolean filters |
| [Actions](tables/actions/) | Row and bulk actions |
| [Features](tables/features/) | Search, Sort, Pagination |

#### Actions

Reusable action components for tables and pages.

| Document | Description |
|----------|-------------|
| [Introduction](actions/introduction.md) | Actions overview |

#### Auth

8 authentication methods including OTP, 2FA, and passkeys.

| Document | Description |
|----------|-------------|
| [Introduction](auth/introduction.md) | Auth overview |
| [Profile](auth/profile/) | Profile management |

### Layout & Display

#### Schemas

Layout components for organizing forms and content.

| Document | Description |
|----------|-------------|
| [Introduction](schemas/introduction.md) | Schemas overview |
| [Section](schemas/components/section.md) | Collapsible sections |
| [Grid](schemas/components/grid.md) | Multi-column layouts |
| [Tabs](schemas/components/tabs.md) | Tabbed interfaces |
| [Wizard](schemas/components/wizard.md) | Multi-step forms |

#### Infolists

Display-only components for showing data.

| Document | Description |
|----------|-------------|
| [Introduction](infolists/introduction.md) | Infolists overview |
| [Entries](infolists/entries/) | Text, Badge, Image entries |
| [Layouts](infolists/layouts/) | Section, Grid layouts |

#### Widgets

Dashboard widgets for stats and charts.

| Document | Description |
|----------|-------------|
| [Introduction](widgets/introduction.md) | Widgets overview |
| [Stats Overview](widgets/types/stats-overview.md) | Statistics grid |
| [Line Chart](widgets/types/line-chart.md) | Trend charts |
| [Bar Chart](widgets/types/bar-chart.md) | Bar charts |
| [Pie Chart](widgets/types/pie-chart.md) | Pie/doughnut charts |
| [Custom Widgets](widgets/custom-widgets.md) | Create widgets |

### Utilities

#### Query Builder

Advanced filtering and sorting for Eloquent.

| Document | Description |
|----------|-------------|
| [Introduction](query-builder/introduction.md) | Query builder overview |
| [Filters](query-builder/filters/) | Text, Select, Date filters |

#### Notifications

Toast notifications with actions.

| Document | Description |
|----------|-------------|
| [Introduction](notifications/introduction.md) | Notifications overview |
| [Types](notifications/types/) | Success, Error, Warning |

#### Support

Foundation traits and utilities.

| Document | Description |
|----------|-------------|
| [Introduction](support/introduction.md) | Support overview |
| [Component](support/component.md) | Base component class |
| [Concerns](support/concerns/) | Reusable traits |
| [Utilities](support/utilities.md) | Get, Set, Translator |

### AI Integration

Multi-provider AI support with tools and agents.

| Document | Description |
|----------|-------------|
| [Introduction](ai/introduction.md) | AI overview |
| [Providers](ai/providers/) | OpenAI, Anthropic, Gemini |
| [Chat](ai/chat/) | Chat completions |
| [Tools](ai/tools/) | Function calling |
| [Agents](ai/agents/) | AI agents |

### MCP Servers

AI agent integration with Model Context Protocol.

| Document | Description |
|----------|-------------|
| [Introduction](mcp/introduction.md) | MCP overview |
| [Forms MCP](mcp/forms.md) | Form generation tools |
| [Tables MCP](mcp/tables.md) | Table generation tools |
| [Panel MCP](mcp/panel.md) | Panel management tools |
| [Auth MCP](mcp/auth.md) | Authentication tools |
| [Schemas MCP](mcp/schemas.md) | Layout tools |
| [Plugins MCP](mcp/plugins.md) | Plugin management tools |

### Plugins

Extend Laravilt with plugins.

| Document | Description |
|----------|-------------|
| [Introduction](plugins/introduction.md) | Plugins overview |
| [Components](plugins/components/) | Plugin components |
| [Manager](plugins/manager/) | Plugin management |

### Frontend

Vue 3 components and styling.

| Document | Description |
|----------|-------------|
| [Overview](frontend/README.md) | Frontend overview |
| [Components](frontend/components.md) | Vue components |
| [Layouts](frontend/layouts.md) | Page layouts |
| [Styling](frontend/styling.md) | Tailwind CSS |

---

## FAQ & Help

| Document | Description |
|----------|-------------|
| [FAQ Overview](faq/introduction.md) | All FAQ sections |
| [Installation FAQ](faq/installation.md) | Setup questions |
| [Forms FAQ](faq/forms.md) | Form questions |
| [Tables FAQ](faq/tables.md) | Table questions |
| [Schemas FAQ](faq/schemas.md) | Layout questions |
| [Widgets FAQ](faq/widgets.md) | Widget questions |
| [AI FAQ](faq/ai.md) | AI feature questions |
| [Troubleshooting](faq/troubleshooting.md) | Common issues |

---

## Package Overview

| Package | Description | MCP Server |
|---------|-------------|------------|
| `laravilt/panel` | Admin panel framework | `laravilt-panel` |
| `laravilt/forms` | Form components | `laravilt-forms` |
| `laravilt/tables` | Table components | `laravilt-tables` |
| `laravilt/actions` | Action components | - |
| `laravilt/auth` | Authentication | `laravilt-auth` |
| `laravilt/schemas` | Layout components | `laravilt-schemas` |
| `laravilt/infolists` | Display components | - |
| `laravilt/widgets` | Dashboard widgets | - |
| `laravilt/notifications` | Notifications | `laravilt-notifications` |
| `laravilt/query-builder` | Query filtering | - |
| `laravilt/ai` | AI integration | `laravilt-ai` |
| `laravilt/plugins` | Plugin system | `laravilt-plugins` |
| `laravilt/support` | Core utilities | - |

---

## Support

- [GitHub Issues](https://github.com/laravilt/laravilt/issues)
- [Discord Community](https://discord.gg/gyRhbVUXEZ)

## License

Laravilt is open-sourced software licensed under the [MIT license](LICENSE.md).

