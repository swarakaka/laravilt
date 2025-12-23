---
title: Troubleshooting FAQ
description: Common issues and solutions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: faq
---

# Troubleshooting FAQ

Common issues and how to resolve them.

## Styles Not Loading

### My styles aren't loading

Run the build command:

```bash
npm run build
```

Clear caches:

```bash
php artisan optimize:clear
php artisan view:clear
```

## Forms Not Submitting

### Forms aren't submitting

1. Make sure `@csrf` is in your forms
2. Verify the route accepts POST requests
3. Check browser console for JavaScript errors

```php
<?php

// Correct route definition
Route::post('/submit', [FormController::class, 'submit']);
```

## 403 Errors

### I'm getting a 403 error

Check authorization policies:

```php
<?php

// In your policy
public function view(User $user, Model $model): bool
{
    return $user->can('view', $model);
}
```

Ensure user has required permissions:

```php
<?php

$user->givePermissionTo('view users');
```

## Vue Component Errors

### Vue components not rendering

1. Make sure Vue is properly installed
2. Check that components are registered
3. Verify Inertia.js is configured

```bash
npm install
npm run build
```

## Database Errors

### Migration errors

Reset and re-run migrations:

```bash
php artisan migrate:fresh --seed
```

Check database connection in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=laravilt
DB_USERNAME=root
DB_PASSWORD=
```

## Cache Issues

### Changes not reflecting

Clear all caches:

```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Support

### Where can I get help?

- [GitHub Issues](https://github.com/laravilt/laravilt/issues)
- [Discord Community](https://discord.gg/gyRhbVUXEZ)

### How do I report a bug?

Open an issue with:
- Laravilt version
- Laravel version
- PHP version
- Steps to reproduce
- Expected vs actual behavior

## Related

- [Installation](installation)
- [Forms FAQ](forms)

