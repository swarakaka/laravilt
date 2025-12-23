---
title: Auth Migrations
description: Database migrations for authentication features
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
---

# Auth Migrations

Run the auth migrations to create required database tables.

## Installation

```bash
php artisan vendor:publish --tag=laravilt-auth-migrations
php artisan migrate
```

## Tables Created

| Table | Purpose |
|-------|---------|
| `social_accounts` | OAuth provider connections |
| `webauthn_credentials` | Passkey registrations |
| `two_factor_codes` | Temporary 2FA codes |
| `otp_codes` | One-time passwords |
| `personal_access_tokens` | API tokens (Sanctum) |

## User Table Columns

The migration adds these columns to the `users` table:

```sql
ALTER TABLE users ADD (
    two_factor_enabled boolean DEFAULT false,
    two_factor_method string nullable,
    two_factor_secret text nullable,
    two_factor_recovery_codes text nullable,
    two_factor_confirmed_at timestamp nullable,
    locale string nullable,
    timezone string nullable
);
```

## Social Accounts Table

```php
Schema::create('social_accounts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('provider');
    $table->string('provider_id');
    $table->string('name')->nullable();
    $table->string('email')->nullable();
    $table->string('avatar')->nullable();
    $table->text('token')->nullable();
    $table->text('refresh_token')->nullable();
    $table->timestamp('token_expires_at')->nullable();
    $table->timestamps();

    $table->unique(['provider', 'provider_id']);
});
```

## WebAuthn Credentials Table

```php
Schema::create('webauthn_credentials', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->text('credential_id');
    $table->text('public_key');
    $table->unsignedInteger('sign_count')->default(0);
    $table->timestamps();
});
```

## Related

- [User Model](user-model) - Setup user model
- [Configuration](configuration) - Auth configuration
