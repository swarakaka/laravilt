# Architecture Overview

Laravilt is built on a modular, layered architecture that separates concerns and allows for flexible customization. This document explains the core architectural concepts.

## Package Architecture

Laravilt consists of 14 specialized packages organized in a layered dependency structure:

```
┌─────────────────────────────────────────────────────────────────┐
│                     LARAVILT (Meta Package)                     │
├─────────────────────────────────────────────────────────────────┤
│                      ADVANCED LAYER                             │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────────┐ │
│  │     AI      │  │   Plugins   │  │         Auth            │ │
│  └─────────────┘  └─────────────┘  └─────────────────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│                     INTEGRATION LAYER                           │
│  ┌─────────────────────────────────────────────────────────────┐│
│  │                         Panel                                ││
│  └─────────────────────────────────────────────────────────────┘│
├─────────────────────────────────────────────────────────────────┤
│                      CORE LAYER 2                               │
│  ┌──────────┐  ┌──────────┐  ┌───────────┐  ┌───────────────┐  │
│  │  Forms   │  │  Tables  │  │ Infolists │  │    Widgets    │  │
│  └──────────┘  └──────────┘  └───────────┘  └───────────────┘  │
├─────────────────────────────────────────────────────────────────┤
│                      CORE LAYER 1                               │
│  ┌──────────┐  ┌───────────────┐  ┌─────────┐  ┌─────────────┐ │
│  │ Schemas  │  │ Query-Builder │  │ Actions │  │Notifications│ │
│  └──────────┘  └───────────────┘  └─────────┘  └─────────────┘ │
├─────────────────────────────────────────────────────────────────┤
│                     FOUNDATION LAYER                            │
│  ┌─────────────────────────────────────────────────────────────┐│
│  │                        Support                               ││
│  └─────────────────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────────────────┘
```

### Package Dependencies

| Package | Dependencies |
|---------|--------------|
| **Support** | None (foundation) |
| **Schemas** | Support |
| **Query-Builder** | Support |
| **Actions** | None |
| **Notifications** | None |
| **Forms** | Support, Schemas, Actions |
| **Tables** | Support, Query-Builder, Forms, Actions |
| **Infolists** | Schemas |
| **Widgets** | Support |
| **Panel** | Support, Auth, Actions, Forms |
| **Auth** | Support, Panel, Fortify, Socialite, Sanctum |
| **AI** | Illuminate packages |
| **Plugins** | Illuminate packages |
| **Laravilt** | All packages (meta) |

---

## Core Concepts

### 1. Components

All UI elements in Laravilt extend the base `Component` class from the Support package:

```php
namespace Laravilt\Support;

abstract class Component implements Arrayable, Buildable, Jsonable, Serializable
{
    use CanBeDisabled;
    use CanBeReadonly;
    use CanBeRequired;
    use HasColumnSpan;
    use HasHelperText;
    use HasId;
    use HasLabel;
    use HasPlaceholder;
    use HasVisibility;
    use InteractsWithState;

    public static function make(string $name): static
    {
        return app(static::class, ['name' => $name]);
    }

    abstract public function toLaraviltProps(): array;
}
```

Components follow a **fluent builder pattern**:

```php
TextInput::make('email')
    ->label('Email Address')
    ->placeholder('user@example.com')
    ->required()
    ->email()
    ->maxLength(255);
```

### 2. Panels

A Panel is a self-contained admin interface. Each panel has:
- Unique ID and path
- Resources (CRUD entities)
- Pages (custom pages)
- Navigation
- Theme and branding
- Authentication configuration

```php
namespace App\Laravilt\Admin;

use Laravilt\Panel\PanelProvider;

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
            ->discoverPages(in: app_path('Laravilt/Admin/Pages'));
    }
}
```

### 3. Resources

Resources represent database entities with full CRUD functionality:

```php
namespace App\Laravilt\Admin\Resources;

use Laravilt\Panel\Resource;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'Users';
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('email')->searchable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
            'view' => ViewUser::route('/{record}'),
        ];
    }
}
```

### 4. Actions

Actions are interactive elements that perform operations:

```php
use Laravilt\Actions\Action;

Action::make('approve')
    ->label('Approve')
    ->icon('Check')
    ->color('success')
    ->requiresConfirmation()
    ->modalHeading('Approve User')
    ->modalDescription('Are you sure you want to approve this user?')
    ->action(function (User $record) {
        $record->approve();
    });
```

---

## Data Flow

### Request Lifecycle

```
┌─────────────────────────────────────────────────────────────────┐
│                         HTTP Request                            │
└───────────────────────────────┬─────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                    Laravel Router                               │
│                  (routes/web.php)                               │
└───────────────────────────────┬─────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                  Panel Middleware Stack                         │
│  ┌─────────────┐ ┌─────────────┐ ┌───────────────────────────┐ │
│  │IdentifyPanel│→│ Authenticate│→│ SharePanelData            │ │
│  └─────────────┘ └─────────────┘ └───────────────────────────┘ │
└───────────────────────────────┬─────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                    Panel Controller                             │
│        (Resource Page / Custom Page / API)                      │
└───────────────────────────────┬─────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                  Inertia Response                               │
│              (JSON for Vue component)                           │
└───────────────────────────────┬─────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                    Vue Component                                │
│                  (renders HTML)                                 │
└─────────────────────────────────────────────────────────────────┘
```

### Component Serialization

Components serialize to different formats for different platforms:

```php
// For Inertia/Vue (frontend)
$component->toLaraviltProps();

// For REST API
$component->toApiProps();

// For Flutter mobile
$component->toFlutterProps();
```

Example serialization output:

```json
{
    "component": "text_input",
    "name": "email",
    "label": "Email Address",
    "placeholder": "user@example.com",
    "required": true,
    "type": "email",
    "maxLength": 255,
    "columnSpan": 1
}
```

---

## Service Provider Architecture

Each package registers a service provider that:

1. **Registers Services** - Binds classes to the container
2. **Publishes Assets** - Config, views, migrations, assets
3. **Registers Commands** - Artisan commands
4. **Registers Routes** - Package-specific routes
5. **Registers Blade Components** - If applicable

### Registration Order

```php
// bootstrap/providers.php
return [
    // Laravel providers first
    App\Providers\AppServiceProvider::class,

    // Laravilt foundation
    Laravilt\Support\SupportServiceProvider::class,

    // Core packages
    Laravilt\Schemas\SchemasServiceProvider::class,
    Laravilt\Forms\FormsServiceProvider::class,
    Laravilt\Tables\TablesServiceProvider::class,
    Laravilt\Actions\ActionsServiceProvider::class,
    Laravilt\Notifications\NotificationsServiceProvider::class,

    // Integration layer
    Laravilt\Panel\PanelServiceProvider::class,
    Laravilt\Auth\AuthServiceProvider::class,

    // Application panels
    App\Laravilt\Admin\AdminPanelProvider::class,
];
```

---

## Frontend Architecture

### Inertia.js Integration

Laravilt uses Inertia.js v2 for seamless Laravel-Vue integration:

```
┌─────────────────────────────────────────────────────────────────┐
│                     Laravel Backend                             │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │                  Inertia::render()                       │   │
│  │     return Inertia::render('Panel/Resource/List', [      │   │
│  │         'records' => $records,                           │   │
│  │         'table' => $table->toLaraviltProps(),            │   │
│  │     ]);                                                   │   │
│  └─────────────────────────────────────────────────────────┘   │
└───────────────────────────────┬─────────────────────────────────┘
                                │ JSON
                                ▼
┌─────────────────────────────────────────────────────────────────┐
│                      Vue Frontend                               │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │     <script setup>                                       │   │
│  │     defineProps<{                                        │   │
│  │         records: Record[],                               │   │
│  │         table: TableProps,                               │   │
│  │     }>();                                                 │   │
│  │     </script>                                            │   │
│  └─────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
```

### Vue Component Structure

```
resources/js/
├── app.ts                    # Application entry
├── pages/                    # Inertia pages
│   ├── admin/               # Panel pages
│   │   ├── Dashboard.vue
│   │   └── resources/
│   │       └── users/
│   │           ├── List.vue
│   │           ├── Create.vue
│   │           └── Edit.vue
├── components/              # Shared components
│   ├── ui/                  # UI primitives (shadcn)
│   └── laravilt/           # Laravilt components
├── composables/            # Vue composables
└── layouts/                # Layout components
```

### UI Component Library

Laravilt uses [shadcn/ui](https://ui.shadcn.com/) (Reka UI) for base components:

- Button, Input, Select, Checkbox, etc.
- Dialog, Sheet, Popover, Tooltip
- Table, Card, Badge
- Toast notifications

---

## Trait-Based Composition

Laravilt uses traits extensively for composable functionality:

```php
// State Management
trait InteractsWithState
{
    protected mixed $state = null;

    public function state(mixed $state): static
    {
        $this->state = $state;
        return $this;
    }

    public function getState(): mixed
    {
        return $this->state;
    }
}

// Visibility Control
trait HasVisibility
{
    protected bool|Closure $isHidden = false;
    protected bool|Closure $isVisible = true;

    public function hidden(bool|Closure $condition = true): static
    {
        $this->isHidden = $condition;
        return $this;
    }

    public function visible(bool|Closure $condition = true): static
    {
        $this->isVisible = $condition;
        return $this;
    }
}

// Column Span for Grid Layouts
trait HasColumnSpan
{
    protected int|string|array $columnSpan = 1;

    public function columnSpan(int|string|array $span): static
    {
        $this->columnSpan = $span;
        return $this;
    }

    public function columnSpanFull(): static
    {
        $this->columnSpan = 'full';
        return $this;
    }
}
```

---

## Configuration System

Each package publishes its own configuration:

```bash
# Publish all configs
php artisan vendor:publish --tag=laravilt-config

# Publish specific package config
php artisan vendor:publish --tag=laravilt-panel-config
```

Configuration files:

```
config/
├── laravilt.php              # Main config
├── laravilt-panel.php        # Panel settings
├── laravilt-auth.php         # Auth settings
├── laravilt-forms.php        # Forms settings
├── laravilt-tables.php       # Tables settings
├── laravilt-actions.php      # Actions settings
├── laravilt-notifications.php # Notifications
├── laravilt-widgets.php      # Widgets settings
└── laravilt-ai.php           # AI settings
```

---

## Next Steps

- [Quick Start Guide](quick-start.md) - Build your first resource
- [Panel Documentation](../panel/introduction.md) - Deep dive into panels
- [Forms Documentation](../forms/introduction.md) - Learn form building
