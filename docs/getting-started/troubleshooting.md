---
title: Troubleshooting
description: Common installation issues and solutions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Troubleshooting

Common issues and solutions during installation.

## Assets Not Loading

**Symptoms**: Blank page, missing styles, broken layout

**Solution**:

```bash
# Clear all caches
php artisan optimize:clear

# Rebuild assets
npm run build

# If using Vite dev server
npm run dev
```

## Database Connection Errors

**Symptoms**: SQLSTATE errors, connection refused

**Solution**:

```bash
# Clear config cache
php artisan config:clear

# Verify database exists
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS your_database"

# Re-run migrations
php artisan migrate:fresh
```

## Permission Errors

**Symptoms**: Failed to write, permission denied

**Solution**:

```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache

# Set ownership (Linux)
chown -R www-data:www-data storage bootstrap/cache

# Set ownership (macOS)
sudo chown -R $(whoami):staff storage bootstrap/cache
```

## Composer Memory Errors

**Symptoms**: Allowed memory size exhausted

**Solution**:

```bash
# Increase PHP memory limit
php -d memory_limit=-1 /usr/local/bin/composer install

# Or update php.ini
memory_limit = 2G
```

## Vite Build Errors

**Symptoms**: npm run build fails, module not found

**Solution**:

```bash
# Remove node_modules and reinstall
rm -rf node_modules package-lock.json
npm install

# Clear Vite cache
rm -rf node_modules/.vite
npm run build
```

## Session Issues

**Symptoms**: Login loop, CSRF token mismatch

**Solution**:

```bash
# Clear session data
php artisan session:table
php artisan migrate

# Update .env
SESSION_DRIVER=database
SESSION_DOMAIN=localhost
```

## Class Not Found

**Symptoms**: Class 'Laravilt\...' not found

**Solution**:

```bash
# Regenerate autoload
composer dump-autoload

# Clear bootstrap cache
php artisan clear-compiled

# Republish assets
php artisan vendor:publish --tag=laravilt-assets --force
```

## Frontend Component Errors

**Symptoms**: Vue component not rendering, hydration mismatch

**Solution**:

```bash
# Clear Laravel cache
php artisan view:clear
php artisan cache:clear

# Rebuild with fresh dependencies
npm ci
npm run build
```

## Getting Help

If issues persist:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Verify `.env` configuration matches your environment
4. Check [GitHub Issues](https://github.com/laravilt/laravilt/issues)

## Next Steps

- [Installation](installation) - Installation guide
- [Configuration](configuration) - Configuration options
