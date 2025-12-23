---
title: Connected Accounts
description: Manage OAuth social account connections
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
concept: profile
---

# Connected Accounts

Manage OAuth social accounts connected to the user profile.

## List Connected Accounts

```php
<?php

// Get user's social accounts
$accounts = $user->socialAccounts()
    ->get()
    ->map(fn ($account) => [
        'id' => $account->id,
        'provider' => $account->provider,
        'name' => $account->name,
        'email' => $account->email,
        'avatar' => $account->avatar,
        'connected_at' => $account->created_at,
    ]);
```

## Disconnect Account

```php
<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConnectedAccountController extends Controller
{
    // Route: DELETE /admin/profile/connected-accounts/{id}
    public function disconnect(Request $request, $accountId)
    {
        // Ensure user has another login method
        $user = $request->user();

        if (!$user->password && $user->socialAccounts()->count() <= 1) {
            return back()->withErrors([
                'account' => 'Cannot disconnect your only login method.',
            ]);
        }

        $user->socialAccounts()
            ->where('id', $accountId)
            ->delete();

        return back()->with('status', 'account-disconnected');
    }
}
```

## Connect New Account

Users can connect additional social accounts by clicking the provider button:

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
            ->connectedAccounts()
            ->socialLogin(function (SocialProviderBuilder $builder) {
                $builder
                    ->provider(GoogleProvider::class)
                    ->provider(GitHubProvider::class)
                    ->provider(FacebookProvider::class);
            });
    }
}
```

## Related

- [Social Authentication](../methods/social-auth) - OAuth setup
- [Delete Account](delete-account) - Account deletion
