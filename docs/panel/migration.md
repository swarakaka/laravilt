# Migrating from Filament PHP

Laravilt provides an automated migration tool to seamlessly convert your existing Filament PHP v3/v4 applications to Laravilt. This guide covers the migration process, what gets converted, and any manual adjustments you may need to make.

## Prerequisites

Before migrating, ensure you have:

- A working Filament PHP v3 or v4 application
- Laravilt packages installed (`composer require laravilt/panel`)
- Backup of your current codebase

## Quick Start

Run the interactive migration command:

```bash
php artisan laravilt:filament
```

This will:
1. Scan your `app/Filament` directory
2. Display available resources, pages, and widgets
3. Let you select which components to migrate
4. Generate Laravilt-compatible files

## Command Options

### Source Directory

Specify a custom source directory containing Filament resources:

```bash
php artisan laravilt:filament --source=app/Filament/Admin
```

Default: `app/Filament`

### Target Directory

Specify the target directory for generated Laravilt resources:

```bash
php artisan laravilt:filament --target=app/Laravilt/Backend
```

Default: `app/Laravilt`

### Panel Name

Set the panel name for the migrated resources:

```bash
php artisan laravilt:filament --panel=Admin
```

Default: `Admin`

### Dry Run Mode

Preview changes without modifying any files:

```bash
php artisan laravilt:filament --dry-run
```

This shows what would be created without actually creating files.

### Force Overwrite

Overwrite existing files during migration:

```bash
php artisan laravilt:filament --force
```

### Migrate All

Skip the interactive selection and migrate all components:

```bash
php artisan laravilt:filament --all
```

### Full Example

```bash
php artisan laravilt:filament \
    --source=app/Filament/Admin/Resources \
    --target=app/Laravilt/Admin \
    --panel=Admin \
    --force \
    --all
```

---

## Namespace Mappings

The migration tool automatically converts Filament namespaces to their Laravilt equivalents.

### Core Resources

| Filament | Laravilt |
|----------|----------|
| `Filament\Resources\Resource` | `Laravilt\Panel\Resources\Resource` |
| `Filament\Resources\Pages\ListRecords` | `Laravilt\Panel\Pages\ListRecords` |
| `Filament\Resources\Pages\CreateRecord` | `Laravilt\Panel\Pages\CreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Laravilt\Panel\Pages\EditRecord` |
| `Filament\Resources\Pages\ViewRecord` | `Laravilt\Panel\Pages\ViewRecord` |
| `Filament\Resources\RelationManagers\RelationManager` | `Laravilt\Panel\Resources\RelationManagers\RelationManager` |

### Forms

| Filament | Laravilt |
|----------|----------|
| `Filament\Forms\Form` | `Laravilt\Schemas\Schema` |
| `Filament\Forms\Components\TextInput` | `Laravilt\Forms\Components\TextInput` |
| `Filament\Forms\Components\Select` | `Laravilt\Forms\Components\Select` |
| `Filament\Forms\Components\Checkbox` | `Laravilt\Forms\Components\Checkbox` |
| `Filament\Forms\Components\Section` | `Laravilt\Schemas\Components\Section` |
| `Filament\Forms\Components\Grid` | `Laravilt\Schemas\Components\Grid` |
| `Filament\Forms\Components\Tabs` | `Laravilt\Schemas\Components\Tabs` |
| `Filament\Forms\Components\Wizard` | `Laravilt\Schemas\Components\Wizard` |
| `Filament\Forms\Get` | `Laravilt\Support\Utilities\Get` |
| `Filament\Forms\Set` | `Laravilt\Support\Utilities\Set` |

### Tables

| Filament | Laravilt |
|----------|----------|
| `Filament\Tables\Table` | `Laravilt\Tables\Table` |
| `Filament\Tables\Columns\TextColumn` | `Laravilt\Tables\Columns\TextColumn` |
| `Filament\Tables\Columns\BadgeColumn` | `Laravilt\Tables\Columns\BadgeColumn` |
| `Filament\Tables\Columns\BooleanColumn` | `Laravilt\Tables\Columns\BooleanColumn` |
| `Filament\Tables\Filters\*` | `Laravilt\Tables\Filters\*` |

### Infolists

| Filament | Laravilt |
|----------|----------|
| `Filament\Infolists\Infolist` | `Laravilt\Infolists\Infolist` |
| `Filament\Infolists\Components\TextEntry` | `Laravilt\Infolists\Entries\TextEntry` |
| `Filament\Infolists\Components\IconEntry` | `Laravilt\Infolists\Entries\IconEntry` |
| `Filament\Infolists\Components\ImageEntry` | `Laravilt\Infolists\Entries\ImageEntry` |

### Actions

| Filament | Laravilt |
|----------|----------|
| `Filament\Actions\Action` | `Laravilt\Actions\Action` |
| `Filament\Actions\EditAction` | `Laravilt\Actions\EditAction` |
| `Filament\Actions\DeleteAction` | `Laravilt\Actions\DeleteAction` |
| `Filament\Actions\ViewAction` | `Laravilt\Actions\ViewAction` |
| `Filament\Actions\CreateAction` | `Laravilt\Actions\CreateAction` |
| `Filament\Actions\BulkAction` | `Laravilt\Actions\BulkAction` |

### Pages & Widgets

| Filament | Laravilt |
|----------|----------|
| `Filament\Pages\Page` | `Laravilt\Panel\Pages\Page` |
| `Filament\Pages\Dashboard` | `Laravilt\Panel\Pages\Dashboard` |
| `Filament\Widgets\Widget` | `Laravilt\Widgets\Widget` |
| `Filament\Widgets\StatsOverviewWidget` | `Laravilt\Widgets\StatsOverviewWidget` |
| `Filament\Widgets\ChartWidget` | `Laravilt\Widgets\ChartWidget` |

### Notifications

| Filament | Laravilt |
|----------|----------|
| `Filament\Notifications\Notification` | `Laravilt\Notifications\Notification` |

---

## Icon Mappings

Heroicon enum values are automatically converted to Lucide icon strings:

| Filament (Heroicon) | Laravilt (Lucide) |
|---------------------|-------------------|
| `Heroicon::OutlinedUsers` | `users` |
| `Heroicon::OutlinedHome` | `home` |
| `Heroicon::OutlinedCog` | `settings` |
| `Heroicon::OutlinedDocument` | `file` |
| `Heroicon::OutlinedFolder` | `folder` |
| `Heroicon::OutlinedShoppingCart` | `shopping-cart` |
| `Heroicon::OutlinedPencil` | `edit` |
| `Heroicon::OutlinedTrash` | `trash` |
| `Heroicon::OutlinedEye` | `eye` |
| `Heroicon::OutlinedPlus` | `plus` |

String-based Heroicon references are also converted:

```php
// Filament
protected static ?string $navigationIcon = 'heroicon-o-users';

// Becomes in Laravilt
protected static ?string $navigationIcon = 'Users';
```

---

## Third-Party Package Mappings

The migration tool handles common Filament third-party packages:

| Third-Party Package | Laravilt Equivalent |
|---------------------|---------------------|
| `RVxLab\FilamentColorPicker\Forms\ColorPicker` | `Laravilt\Forms\Components\ColorPicker` |
| `RVxLab\FilamentColorPicker\Columns\ColorSwatch` | `Laravilt\Tables\Columns\ColorColumn` |
| `FilamentTiptapEditor\TiptapEditor` | `Laravilt\Forms\Components\RichEditor` |
| `Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor` | `Laravilt\Forms\Components\RichEditor` |
| `Filament\Forms\Components\SpatieMediaLibraryFileUpload` | `Laravilt\Forms\Components\FileUpload` |

---

## Migration Statistics

After migration, the command displays statistics:

```
Migration completed successfully!

╔═════════════════════════════════════╗
║       Migration Summary             ║
╠═════════════════════════════════════╣
║ Resources:        5                 ║
║ Nested Resources: 2                 ║
║ Forms:            7                 ║
║ Tables:           7                 ║
║ Infolists:        3                 ║
║ Pages:            4                 ║
║ Widgets:          2                 ║
║ Relation Managers: 3                ║
║ Skipped:          0                 ║
╚═════════════════════════════════════╝
```

---

## Post-Migration Checklist

After running the migration:

### 1. Review Generated Files

Check the generated files in your target directory for any manual adjustments needed:

```bash
# View generated files
ls -la app/Laravilt/Admin/Resources/
```

### 2. Update Panel Provider

Register your new resources in the panel provider:

```php
// app/Providers/Laravilt/AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->resources([
            \App\Laravilt\Admin\Resources\User\UserResource::class,
            \App\Laravilt\Admin\Resources\Post\PostResource::class,
        ]);
}
```

### 3. Build Frontend Assets

Compile the frontend assets:

```bash
npm run build
```

### 4. Test CRUD Operations

Test all create, read, update, and delete operations to ensure everything works correctly.

### 5. Remove Filament (Optional)

Once verified, you can remove Filament:

```bash
composer remove filament/filament
```

---

## Manual Adjustments

Some features may require manual adjustment after migration:

### Custom Livewire Components

Filament's Livewire-based custom components need to be rewritten as Vue components for Laravilt.

### Complex Relationships

Nested or complex relationships may need manual configuration in the generated resources.

### Custom Actions

Actions with complex logic should be reviewed to ensure they work with Laravilt's action system.

### Plugins

Filament plugins are not automatically converted. Check if Laravilt has equivalent packages or reimplement the functionality.

---

## Troubleshooting

### Migration Fails with "Source directory does not exist"

Ensure your Filament resources are in the expected location:

```bash
ls app/Filament/Resources/
```

If in a different location, use the `--source` option.

### Namespace Conflicts

If you have existing Laravilt resources, use `--force` to overwrite or manually merge changes.

### Missing Icon Mappings

Some Heroicons may not have direct mappings. Update the icon manually:

```php
// Before
protected static ?string $navigationIcon = 'heroicon-o-custom-icon';

// After - use any Lucide icon
protected static ?string $navigationIcon = 'Star';
```

---

## Example Migration

### Before (Filament)

```php
<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

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
            TextColumn::make('email')->sortable(),
        ]);
    }
}
```

### After (Laravilt)

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use Laravilt\Panel\Resources\Resource;
use Laravilt\Schemas\Schema;
use Laravilt\Forms\Components\TextInput;
use Laravilt\Tables\Table;
use Laravilt\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'Users';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('email')->sortable(),
        ]);
    }
}
```

---

## Next Steps

- [Creating Panels](creating-panels.md) - Configure your panel
- [Resources](resources.md) - Customize your resources
- [Pages](pages.md) - Create custom pages
- [Navigation](navigation.md) - Configure navigation
