# Laravilt Documentation

Laravilt is a modern, modular admin panel framework for Laravel 12+ with Vue 3 (Inertia.js v2) frontend. It provides a complete solution for building admin panels, dashboards, and CRUD applications with minimal code.

## Table of Contents

### Getting Started
- [Installation](getting-started/installation.md)
- [Configuration](getting-started/configuration.md)
- [Quick Start](getting-started/quick-start.md)
- [Architecture Overview](getting-started/architecture.md)

### Core Packages

#### Panel
- [Introduction](panel/introduction.md)
- [Creating Panels](panel/creating-panels.md)
- [Resources](panel/resources.md)
- [Pages](panel/pages.md)
- [Navigation](panel/navigation.md)
- [Themes & Branding](panel/themes.md)
- [Multi-Tenancy](panel/tenancy.md)

#### Forms
- [Introduction](forms/introduction.md)
- [Field Types](forms/field-types.md)
- [Validation](forms/validation.md)
- [Layouts](forms/layouts.md)
- [Reactive Fields](forms/reactive-fields.md)
- [Custom Fields](forms/custom-fields.md)

#### Tables
- [Introduction](tables/introduction.md)
- [Columns](tables/columns.md)
- [Filters](tables/filters.md)
- [Actions](tables/actions.md)
- [Bulk Actions](tables/bulk-actions.md)
- [API Resources](tables/api-resources.md)

#### Actions
- [Introduction](actions/introduction.md)
- [Creating Actions](actions/creating-actions.md)
- [Modal Actions](actions/modal-actions.md)
- [Bulk Actions](actions/bulk-actions.md)

#### Auth
- [Introduction](auth/introduction.md)
- [Authentication Methods](auth/methods.md)
- [Two-Factor Authentication](auth/two-factor.md)
- [Social Authentication](auth/social.md)
- [Passkeys](auth/passkeys.md)
- [Profile Management](auth/profile.md)

### Additional Packages
- [Schemas](schemas/introduction.md)
- [Infolists](infolists/introduction.md)
- [Widgets](widgets/introduction.md)
- [Notifications](notifications/introduction.md)
- [Query Builder](query-builder/introduction.md)
- [AI Integration](ai/introduction.md)
- [Plugins](plugins/introduction.md)
- [Support](support/introduction.md)

## Requirements

- PHP 8.2+
- Laravel 12.x
- Node.js 18+
- npm or pnpm

## Quick Installation

```bash
# Create a new Laravel project with Vue starter kit
laravel new my-project
cd my-project

# Install Laravilt
composer require laravilt/laravilt

# Run the installer
php artisan laravilt:install

# Build frontend assets
npm install && npm run build
```

## License

Laravilt is open-sourced software licensed under the [MIT license](LICENSE.md).

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Support

- [GitHub Issues](https://github.com/laravilt/laravilt/issues)
- [Discussions](https://github.com/laravilt/laravilt/discussions)
