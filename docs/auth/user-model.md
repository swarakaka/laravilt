---
title: User Model Setup
description: Configure your User model for Laravilt authentication
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
---

# User Model Setup

Add the `LaraviltUser` trait to your User model to enable all authentication features.

## Basic Setup

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravilt\Auth\Concerns\LaraviltUser;

class User extends Authenticatable
{
    use Notifiable;
    use LaraviltUser;

    protected $fillable = [
        'name',
        'email',
        'password',
        'locale',
        'timezone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'two_factor_enabled' => 'boolean',
            'password' => 'hashed',
        ];
    }
}
```

## Trait Features

The `LaraviltUser` trait adds:

### Properties

- `locale` - User's preferred language
- `timezone` - User's timezone
- `two_factor_enabled` - 2FA status
- `two_factor_method` - Active 2FA method
- `two_factor_secret` - Encrypted TOTP secret
- `two_factor_recovery_codes` - Hashed backup codes
- `two_factor_confirmed_at` - 2FA confirmation timestamp

### Relationships

```php
// OAuth connections
$user->socialAccounts;

// WebAuthn credentials
$user->webauthnCredentials;

// Active sessions
$user->sessions;
```

### Methods

```php
// Check 2FA status
$user->hasTwoFactorEnabled();

// Check passkeys
$user->hasPasskeys();

// Get avatar URL
$user->getAvatarUrl();

// Get initials for avatar fallback
$user->getInitials();
```

## Related

- [Configuration](configuration) - Auth configuration
- [Migrations](migrations) - Database migrations
