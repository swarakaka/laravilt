# Plugins Introduction

The Plugins package provides a complete, enterprise-grade plugin architecture for Laravilt, featuring automatic discovery, dependency management, and AI-assisted generation.

## Overview

Laravilt Plugins offers:

- **Plugin System** - Complete plugin architecture with FilamentPHP v4 integration
- **Auto-Discovery** - Automatic plugin detection from composer packages
- **Feature Factory** - Extensible generation system using Factory Pattern
- **Dependency Management** - Plugin dependencies with automatic resolution
- **Artisan Commands** - Generate plugins and components via CLI
- **MCP Integration** - Claude Code support for AI-assisted development
- **Reusable Traits** - Migrations, views, assets, commands, components, translations

---

## Creating a Plugin

### Using Artisan Command

```bash
# Interactive mode
php artisan laravilt:plugin

# Quick create with name
php artisan laravilt:plugin BlogManager

# With vendor name
php artisan laravilt:plugin BlogManager --vendor=mycompany
```

### Interactive Setup

The command will prompt you to:

1. **Enter plugin name** - e.g., "BlogManager"
2. **Enter vendor name** - e.g., "mycompany" or use default
3. **Select features**:
   - Laravilt plugin (Filament integration)
   - Database migrations
   - Blade views
   - Web routes
   - API routes
   - CSS assets (Tailwind v4)
   - JavaScript assets (Vue.js + Vite)
   - Language files
   - GitHub workflows
   - PHPStan configuration
4. **Post-generation options**:
   - Initialize Git repository
   - Run composer install
   - Run tests

---

## Plugin Structure

### Generated Directory Structure

```
packages/mycompany/blog-manager/
├── config/
│   └── laravilt-blog-manager.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── lang/
│   │   ├── en/
│   │   └── ar/
│   └── dist/
│       ├── app.css
│       └── app.js
├── routes/
│   ├── web.php
│   └── api.php
├── src/
│   ├── BlogManagerPlugin.php
│   ├── BlogManagerServiceProvider.php
│   ├── Commands/
│   │   └── InstallCommand.php
│   ├── Models/
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
├── tests/
│   ├── Pest.php
│   └── TestCase.php
├── composer.json
├── README.md
└── .gitignore
```

---

## Plugin Base Classes

### Option 1: PluginProvider (Recommended)

For tight integration with the host application:

```php
<?php

namespace MyCompany\BlogManager;

use Laravilt\Plugins\PluginProvider;
use Laravilt\Plugins\Contracts\Plugin;
use Filament\Panel;

class BlogManagerPlugin extends PluginProvider implements Plugin
{
    protected static string $id = 'blog-manager';
    protected static string $name = 'Blog Manager';
    protected static string $version = '1.0.0';
    protected static string $description = 'Manage blog posts and categories';
    protected static string $author = 'MyCompany';
    protected static array $dependencies = [];

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\PostResource::class,
            Resources\CategoryResource::class,
        ])->pages([
            Pages\Dashboard::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        // Boot logic
    }
}
```

### Option 2: BasePlugin

For standalone packages:

```php
<?php

namespace MyCompany\BlogManager;

use Laravilt\Plugins\BasePlugin;
use Laravilt\Plugins\Contracts\Plugin;
use Spatie\LaravelPackageTools\Package;

class BlogManagerPlugin extends BasePlugin implements Plugin
{
    protected static string $id = 'blog-manager';
    protected static string $name = 'Blog Manager';

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravilt/blog-manager')
            ->hasConfigFile('laravilt-blog-manager')
            ->hasMigrations(['create_posts_table', 'create_categories_table'])
            ->hasViews()
            ->hasTranslations()
            ->hasRoutes('web', 'api')
            ->hasCommands([
                Commands\InstallCommand::class,
            ]);
    }
}
```

---

## Plugin Properties

### Required Properties

```php
protected static string $id = 'unique-plugin-id';
protected static string $name = 'Display Name';
```

### Optional Properties

```php
protected static string $version = '1.0.0';
protected static string $description = 'Plugin description';
protected static string $author = 'Author Name';
protected static array $dependencies = ['other-plugin-id'];
protected bool $enabled = true;
```

---

## Plugin Traits (Concerns)

### HasMigrations

Load database migrations:

```php
use Laravilt\Plugins\Concerns\HasMigrations;

class MyPlugin extends PluginProvider
{
    use HasMigrations;

    public function boot(): void
    {
        $this->loadMigrations();
        // Loads from database/migrations
    }
}
```

### HasViews

Load Blade views:

```php
use Laravilt\Plugins\Concerns\HasViews;

class MyPlugin extends PluginProvider
{
    use HasViews;

    public function boot(): void
    {
        $this->loadViews();
        // Loads from resources/views
        // Namespace: plugin-id
    }

    public function getViewNamespace(): string
    {
        return 'blog-manager';
    }
}
```

### HasAssets

Publish CSS/JS assets:

```php
use Laravilt\Plugins\Concerns\HasAssets;

class MyPlugin extends PluginProvider
{
    use HasAssets;

    protected array $assets = ['app.css', 'app.js'];

    public function boot(): void
    {
        $this->publishAssets();
        // Publishes to public/vendor/blog-manager
    }
}
```

### HasCommands

Register Artisan commands:

```php
use Laravilt\Plugins\Concerns\HasCommands;

class MyPlugin extends PluginProvider
{
    use HasCommands;

    protected array $commands = [
        Commands\InstallCommand::class,
        Commands\SyncCommand::class,
    ];

    public function boot(): void
    {
        $this->registerPluginCommands();
    }
}
```

### HasTranslations

Load translation files:

```php
use Laravilt\Plugins\Concerns\HasTranslations;

class MyPlugin extends PluginProvider
{
    use HasTranslations;

    public function boot(): void
    {
        $this->loadTranslations();
        // Loads from resources/lang
        // Namespace: plugin-id
    }
}
```

---

## Generating Components

### Create Components in Plugin

```bash
# Model
php artisan laravilt:make blog-manager model Post

# Migration
php artisan laravilt:make blog-manager migration create_posts_table

# Controller
php artisan laravilt:make blog-manager controller PostController

# Command
php artisan laravilt:make blog-manager command SyncCommand

# Resource (Filament)
php artisan laravilt:make blog-manager resource PostResource

# Test
php artisan laravilt:make blog-manager test PostTest
```

### Available Component Types

- `migration` - Database Migration
- `model` - Eloquent Model
- `controller` - Controller
- `command` - Artisan Command
- `job` - Job
- `event` - Event
- `listener` - Event Listener
- `notification` - Notification
- `seeder` - Database Seeder
- `factory` - Model Factory
- `test` - Test
- `resource` - Filament Resource
- `page` - Filament Page
- `widget` - Filament Widget

---

## Plugin Registration

### Auto-Discovery

Plugins are automatically discovered if listed in `composer.json`:

```json
{
    "name": "mycompany/blog-manager",
    "extra": {
        "laravel": {
            "providers": [
                "MyCompany\\BlogManager\\BlogManagerPlugin"
            ]
        }
    }
}
```

### Manual Registration

Register plugin with Filament panel:

```php
<?php

namespace App\Providers\Laravilt;

use MyCompany\BlogManager\BlogManagerPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugins([
                BlogManagerPlugin::make(),
            ]);
    }
}
```

---

## Plugin Dependencies

### Declaring Dependencies

```php
class BlogManagerPlugin extends PluginProvider
{
    protected static array $dependencies = [
        'comments-system',
        'media-library',
    ];
}
```

### Dependency Resolution

The plugin manager automatically:
1. Validates dependencies on registration
2. Boots dependencies before dependent plugins
3. Throws exception if dependencies not satisfied

---

## Plugin Configuration

### Config File

Generated config file at `config/laravilt-{plugin-id}.php`:

```php
<?php

return [
    'enabled' => env('LARAVILT_BLOG_MANAGER_ENABLED', true),

    'post_per_page' => env('BLOG_POST_PER_PAGE', 10),

    'allow_comments' => env('BLOG_ALLOW_COMMENTS', true),

    'moderation' => [
        'enabled' => true,
        'auto_approve' => false,
    ],
];
```

### Accessing Configuration

```php
config('laravilt-blog-manager.post_per_page')
```

---

## Plugin Manager

### Using the Facade

```php
use Laravilt\Plugins\Facades\LaraviltPlugins;

// Get all plugins
$plugins = LaraviltPlugins::all();

// Get enabled plugins only
$enabled = LaraviltPlugins::enabled();

// Get specific plugin
$plugin = LaraviltPlugins::get('blog-manager');

// Check if plugin exists
if (LaraviltPlugins::has('blog-manager')) {
    // ...
}

// Register plugin
LaraviltPlugins::register($plugin);

// Boot all plugins
LaraviltPlugins::bootAll();
```

### Plugin Manifest

```php
$manifest = LaraviltPlugins::getManifest();

// Returns array of all plugins:
[
    [
        'id' => 'blog-manager',
        'name' => 'Blog Manager',
        'version' => '1.0.0',
        'description' => '...',
        'author' => 'MyCompany',
        'enabled' => true,
        'dependencies' => [],
    ],
    // ...
]
```

---

## MCP Server Integration

The Plugins package includes an MCP server for AI-assisted development:

### Available Tools for Claude

1. **List Plugins** - View all installed plugins
2. **Plugin Info** - Get detailed information about a plugin
3. **Generate Plugin** - Create new plugin with AI guidance
4. **Generate Component** - Create components within plugins
5. **List Component Types** - View available component types
6. **Plugin Structure** - View plugin directory structure
7. **Search Docs** - Search plugin documentation

### Using with Claude Code

```
User: List all my Laravilt plugins
Claude: [Uses ListPluginsTool to show plugins]

User: Create a new plugin called "ProductCatalog" with migrations and API routes
Claude: [Uses GeneratePluginTool with selected features]

User: Add a Product model to the product-catalog plugin
Claude: [Uses GenerateComponentTool]
```

---

## Complete Example

### Creating a Blog Manager Plugin

**Step 1: Generate Plugin**

```bash
php artisan laravilt:plugin BlogManager
```

**Step 2: Select Features**
- ✅ Laravilt plugin
- ✅ Database migrations
- ✅ Blade views
- ✅ Web routes
- ✅ API routes
- ✅ Language files (en, ar)

**Step 3: Generate Components**

```bash
# Models
php artisan laravilt:make blog-manager model Post
php artisan laravilt:make blog-manager model Category

# Migrations
php artisan laravilt:make blog-manager migration create_posts_table
php artisan laravilt:make blog-manager migration create_categories_table

# Resources
php artisan laravilt:make blog-manager resource PostResource
php artisan laravilt:make blog-manager resource CategoryResource
```

**Step 4: Define Plugin Class**

```php
<?php

namespace MyCompany\BlogManager;

use Laravilt\Plugins\PluginProvider;
use Laravilt\Plugins\Contracts\Plugin;
use Filament\Panel;

class BlogManagerPlugin extends PluginProvider implements Plugin
{
    use Concerns\HasMigrations;
    use Concerns\HasViews;
    use Concerns\HasTranslations;

    protected static string $id = 'blog-manager';
    protected static string $name = 'Blog Manager';
    protected static string $version = '1.0.0';
    protected static string $description = 'Complete blog management system';
    protected static string $author = 'MyCompany';

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                Resources\PostResource::class,
                Resources\CategoryResource::class,
            ])
            ->pages([
                Pages\BlogDashboard::class,
            ])
            ->widgets([
                Widgets\PostsOverview::class,
                Widgets\PopularPosts::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        $this->loadMigrations();
        $this->loadViews();
        $this->loadTranslations();
    }
}
```

**Step 5: Register in App**

```php
// In app/Providers/Laravilt/AdminPanelProvider.php
use MyCompany\BlogManager\BlogManagerPlugin;

return $panel->plugins([
    BlogManagerPlugin::make(),
]);
```

---

## Plugin Features

The plugin generator supports 19 features via Factory Pattern:

1. **Composer.json** - Package definition
2. **Service Provider** - Laravel service provider
3. **Plugin Class** - Filament plugin class
4. **Install Command** - Custom install command
5. **Config File** - Configuration file
6. **Migrations** - Database structure
7. **Routes** - Web and API routes
8. **Views** - Blade templates
9. **Languages** - Multi-language support
10. **CSS Assets** - Tailwind v4 styling
11. **JS Assets** - Vue.js + Vite
12. **Arts** - Cover image generation
13. **Testing** - Pest/PHPUnit setup
14. **README** - Comprehensive documentation
15. **GitHub** - Workflows and templates
16. **Documentation** - CHANGELOG, LICENSE, etc.
17. **Testbench** - Package testing config
18. **Pint** - Code formatting
19. **PHPStan** - Static analysis

---

## Best Practices

### 1. Use Semantic Versioning

```php
protected static string $version = '1.2.3';
// MAJOR.MINOR.PATCH
```

### 2. Declare Dependencies

```php
protected static array $dependencies = [
    'required-plugin-id',
];
```

### 3. Provide Clear Metadata

```php
protected static string $name = 'User-Friendly Name';
protected static string $description = 'Clear description of plugin purpose';
protected static string $author = 'Company or Author Name';
```

### 4. Use Traits for Common Features

```php
use Concerns\HasMigrations;
use Concerns\HasViews;
use Concerns\HasTranslations;
```

### 5. Follow Naming Conventions

- Plugin ID: `kebab-case`
- Class Name: `PascalCase`
- Namespace: `Vendor\PluginName`

---

## Next Steps

- [AI Package](../ai/introduction.md) - AI integration for plugins
- [Panel](../panel/introduction.md) - Panel configuration
- [Support](../support/introduction.md) - Base utilities
