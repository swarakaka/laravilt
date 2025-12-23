---
title: Security Best Practices
description: Security recommendations for profile management
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
concept: profile
---

# Security Best Practices

Security recommendations for profile management.

## Password Confirmation

Require password for sensitive actions:

```php
<?php

$request->validate([
    'password' => ['required', 'current_password'],
]);
```

## Rate Limiting

Limit password attempts:

```php
<?php

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

RateLimiter::for('password-confirm', function (Request $request) {
    return Limit::perMinute(5)->by($request->user()->id);
});
```

## Audit Logging

Log security-sensitive changes:

```php
<?php

activity()
    ->causedBy($user)
    ->performedOn($user)
    ->withProperties(['changed' => 'password'])
    ->log('Password changed');
```

## Email Notifications

Notify users of security changes:

```php
<?php

use App\Notifications\PasswordChangedNotification;
use App\Notifications\NewSessionNotification;

$user->notify(new PasswordChangedNotification());
$user->notify(new NewSessionNotification($session));
```

## Complete Example

```php
<?php

namespace App\Laravilt\Admin;

use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Panel;
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\TotpDriver;
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\GitHubProvider;

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
            ->magicLinks()
            ->profile()
            ->passkeys()
            ->connectedAccounts()
            ->sessionManagement()
            ->apiTokens()
            ->localeTimezone()
            ->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
                $builder->provider(TotpDriver::class);
            })
            ->socialLogin(function (SocialProviderBuilder $builder) {
                $builder
                    ->provider(GoogleProvider::class)
                    ->provider(GitHubProvider::class);
            });
    }
}
```

## Related

- [Sessions](sessions) - Session management
- [Delete Account](delete-account) - Account deletion
- [Two-Factor](../methods/two-factor) - 2FA setup
