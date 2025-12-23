---
title: Auth Events
description: Events dispatched during authentication
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
---

# Auth Events

The auth package dispatches events for all authentication actions.

## Authentication Events

| Event | Data |
|-------|------|
| `LoginAttempt` | email, panelId |
| `LoginFailed` | email, panelId, reason |
| `LoginSuccessful` | user, panelId, remember, ip, userAgent |
| `RegistrationAttempt` | data, panelId |
| `RegistrationCompleted` | user, panelId |

## Two-Factor Events

| Event | Data |
|-------|------|
| `TwoFactorEnabled` | user, method, panelId |
| `TwoFactorDisabled` | user, panelId |
| `TwoFactorChallengeSuccessful` | user, method, panelId |
| `TwoFactorChallengeFailed` | user, method, panelId |

## Social Auth Events

| Event | Data |
|-------|------|
| `SocialAuthenticationAttempt` | provider, email, providerId, panelId |
| `SocialAuthenticationSuccessful` | user, provider, providerId, isNewUser, panelId |

## Passkey Events

| Event | Data |
|-------|------|
| `PasskeyRegistered` | user, credentialId, name, panelId |
| `PasskeyDeleted` | user, credentialId, panelId |

## Profile Events

| Event | When Fired |
|-------|------------|
| `ProfileUpdated` | Profile information changed |
| `PasswordChanged` | Password updated |
| `SessionTerminated` | Other sessions logged out |
| `TokenCreated` | API token created |
| `TokenRevoked` | API token deleted |
| `AccountDeleted` | Account permanently deleted |

## Notifications

Built-in notifications:

| Notification | Channel | Purpose |
|--------------|---------|---------|
| `TwoFactorCode` | Email, SMS | Send 2FA code |
| `OTPNotification` | Email, SMS | Send OTP |
| `ResetPassword` | Email | Password reset link |
| `VerifyEmail` | Email | Email verification link |
| `LoginNotification` | Email | New device login alert |

## Listening to Events

```php
<?php

namespace App\Listeners;

use Laravilt\Auth\Events\LoginSuccessful;

class LogSuccessfulLogin
{
    public function handle(LoginSuccessful $event): void
    {
        activity()
            ->causedBy($event->user)
            ->withProperties([
                'ip' => $event->ip,
                'user_agent' => $event->userAgent,
            ])
            ->log('User logged in');
    }
}
```

## Related

- [Routes](routes) - Auth routes
- [Configuration](configuration) - Auth configuration
