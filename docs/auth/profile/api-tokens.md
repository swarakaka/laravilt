---
title: API Tokens
description: Create and manage personal access tokens
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
concept: profile
---

# API Tokens

Create and manage personal access tokens for API authentication using Sanctum.

## Create Token

```php
<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiTokenController extends Controller
{
    // Route: POST /admin/profile/api-tokens
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'abilities' => ['array'],
            'abilities.*' => ['string'],
        ]);

        $token = $request->user()->createToken(
            $validated['name'],
            $validated['abilities'] ?? ['*']
        );

        // Flash plaintext token (shown once)
        session()->flash('token', $token->plainTextToken);

        return back();
    }
}
```

## Enable API Tokens

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
            ->apiTokens();
    }
}
```

## Delete Token

```php
<?php

// Route: DELETE /admin/profile/api-tokens/{id}
public function destroy(Request $request, $tokenId)
{
    $request->user()->tokens()
        ->where('id', $tokenId)
        ->delete();

    return back()->with('status', 'token-deleted');
}
```

## Revoke All Tokens

```php
<?php

// Route: DELETE /admin/profile/api-tokens
public function revokeAll(Request $request)
{
    $request->validate([
        'password' => ['required', 'current_password'],
    ]);

    $request->user()->tokens()->delete();

    return back()->with('status', 'tokens-revoked');
}
```

## Related

- [Sessions](sessions) - Session management
- [Security](security) - Security best practices
