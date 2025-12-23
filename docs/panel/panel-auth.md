---
title: Panel Authentication
description: Configure authentication for your panel
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
---

# Panel Authentication

Configure authentication features for your panel.

## Basic Authentication

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->login()
            ->registration()
            ->passwordReset()
            ->profile();
    }
}
```

## Two-Factor Authentication

```php
use Laravilt\Panel\Panel;
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\TotpDriver;
use Laravilt\Auth\Drivers\EmailDriver;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
            $builder->provider(TotpDriver::class);
            // Or email-based 2FA
            // $builder->provider(EmailDriver::class);
        });
    }
}
```

## Social Login

```php
use Laravilt\Panel\Panel;
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Drivers\SocialProviders\GoogleProvider;
use Laravilt\Auth\Drivers\SocialProviders\GitHubProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->socialLogin(function (SocialProviderBuilder $builder) {
            $builder->provider(GoogleProvider::class, fn (GoogleProvider $p) => $p->enabled());
            $builder->provider(GitHubProvider::class, fn (GitHubProvider $p) => $p->enabled());
        });
    }
}
```

## Passkeys (WebAuthn)

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->passkeys();
    }
}
```

## Magic Links

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->magicLinks();
    }
}
```

## API Tokens

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->apiTokens();
    }
}
```

## Session Management

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->sessionManagement();
    }
}
```

## Connected Accounts

```php
use Laravilt\Panel\Panel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel->connectedAccounts();
    }
}
```

## Complete Example

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\TotpDriver;
use Laravilt\Auth\Drivers\SocialProviders\GitHubProvider;

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
            ->profile()
            ->passkeys()
            ->magicLinks()
            ->apiTokens()
            ->sessionManagement()
            ->connectedAccounts()
            ->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
                $builder->provider(TotpDriver::class);
            })
            ->socialLogin(function (SocialProviderBuilder $builder) {
                $builder->provider(GitHubProvider::class, fn (GitHubProvider $p) => $p->enabled());
            });
    }
}
```

## Next Steps

- [Creating Panels](creating-panels) - Panel basics
- [Discovery](discovery) - Auto-discovery
- [Tenancy](tenancy/overview) - Tenant authentication
