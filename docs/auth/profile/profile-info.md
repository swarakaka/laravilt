---
title: Profile Information
description: Update user profile information and avatar
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
concept: profile
---

# Profile Information

Update user profile information including name, email, and avatar.

## Update Profile

```php
<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    // Route: PATCH /admin/profile
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $request->user()->id],
        ]);

        $request->user()->update($validated);

        return back()->with('status', 'profile-updated');
    }
}
```

## Profile Form Schema

```php
<?php

use Laravilt\Schemas\Components\TextInput;

public function getProfileSchema(): array
{
    return [
        TextInput::make('name')
            ->required()
            ->maxLength(255),

        TextInput::make('email')
            ->email()
            ->required()
            ->unique(ignoreRecord: true),
    ];
}
```

## Avatar Upload

Enable avatar uploads in your panel:

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
            ->profile()
            ->avatar();
    }
}
```

In your profile form:

```php
<?php

use Laravilt\Schemas\Components\FileUpload;

FileUpload::make('avatar')
    ->image()
    ->avatar()
    ->directory('avatars')
    ->maxSize(1024), // 1MB
```

## Related

- [Password](password) - Change password
- [Preferences](preferences) - Locale and timezone
