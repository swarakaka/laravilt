---
title: Password Update
description: Change user password
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
concept: profile
---

# Password Update

Allow users to change their password securely.

## Change Password

```php
<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    // Route: PUT /admin/profile/password
    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
```

## Password Form Schema

```php
<?php

use Laravilt\Schemas\Components\TextInput;

public function getPasswordSchema(): array
{
    return [
        TextInput::make('current_password')
            ->password()
            ->required()
            ->currentPassword(),

        TextInput::make('password')
            ->password()
            ->required()
            ->minLength(8)
            ->confirmed(),

        TextInput::make('password_confirmation')
            ->password()
            ->required(),
    ];
}
```

## Password Requirements

Configure password requirements in `config/laravilt-auth.php`:

```php
<?php

return [
    'password' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_symbols' => false,
    ],
];
```

## Related

- [Profile Info](profile-info) - Update profile
- [Security](security) - Security best practices
