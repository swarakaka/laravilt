---
title: Configuration
description: Configure your Laravilt installation
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Configuration

## Environment Variables

Update your `.env` file:

```env
APP_NAME="My Admin"
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_DATABASE=my_database
DB_USERNAME=root
DB_PASSWORD=

# Recommended for admin panels
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

## Directory Structure

After installation:

```
app/
├── Laravilt/
│   └── Admin/
│       ├── AdminPanelProvider.php
│       ├── Pages/
│       │   └── Dashboard.php
│       └── Resources/
│           └── UserResource/
└── Providers/
    └── LaraviltServiceProvider.php

config/
├── laravilt.php
├── laravilt-panel.php
└── laravilt-auth.php
```

## Panel Configuration

Edit `app/Laravilt/Admin/AdminPanelProvider.php`:

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->login()
        ->colors(['primary' => '#3b82f6'])
        ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
        ->discoverPages(in: app_path('Laravilt/Admin/Pages'));
}
```

## Publishing Config

```bash
# All configs
php artisan vendor:publish --tag=laravilt-config

# Specific package
php artisan vendor:publish --tag=laravilt-panel-config
```

## Troubleshooting

**Assets not loading:**
```bash
npm run build && php artisan optimize:clear
```

**Database errors:**
```bash
php artisan config:clear && php artisan migrate:fresh
```

**Permission errors:**
```bash
chmod -R 775 storage bootstrap/cache
```

## Next Steps

- [Quick Start](quick-start) - Build your first resource
- [Architecture](architecture) - Understand the framework
