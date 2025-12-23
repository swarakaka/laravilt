---
title: Email & Password Authentication
description: Traditional email and password login with registration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
method: email-password
---

# Email & Password Authentication

Traditional authentication using email and password credentials.

## Enable in Panel

```php
<?php

namespace App\Laravilt\Admin;

use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification();
    }
}
```

## Login Page

Enable the login page:

```php
$panel->login();

// Custom login route
$panel->login('/auth/login');
```

## Registration

Enable user registration:

```php
$panel->register();

// Custom registration route
$panel->register('/auth/register');
```

## Password Reset

Enable password reset flow:

```php
$panel->passwordReset();
```

## Email Verification

Require email verification:

```php
$panel->emailVerification();
```

## Configuration

```php
// config/laravilt-auth.php

return [
    'features' => [
        'login' => true,
        'register' => true,
        'password_reset' => true,
        'email_verification' => true,
    ],

    'login' => [
        'rate_limit' => 5,  // Max attempts per minute
        'lockout_duration' => 60,  // Seconds
    ],

    'password' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_symbols' => false,
    ],
];
```

## Customizing Login

### Custom Fields

```php
// app/Laravilt/Admin/Pages/Login.php

use Laravilt\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->autocomplete('email'),

            TextInput::make('password')
                ->password()
                ->required()
                ->autocomplete('current-password'),

            Toggle::make('remember')
                ->label('Remember me'),
        ];
    }
}
```

### Custom Authentication Logic

```php
protected function authenticate(array $data): void
{
    if (!Auth::attempt([
        'email' => $data['email'],
        'password' => $data['password'],
    ], $data['remember'] ?? false)) {
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}
```

## API Reference

### Panel Methods

| Method | Parameters | Description |
|--------|-----------|-------------|
| `login()` | `?string $path` | Enable login page |
| `register()` | `?string $path` | Enable registration |
| `passwordReset()` | — | Enable password reset |
| `emailVerification()` | — | Require email verification |
