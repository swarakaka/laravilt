---
title: Auth Configuration
description: Configure authentication settings for your panel
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
---

# Auth Configuration

Configure authentication features in your panel provider and config file.

## Enabling Authentication in Panel

```php
<?php

namespace App\Laravilt\Admin;

use Laravel\Socialite\Two\GithubProvider;
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\TotpDriver;
use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')

            // Basic auth
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()

            // Two-factor authentication
            ->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
                $builder->provider(TotpDriver::class);
            })
            ->socialLogin(function (SocialProviderBuilder $builder) {
                $builder->provider(GitHubProvider::class, fn (GitHubProvider $p) => $p->enabled());
            })

            // Profile & Security features
            ->profile()
            ->passkeys()
            ->magicLinks()
            ->connectedAccounts()
            ->sessionManagement()
            ->apiTokens()
            ->localeTimezone();
    }
}
```

## Configuration File

Publish and customize `config/laravilt-auth.php`:

```php
<?php

return [
    'guard' => 'web',

    'methods' => [
        'email' => true,
        'phone' => false,
        'social' => false,
        'passwordless' => false,
        'webauthn' => false,
    ],

    'two_factor' => [
        'enabled' => false,
        'methods' => ['totp', 'email', 'sms'],
        'issuer' => env('APP_NAME', 'Laravilt'),
    ],

    'otp' => [
        'length' => 6,
        'expiry' => 5, // minutes
    ],

    'features' => [
        'registration' => true,
        'email_verification' => true,
        'password_reset' => true,
        'profile' => true,
        'sessions' => true,
        'api_tokens' => true,
    ],
];
```

## Related

- [User Model](user-model) - Setup user model
- [Migrations](migrations) - Database migrations
