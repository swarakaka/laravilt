---
title: Commands
description: Generate plugin commands
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: commands
---

# Commands

Generate Artisan commands for plugins.

## Generate Command

```bash
php artisan laravilt:make blog-manager command InstallCommand
```

## Install Command

```php
<?php

namespace MyCompany\BlogManager\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'blog-manager:install
                            {--force : Overwrite existing files}';

    protected $description = 'Install the Blog Manager plugin';

    public function handle(): int
    {
        $this->info('Installing Blog Manager...');

        // Publish config
        $this->callSilently('vendor:publish', [
            '--tag' => 'blog-manager-config',
            '--force' => $this->option('force'),
        ]);
        $this->info('✓ Configuration published');

        // Run migrations
        $this->call('migrate');
        $this->info('✓ Migrations completed');

        $this->newLine();
        $this->info('Blog Manager installed!');

        return self::SUCCESS;
    }
}
```

## Register Commands

```php
<?php

use Laravilt\Plugins\Concerns\HasCommands;

class BlogPlugin extends PluginProvider
{
    use HasCommands;

    protected array $pluginCommands = [
        Commands\InstallCommand::class,
        Commands\SyncCommand::class,
    ];

    public function boot(Panel $panel): void
    {
        $this->registerPluginCommands();
    }
}
```

## Custom Command

```php
<?php

namespace MyCompany\BlogManager\Commands;

use Illuminate\Console\Command;
use MyCompany\BlogManager\Models\Post;

class SyncCommand extends Command
{
    protected $signature = 'blog-manager:sync';

    protected $description = 'Sync blog posts';

    public function handle(): int
    {
        $posts = Post::all();

        $this->withProgressBar($posts, function ($post) {
            // Sync logic
        });

        $this->newLine();
        $this->info('Posts synced!');

        return self::SUCCESS;
    }
}
```
