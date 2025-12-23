---
title: Social Authentication
description: OAuth login with Google, GitHub, Facebook, and more
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
method: social-auth
---

# Social Authentication

OAuth-based authentication with social providers like Google, GitHub, and Facebook.

## Enable in Panel

```php
<?php

namespace App\Laravilt\Admin;

use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Panel;
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\GitHubProvider;
use Laravel\Socialite\Two\FacebookProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->socialLogin(function (SocialProviderBuilder $builder) {
                $builder
                    ->provider(GoogleProvider::class, fn (GoogleProvider $p) => $p->enabled())
                    ->provider(GitHubProvider::class, fn (GitHubProvider $p) => $p->enabled())
                    ->provider(FacebookProvider::class, fn (FacebookProvider $p) => $p->enabled());
            });
    }
}
```

## Supported Providers

- Google
- GitHub
- Facebook
- Twitter/X
- LinkedIn
- GitLab
- Bitbucket
- Microsoft
- Apple
- Slack

## Configuration

### Environment Variables

```env
# Google
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=https://app.com/auth/google/callback

# GitHub
GITHUB_CLIENT_ID=your-client-id
GITHUB_CLIENT_SECRET=your-client-secret
GITHUB_REDIRECT_URI=https://app.com/auth/github/callback

# Facebook
FACEBOOK_CLIENT_ID=your-app-id
FACEBOOK_CLIENT_SECRET=your-app-secret
FACEBOOK_REDIRECT_URI=https://app.com/auth/facebook/callback
```

### Config File

```php
// config/services.php

return [
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT_URI'),
    ],
];
```

## User Model Setup

Add the social login trait to your User model:

```php
use Laravilt\Auth\Concerns\HasSocialAuth;

class User extends Authenticatable
{
    use HasSocialAuth;

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
        'avatar',
    ];
}
```

## Migration

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('provider')->nullable();
    $table->string('provider_id')->nullable();
    $table->string('avatar')->nullable();
    $table->string('password')->nullable()->change();

    $table->unique(['provider', 'provider_id']);
});
```

## Customizing Providers

### Custom Icons

```php
use Laravel\Socialite\Two\GoogleProvider;

->socialLogin(function (SocialProviderBuilder $builder) {
    $builder->provider(GoogleProvider::class, fn (GoogleProvider $p) => $p
        ->enabled()
        ->label('Continue with Google')
        ->icon('custom-google-icon')
        ->color('danger')
    );
})
```

### Provider Scopes

```php
// config/laravilt-auth.php

return [
    'social' => [
        'google' => [
            'scopes' => ['email', 'profile'],
        ],
        'github' => [
            'scopes' => ['user:email', 'read:user'],
        ],
    ],
];
```

## Profile Integration

Allow users to connect/disconnect social accounts:

```php
$panel
    ->profile()
    ->connectedAccounts();  // Enable social account management
```

## Handling Callbacks

The package handles OAuth callbacks automatically. For custom logic:

```php
// app/Laravilt/Admin/Auth/SocialAuthController.php

use Laravilt\Auth\Http\Controllers\SocialAuthController as BaseController;

class SocialAuthController extends BaseController
{
    protected function handleCallback(SocialiteUser $socialUser, string $provider): User
    {
        return User::updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ],
            [
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
            ]
        );
    }
}
```

## API Reference

### Panel Methods

| Method | Parameters | Description |
|--------|-----------|-------------|
| `socialAuth()` | `array $providers` | Enable social login |

### Provider Configuration

| Key | Type | Description |
|-----|------|-------------|
| `label` | `string` | Button label |
| `icon` | `string` | Lucide icon name |
| `color` | `string` | Button color |
| `scopes` | `array` | OAuth scopes |
