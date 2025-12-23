---
title: Profile Introduction
description: User profile management features
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
concept: profile
---

# Profile Management

Laravilt provides comprehensive profile management features.

## Overview

Profile features include:

- **Profile Information** - Name, email, avatar
- **Password Update** - Change password
- **Two-Factor Authentication** - Enable/disable 2FA
- **Session Management** - View and revoke sessions
- **API Tokens** - Create and manage tokens
- **Passkeys** - Register and delete passkeys
- **Connected Accounts** - Manage social logins
- **Delete Account** - Permanent account deletion

## Enable Profile Features

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
            ->magicLinks()
            ->profile()
            ->passkeys()
            ->connectedAccounts()
            ->sessionManagement()
            ->apiTokens()
            ->localeTimezone();
    }
}
```

## Related

- [Profile Info](profile-info) - Update profile information
- [Password](password) - Change password
- [Sessions](sessions) - Session management
- [API Tokens](api-tokens) - Manage API tokens
- [Connected Accounts](connected-accounts) - Social accounts
- [Delete Account](delete-account) - Account deletion
- [Preferences](preferences) - Locale and timezone
- [Security](security) - Security best practices
