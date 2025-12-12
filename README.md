![laravilt](https://raw.githubusercontent.com/laravilt/laravilt/master/arts/screenshot.jpg)

# Laravilt

A modern Laravel Admin Panel built with Vue 3, Inertia.js, and AI capabilities. Inspired by Filament but powered by the frontend.

[![Latest Stable Version](https://poser.pugx.org/laravilt/laravilt/version.svg)](https://packagist.org/packages/laravilt/laravilt)
[![License](https://poser.pugx.org/laravilt/laravilt/license.svg)](https://packagist.org/packages/laravilt/laravilt)
[![Downloads](https://poser.pugx.org/laravilt/laravilt/d/total.svg)](https://packagist.org/packages/laravilt/laravilt)
[![Dependabot Updates](https://github.com/laravilt/laravilt/actions/workflows/dependabot/dependabot-updates/badge.svg)](https://github.com/laravilt/laravilt/actions/workflows/dependabot/dependabot-updates)
[![PHP Code Styling](https://github.com/laravilt/laravilt/actions/workflows/fix-php-code-styling.yml/badge.svg)](https://github.com/laravilt/laravilt/actions/workflows/fix-php-code-styling.yml)
[![Tests](https://github.com/laravilt/laravilt/actions/workflows/tests.yml/badge.svg)](https://github.com/laravilt/laravilt/actions/workflows/tests.yml)

## Features

- **Modern Stack**: Laravel 12, Vue 3, Inertia.js v2, Tailwind CSS v4
- **Beautiful UI**: Built on shadcn/vue and Reka UI components
- **AI Integration**: Multi-provider AI support (OpenAI, Anthropic, Gemini)
- **Global Search**: AI-powered search across all resources
- **Rich Form Builder**: 30+ field types with validation
- **Powerful Tables**: Sorting, filtering, bulk actions, exports
- **Notifications**: Real-time in-app notifications
- **Widgets**: Dashboard widgets with charts and stats
- **Multi-tenancy**: Built-in tenant support
- **Authentication**: Multiple auth methods (passwords, social, passkeys)
- **RTL Support**: Full right-to-left language support
- **Dark Mode**: System-aware theming

## Documentation

Complete technical documentation for all Laravilt packages:

### Getting Started
- [Overview](docs/getting-started/README.md) - Introduction and package overview
- [Installation](docs/getting-started/installation.md) - Complete installation guide
- [Architecture](docs/getting-started/architecture.md) - System architecture and design
- [Quick Start](docs/getting-started/quick-start.md) - Build your first resource

### Core Packages
- [Panel](docs/panel/introduction.md) - Admin panel framework
  - [Creating Panels](docs/panel/creating-panels.md)
  - [Resources](docs/panel/resources.md)
  - [Pages](docs/panel/pages.md)
  - [Navigation](docs/panel/navigation.md)
  - [Themes](docs/panel/themes.md)

- [Auth](docs/auth/introduction.md) - Authentication system
  - [Auth Methods](docs/auth/methods.md)
  - [Two-Factor Authentication](docs/auth/two-factor.md)
  - [Social Login](docs/auth/social.md)
  - [Passkeys](docs/auth/passkeys.md)
  - [Profile Management](docs/auth/profile.md)

- [Forms](docs/forms/introduction.md) - Form builder
  - [Field Types](docs/forms/field-types.md) - 30+ field types
  - [Validation](docs/forms/validation.md)
  - [Layouts](docs/forms/layouts.md)
  - [Reactive Fields](docs/forms/reactive-fields.md)
  - [Custom Fields](docs/forms/custom-fields.md)

- [Tables](docs/tables/introduction.md) - Table builder
  - [Columns](docs/tables/columns.md) - 9 column types
  - [Filters](docs/tables/filters.md)
  - [Actions](docs/tables/actions.md)
  - [Table API](docs/tables/api.md) - REST API generation

- [Actions](docs/actions/introduction.md) - Action system for CRUD operations

### Supporting Packages
- [Schemas](docs/schemas/introduction.md) - Layout components
- [Infolists](docs/infolists/introduction.md) - Read-only data display
- [Notifications](docs/notifications/introduction.md) - Toast and database notifications
- [Widgets](docs/widgets/introduction.md) - Dashboard widgets and charts
- [Query Builder](docs/query-builder/introduction.md) - Advanced query building
- [Support](docs/support/introduction.md) - Core utilities and base components

### Advanced Features
- [AI Package](docs/ai/introduction.md) - AI integration
  - Multi-provider support (OpenAI, Anthropic, Gemini, DeepSeek, Perplexity)
  - Real-time streaming
  - Tool calling and function execution
  - Global search with AI
  - Chat interface with session management

- [Plugins](docs/plugins/introduction.md) - Plugin system
  - Creating plugins
  - Plugin components
  - Auto-discovery
  - MCP integration for AI-assisted development

## Included Packages

This meta-package includes all Laravilt components:

| Package | Description | Documentation |
|---------|-------------|---------------|
| `laravilt/support` | Core utilities and helpers | [Docs](docs/support/introduction.md) |
| `laravilt/panel` | Admin panel core framework | [Docs](docs/panel/introduction.md) |
| `laravilt/auth` | Authentication system | [Docs](docs/auth/introduction.md) |
| `laravilt/forms` | Form builder with 30+ fields | [Docs](docs/forms/introduction.md) |
| `laravilt/tables` | Table builder with actions | [Docs](docs/tables/introduction.md) |
| `laravilt/actions` | Action system for CRUD | [Docs](docs/actions/introduction.md) |
| `laravilt/schemas` | Schema definitions | [Docs](docs/schemas/introduction.md) |
| `laravilt/infolists` | Information display lists | [Docs](docs/infolists/introduction.md) |
| `laravilt/notifications` | Notification system | [Docs](docs/notifications/introduction.md) |
| `laravilt/widgets` | Dashboard widgets | [Docs](docs/widgets/introduction.md) |
| `laravilt/query-builder` | Query building utilities | [Docs](docs/query-builder/introduction.md) |
| `laravilt/ai` | AI assistant integration | [Docs](docs/ai/introduction.md) |
| `laravilt/plugins` | Plugin system & generators | [Docs](docs/plugins/introduction.md) |

## Requirements

- PHP 8.3+
- Laravel 12+
- Node.js 18+
- npm or pnpm

## Installation

```bash
composer require laravilt/laravilt
```

Run the installer:

```bash
php artisan laravilt:install
```

This will:
- Publish all configurations
- Run migrations
- Setup frontend assets
- Clear caches

### Create Admin User

```bash
php artisan laravilt:make-user
```

## Quick Start

### 1. Create a Panel

```bash
php artisan laravilt:panel admin
```

### 2. Create a Resource

```bash
php artisan laravilt:resource User --generate
```

This generates a complete CRUD resource with:
- Resource class
- Form definition
- Table definition
- List, Create, Edit, View pages

### 3. Configure the Panel

```php
// app/Providers/Laravilt/AdminPanelProvider.php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => '#3b82f6',
            ])
            ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
            ->discoverPages(in: app_path('Laravilt/Admin/Pages'))
            ->globalSearch()
            ->aiProviders(fn ($ai) => $ai
                ->openai()
                ->anthropic()
            );
    }
}
```

## CLI Commands

### Panel Management
- `laravilt:panel {name}` - Create a new panel
- `laravilt:page {name}` - Create a panel page
- `laravilt:cluster {name}` - Create a page cluster

### Resource Management
- `laravilt:resource {name}` - Create a resource
- `laravilt:relation {name}` - Create a relation manager

### Plugin Development
- `laravilt:plugin {name}` - Create a new plugin
- `laravilt:component {name}` - Generate plugin components
- `laravilt:make {type}` - Generate Laravel components in plugin

### System
- `laravilt:install` - Install/update Laravilt
- `laravilt:make-user` - Create admin user

## Configuration

Publish the configuration:

```bash
php artisan vendor:publish --tag=laravilt-config
```

Key configuration options in `config/laravilt.php`:

```php
return [
    'user_model' => App\Models\User::class,
    'path' => 'admin',
    'guard' => 'web',
    'locale' => 'en',
    'locales' => ['en' => 'English', 'ar' => 'Arabic'],
    'dark_mode' => true,
    'features' => [
        'ai_assistant' => true,
        'global_search' => true,
        'notifications' => true,
    ],
    'ai' => [
        'provider' => env('LARAVILT_AI_PROVIDER', 'openai'),
        'model' => env('LARAVILT_AI_MODEL', 'gpt-4'),
    ],
];
```

## Form Fields

Available form field types:

- Text, Textarea, RichEditor, MarkdownEditor
- Number, Currency, Percent
- Select, MultiSelect, Radio, Checkbox
- Toggle, Switch
- DatePicker, DateTimePicker, TimePicker, DateRangePicker
- FileUpload, ImageUpload
- ColorPicker, IconPicker
- Repeater, Builder, KeyValue
- Code Editor, JSON Editor
- Tags, Rating, Slider
- And more...

## Table Features

- Sortable columns
- Searchable columns
- Filterable with custom filters
- Bulk actions
- Row actions
- Export to CSV/Excel
- Pagination with per-page options
- Sticky header support
- Column visibility toggle

## AI Features

### Global Search
AI-enhanced search across all registered resources.

### AI Chat
Built-in chat interface supporting:
- OpenAI (GPT-3.5, GPT-4, GPT-4o)
- Anthropic (Claude 3, Claude 3.5)
- Google Gemini

Configure providers in `.env`:

```env
OPENAI_API_KEY=sk-...
ANTHROPIC_API_KEY=sk-ant-...
GOOGLE_AI_API_KEY=...
```

## Testing

```bash
composer test
```

## Code Style

```bash
composer format
```

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.

## Credits

- Built by [Fady Mondy](https://github.com/3x1io)
- Inspired by [Filament PHP](https://filamentphp.com)
- UI components from [shadcn/vue](https://www.shadcn-vue.com)
