<?php

namespace Laravilt\Laravilt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallLaraviltCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'laravilt:install
                            {--panel= : Create a panel with the given name (e.g., admin)}
                            {--force : Overwrite existing files}
                            {--skip-migrations : Skip running migrations}
                            {--skip-npm : Skip running npm install and build}';

    /**
     * The console command description.
     */
    protected $description = 'Install Laravilt admin panel and all its packages';

    /**
     * Laravilt packages in installation order.
     */
    protected array $packages = [
        'laravilt-support' => 'Support utilities and helpers',
        'laravilt-panel' => 'Admin panel core',
        'laravilt-auth' => 'Authentication system',
        'laravilt-forms' => 'Form builder components',
        'laravilt-tables' => 'Table builder components',
        'laravilt-actions' => 'Action system',
        'laravilt-schemas' => 'Schema definitions',
        'laravilt-infolists' => 'Information list components',
        'laravilt-notifications' => 'Notification system',
        'laravilt-widgets' => 'Dashboard widgets',
        'laravilt-query-builder' => 'Query builder utilities',
        'laravilt-ai' => 'AI assistant features',
        'laravilt-plugins' => 'Plugin system',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->components->info('🚀 Installing Laravilt Admin Panel...');
        $this->newLine();

        // Step 1: Publish Vite config
        $this->publishViteConfig();

        // Step 2: Publish CSS
        $this->publishCss();

        // Step 3: Publish middleware
        $this->publishMiddleware();

        // Step 4: Publish layouts
        $this->publishLayouts();

        // Step 5: Publish components
        $this->publishComponents();

        // Step 6: Publish types
        $this->publishTypes();

        // Step 7: Publish User model
        $this->publishUserModel();

        // Step 8: Publish bootstrap files
        $this->publishBootstrap();

        // Step 9: Publish route files
        $this->publishRoutes();

        // Step 10: Publish all package configs
        $this->publishConfigs();

        // Step 11: Publish assets
        $this->publishAssets();

        // Step 12: Run migrations
        if (! $this->option('skip-migrations')) {
            $this->runMigrations();
        }

        // Step 13: Install npm dependencies and build
        if (! $this->option('skip-npm')) {
            $this->runNpmCommands();
        }

        // Step 14: Clear caches
        $this->clearCaches();

        // Step 15: Create panel if --panel option provided
        $panelName = $this->option('panel');
        if ($panelName) {
            $this->createPanel($panelName);
        }

        $this->newLine();
        $this->components->info('✅ Laravilt has been installed successfully!');
        $this->newLine();

        $nextSteps = [
            'Run <fg=yellow>php artisan serve</> or use Laravel Herd',
            'Run <fg=yellow>php artisan laravilt:user</> to create an admin user',
        ];

        if (! $panelName) {
            array_splice($nextSteps, 1, 0, 'Run <fg=yellow>php artisan make:panel admin</> to create your first panel');
        } else {
            $nextSteps[] = "Visit <fg=cyan>/{$panelName}</> to access the admin panel";
        }

        $this->components->bulletList($nextSteps);
        $this->newLine();

        return self::SUCCESS;
    }

    /**
     * Create a panel with the given name.
     */
    protected function createPanel(string $name): void
    {
        $this->components->task("Creating '{$name}' panel", function () use ($name) {
            Artisan::call('laravilt:panel', ['id' => $name]);

            return true;
        });
    }

    /**
     * Publish Vite configuration.
     */
    protected function publishViteConfig(): void
    {
        $stubPath = $this->getStubPath('vite.config.ts.stub');
        $targetPath = base_path('vite.config.ts');

        if (! File::exists($targetPath) || $this->option('force')) {
            if (File::exists($stubPath)) {
                $this->copyStub($stubPath, $targetPath);
            } else {
                // Create vite config inline if stub doesn't exist
                $this->createViteConfigInline($targetPath);
            }
            $this->components->info('Vite config published');
        } else {
            $this->components->warn('Skipped vite.config.ts (already exists, use --force to overwrite)');
        }
    }

    /**
     * Create vite.config.ts inline when stub is not available.
     */
    protected function createViteConfigInline(string $targetPath): void
    {
        $content = <<<'VITE'
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
            '@laravilt/panel': resolve(__dirname, 'vendor/laravilt/panel/resources/js'),
            '@laravilt/widgets': resolve(__dirname, 'vendor/laravilt/widgets/resources/js'),
            '@laravilt/forms': resolve(__dirname, 'vendor/laravilt/forms/resources/js'),
            '@laravilt/tables': resolve(__dirname, 'vendor/laravilt/tables/resources/js'),
            '@laravilt/actions': resolve(__dirname, 'vendor/laravilt/actions/resources/js'),
            '@laravilt/infolists': resolve(__dirname, 'vendor/laravilt/infolists/resources/js'),
            '@laravilt/notifications': resolve(__dirname, 'vendor/laravilt/notifications/resources/js'),
            '@laravilt/schemas': resolve(__dirname, 'vendor/laravilt/schemas/resources/js'),
            '@laravilt/support': resolve(__dirname, 'vendor/laravilt/support/resources/js'),
            '@laravilt/auth': resolve(__dirname, 'vendor/laravilt/auth/resources/js'),
            '@laravilt/ai': resolve(__dirname, 'vendor/laravilt/ai/resources/js'),
        },
        dedupe: ['vue', '@inertiajs/vue3'],
    },
    optimizeDeps: {
        include: ['@inertiajs/vue3', 'vue'],
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vue-vendor': ['vue', '@inertiajs/vue3'],
                },
            },
        },
    },
});
VITE;

        file_put_contents($targetPath, $content);
    }

    /**
     * Publish CSS files.
     */
    protected function publishCss(): void
    {
        $stubPath = $this->getStubPath('css/app.css.stub');
        $targetPath = resource_path('css/app.css');

        if (File::exists($stubPath)) {
            if (! File::exists($targetPath) || $this->option('force')) {
                $this->copyStub($stubPath, $targetPath);
                $this->components->info('CSS published');
            } else {
                $this->components->warn('Skipped css/app.css (already exists, use --force to overwrite)');
            }
        }
    }

    /**
     * Publish middleware files.
     */
    protected function publishMiddleware(): void
    {
        $this->copyStub(
            $this->getStubPath('Middleware/HandleInertiaRequests.stub'),
            app_path('Http/Middleware/HandleInertiaRequests.php')
        );

        $this->copyStub(
            $this->getStubPath('Middleware/HandleAppearance.stub'),
            app_path('Http/Middleware/HandleAppearance.php')
        );

        $this->components->info('Middleware published');
    }

    /**
     * Publish layout files.
     */
    protected function publishLayouts(): void
    {
        $layouts = [
            'AppLayout.vue',
            'AuthLayout.vue',
            'app/AppSidebarLayout.vue',
            'app/AppHeaderLayout.vue',
            'auth/AuthSimpleLayout.vue',
            'auth/AuthSplitLayout.vue',
            'auth/AuthCardLayout.vue',
            'settings/Layout.vue',
        ];

        foreach ($layouts as $layout) {
            $stubPath = $this->getStubPath("layouts/{$layout}.stub");
            $targetPath = resource_path("js/layouts/{$layout}");

            if (File::exists($stubPath)) {
                $this->copyStub($stubPath, $targetPath);
            }
        }

        $this->components->info('Layouts published');
    }

    /**
     * Publish bootstrap files.
     */
    protected function publishBootstrap(): void
    {
        // Only overwrite if force flag is set or user confirms
        if ($this->option('force') || $this->confirm('Overwrite bootstrap/app.php?', false)) {
            $this->copyStub(
                $this->getStubPath('bootstrap/app.stub'),
                base_path('bootstrap/app.php')
            );
            $this->components->info('Bootstrap app.php published');
        } else {
            $this->components->warn('Skipped bootstrap/app.php (already exists)');
        }

        // Publish providers if doesn't exist
        if (! File::exists(base_path('bootstrap/providers.php')) || $this->option('force')) {
            $this->copyStub(
                $this->getStubPath('bootstrap/providers.stub'),
                base_path('bootstrap/providers.php')
            );
            $this->components->info('Bootstrap providers.php published');
        } else {
            $this->components->warn('Skipped bootstrap/providers.php (already exists)');
        }
    }

    /**
     * Publish route files.
     */
    protected function publishRoutes(): void
    {
        // Publish web routes if doesn't exist
        if (! File::exists(base_path('routes/web.php')) || $this->option('force')) {
            $this->copyStub(
                $this->getStubPath('routes/web.stub'),
                base_path('routes/web.php')
            );
            $this->components->info('Route web.php published');
        } else {
            $this->components->warn('Skipped routes/web.php (already exists)');
        }

        // Publish settings routes
        $this->copyStub(
            $this->getStubPath('routes/settings.stub'),
            base_path('routes/settings.php')
        );
        $this->components->info('Route settings.php published');
    }

    /**
     * Publish Vue components.
     */
    protected function publishComponents(): void
    {
        $components = [
            // Core layout components
            'AppSidebar.vue',
            'AppSidebarHeader.vue',
            'AppShell.vue',
            'AppContent.vue',
            'AppHeader.vue',
            'AppLogo.vue',
            'AppLogoIcon.vue',

            // Navigation components
            'NavMain.vue',
            'NavFooter.vue',
            'NavUser.vue',
            'Breadcrumbs.vue',

            // UI components
            'Heading.vue',
            'HeadingSmall.vue',
            'Icon.vue',
            'InputError.vue',
            'TextLink.vue',
            'UserInfo.vue',
            'UserMenuContent.vue',
            'PlaceholderPattern.vue',
            'AlertError.vue',
            'AppearanceTabs.vue',

            // Auth components
            'DeleteUser.vue',
            'TwoFactorRecoveryCodes.vue',
            'TwoFactorSetupModal.vue',
        ];

        foreach ($components as $component) {
            $stubPath = $this->getStubPath("components/{$component}.stub");
            $targetPath = resource_path("js/components/{$component}");

            if (File::exists($stubPath)) {
                if (! File::exists($targetPath) || $this->option('force')) {
                    $this->copyStub($stubPath, $targetPath);
                }
            }
        }

        $this->components->info('Components published');
    }

    /**
     * Publish TypeScript type definitions.
     */
    protected function publishTypes(): void
    {
        $stubPath = $this->getStubPath('types/index.d.ts.stub');
        $targetPath = resource_path('js/types/index.d.ts');

        if (File::exists($stubPath)) {
            if (! File::exists($targetPath) || $this->option('force')) {
                $this->copyStub($stubPath, $targetPath);
                $this->components->info('Types published');
            } else {
                $this->components->warn('Skipped types/index.d.ts (already exists)');
            }
        }
    }

    /**
     * Publish User model with LaraviltUser trait.
     */
    protected function publishUserModel(): void
    {
        $stubPath = $this->getStubPath('Models/User.php.stub');
        $targetPath = app_path('Models/User.php');

        if (File::exists($stubPath)) {
            if ($this->option('force') || $this->confirm('Overwrite app/Models/User.php with LaraviltUser trait?', false)) {
                $this->copyStub($stubPath, $targetPath);
                $this->components->info('User model published with LaraviltUser trait');
            } else {
                $this->components->warn('Skipped User model (add LaraviltUser trait manually)');
                $this->components->info('Add this to your User model: use Laravilt\Auth\Concerns\LaraviltUser;');
            }
        }
    }

    /**
     * Publish configuration files for all packages.
     */
    protected function publishConfigs(): void
    {
        $this->components->task('Publishing configurations', function () {
            foreach ($this->packages as $tag => $description) {
                $params = ['--tag' => "{$tag}-config"];

                if ($this->option('force')) {
                    $params['--force'] = true;
                }

                Artisan::call('vendor:publish', $params);
            }

            return true;
        });
    }

    /**
     * Publish frontend assets.
     */
    protected function publishAssets(): void
    {
        $this->components->task('Publishing frontend assets', function () {
            $tags = [
                'laravilt-panel-views',
                'laravilt-panel-assets',
                'laravilt-auth-views',
                'laravilt-ai-views',
            ];

            foreach ($tags as $tag) {
                $params = ['--tag' => $tag];

                if ($this->option('force')) {
                    $params['--force'] = true;
                }

                Artisan::call('vendor:publish', $params);
            }

            return true;
        });
    }

    /**
     * Run database migrations.
     */
    protected function runMigrations(): void
    {
        $this->components->task('Running migrations', function () {
            Artisan::call('migrate', ['--force' => true]);

            return true;
        });
    }

    /**
     * Run npm install and build commands.
     */
    protected function runNpmCommands(): void
    {
        if (! $this->confirm('Would you like to install npm dependencies and build assets?', true)) {
            return;
        }

        $this->components->task('Installing npm dependencies', function () {
            exec('npm install 2>&1', $output, $exitCode);

            return $exitCode === 0;
        });

        $this->components->task('Building assets', function () {
            exec('npm run build 2>&1', $output, $exitCode);

            return $exitCode === 0;
        });
    }

    /**
     * Clear application caches.
     */
    protected function clearCaches(): void
    {
        $this->components->task('Clearing caches', function () {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            return true;
        });
    }

    /**
     * Get the path to a stub file from the panel package.
     */
    protected function getStubPath(string $stub): string
    {
        // Try vendor path first (for composer-installed packages)
        $vendorPath = base_path('vendor/laravilt/panel/stubs/'.$stub);
        if (File::exists($vendorPath)) {
            return $vendorPath;
        }

        // Try local packages path (for development)
        $localPath = base_path('packages/laravilt/panel/stubs/'.$stub);
        if (File::exists($localPath)) {
            return $localPath;
        }

        // Try relative to this package (for monorepo)
        $relativePath = dirname(__DIR__, 4).'/panel/stubs/'.$stub;
        if (File::exists($relativePath)) {
            return $relativePath;
        }

        return $vendorPath; // Return vendor path as default (will fail gracefully in copyStub)
    }

    /**
     * Copy a stub file to the target location.
     */
    protected function copyStub(string $from, string $to): void
    {
        $dir = dirname($to);

        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        if (File::exists($from)) {
            $content = file_get_contents($from);
            file_put_contents($to, $content);
        }
    }
}
