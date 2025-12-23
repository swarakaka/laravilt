---
title: Delete Account
description: Permanent account deletion with confirmation
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
concept: profile
---

# Delete Account

Permanent account deletion with confirmation.

## Delete Account Flow

```
1. User clicks "Delete Account"
2. Confirmation modal appears
3. User types "DELETE" to confirm
4. User enters password
5. Account and all data deleted
6. Redirect to homepage
```

## Implementation

```php
<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DeleteAccountController extends Controller
{
    // Route: DELETE /admin/profile
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'confirmation' => ['required', 'in:DELETE'],
        ]);

        $user = $request->user();

        // Log out all sessions
        Auth::logoutOtherDevices($request->password);

        // Delete related data
        $user->tokens()->delete();
        $user->socialAccounts()->delete();
        $user->webauthnCredentials()->delete();

        // Delete user
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'account-deleted');
    }
}
```

## Related

- [Sessions](sessions) - Session management
- [Security](security) - Security best practices
