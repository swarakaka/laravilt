# Auth Introduction

The Auth package provides a complete, modular authentication system for Laravilt panels. It supports multiple authentication methods and integrates seamlessly with Laravel Fortify, Socialite, and Sanctum.

## Overview

Laravilt Auth supports 8 authentication methods:

1. **Email/Password** - Traditional login with email and password
2. **Phone OTP** - One-time password via SMS
3. **Social Authentication** - OAuth with Google, GitHub, Facebook, etc.
4. **Passwordless** - Magic links via email
5. **Passkeys (WebAuthn)** - Biometric authentication
6. **Two-Factor Authentication** - TOTP, Email OTP, SMS OTP
7. **Recovery Codes** - Backup codes for 2FA
8. **API Tokens** - Personal access tokens via Sanctum

## Features

### Security Features

- **Password Encryption** - Bcrypt hashing
- **Encrypted Secrets** - 2FA secrets encrypted at rest
- **Hashed Recovery Codes** - Individual bcrypt hashing
- **Session Management** - View and revoke active sessions
- **Device Tracking** - IP address and user agent logging
- **Rate Limiting** - Configurable attempt limits
- **CSRF Protection** - Laravel middleware integration

### Profile Management

- Update profile information
- Change password
- Manage two-factor authentication
- View/revoke active sessions
- Manage API tokens
- Register/delete passkeys
- Connect/disconnect social accounts
- Delete account

---

## Dependencies

The Auth package relies on:

| Package | Purpose |
|---------|---------|
| **Laravel Fortify** | Authentication scaffolding |
| **Laravel Socialite** | OAuth authentication |
| **Laravel Sanctum** | API tokens |
| **Laragear WebAuthn** | Passkeys/WebAuthn |
| **pragmarx/google2fa** | TOTP implementation |
| **bacon/bacon-qr-code** | QR code generation |

---

## Configuration

### Enabling Authentication in Panel

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')

        // Basic auth
        ->login()
        ->register()
        ->passwordReset()
        ->emailVerification()

        // Two-factor authentication
        ->twoFactorAuthentication()

        // Social login
        ->socialAuth([
            'google' => ['label' => 'Google', 'icon' => 'Google'],
            'github' => ['label' => 'GitHub', 'icon' => 'Github'],
        ])

        // Passkeys
        ->passkeys()
        ->passwordlessLogin()

        // Profile features
        ->profile()
        ->sessionManagement()
        ->apiTokens();
}
```

### Configuration File

Publish and customize `config/laravilt-auth.php`:

```php
return [
    'guard' => 'web',

    'methods' => [
        'email' => true,
        'phone' => false,
        'social' => false,
        'passwordless' => false,
        'webauthn' => false,
    ],

    'two_factor' => [
        'enabled' => false,
        'methods' => ['totp', 'email', 'sms'],
        'issuer' => env('APP_NAME', 'Laravilt'),
    ],

    'otp' => [
        'length' => 6,
        'expiry' => 5, // minutes
    ],

    'features' => [
        'registration' => true,
        'email_verification' => true,
        'password_reset' => true,
        'profile' => true,
        'sessions' => true,
        'api_tokens' => true,
    ],
];
```

---

## User Model Setup

Add the `LaraviltUser` trait to your User model:

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravilt\Auth\Concerns\LaraviltUser;

class User extends Authenticatable
{
    use LaraviltUser;

    // Your model code...
}
```

The trait adds:

- **Properties**: `locale`, `timezone`, `two_factor_*` columns
- **Relationships**: `socialAccounts`, `webauthnCredentials`, `sessions`
- **Methods**: `hasTwoFactorEnabled()`, `hasPasskeys()`, `getAvatarUrl()`, etc.

---

## Database Migrations

Run the auth migrations:

```bash
php artisan vendor:publish --tag=laravilt-auth-migrations
php artisan migrate
```

### Tables Created

| Table | Purpose |
|-------|---------|
| `social_accounts` | OAuth provider connections |
| `webauthn_credentials` | Passkey registrations |
| `two_factor_codes` | Temporary 2FA codes |
| `otp_codes` | One-time passwords |
| `personal_access_tokens` | API tokens (Sanctum) |

### User Table Columns Added

```sql
ALTER TABLE users ADD (
    two_factor_enabled boolean DEFAULT false,
    two_factor_method string nullable,
    two_factor_secret text nullable,
    two_factor_recovery_codes text nullable,
    two_factor_confirmed_at timestamp nullable,
    locale string nullable,
    timezone string nullable
);
```

---

## Routes Generated

The auth package generates these routes (prefixed with panel path):

### Authentication Routes

```
GET|POST  /{panel}/login              Login page
GET|POST  /{panel}/register           Registration page
POST      /{panel}/logout             Logout
GET|POST  /{panel}/password/forgot    Forgot password
GET|POST  /{panel}/password/reset     Reset password
GET       /{panel}/email/verify/{id}  Verify email
```

### Two-Factor Routes

```
GET|POST  /{panel}/two-factor/challenge    2FA challenge
POST      /{panel}/two-factor/verify       Verify code
```

### Social Auth Routes

```
GET   /{panel}/auth/{provider}/redirect   Redirect to provider
GET   /{panel}/auth/{provider}/callback   Handle callback
```

### Profile Routes

```
GET       /{panel}/profile                     Profile page
PATCH     /{panel}/profile                     Update profile
PUT       /{panel}/profile/password            Update password
DELETE    /{panel}/profile                     Delete account

POST      /{panel}/profile/two-factor/enable   Enable 2FA
POST      /{panel}/profile/two-factor/confirm  Confirm 2FA
DELETE    /{panel}/profile/two-factor          Disable 2FA
POST      /{panel}/profile/two-factor/recovery Regenerate codes

GET|POST  /{panel}/profile/api-tokens          API tokens
DELETE    /{panel}/profile/api-tokens/{id}     Delete token

GET|POST  /{panel}/profile/passkeys            Passkeys
DELETE    /{panel}/profile/passkeys/{id}       Delete passkey

DELETE    /{panel}/profile/sessions/{id}       Logout session
DELETE    /{panel}/profile/sessions            Logout all
```

---

## Events

The auth package dispatches events for all authentication actions:

### Authentication Events

| Event | Data |
|-------|------|
| `LoginAttempt` | email, panelId |
| `LoginFailed` | email, panelId, reason |
| `LoginSuccessful` | user, panelId, remember, ip, userAgent |
| `RegistrationAttempt` | data, panelId |
| `RegistrationCompleted` | user, panelId |

### Two-Factor Events

| Event | Data |
|-------|------|
| `TwoFactorEnabled` | user, method, panelId |
| `TwoFactorDisabled` | user, panelId |
| `TwoFactorChallengeSuccessful` | user, method, panelId |
| `TwoFactorChallengeFailed` | user, method, panelId |

### Social Auth Events

| Event | Data |
|-------|------|
| `SocialAuthenticationAttempt` | provider, email, providerId, panelId |
| `SocialAuthenticationSuccessful` | user, provider, providerId, isNewUser, panelId |

### Passkey Events

| Event | Data |
|-------|------|
| `PasskeyRegistered` | user, credentialId, name, panelId |
| `PasskeyDeleted` | user, credentialId, panelId |

---

## Notifications

Built-in notifications:

| Notification | Channel | Purpose |
|--------------|---------|---------|
| `TwoFactorCode` | Email, SMS | Send 2FA code |
| `OTPNotification` | Email, SMS | Send OTP |
| `ResetPassword` | Email | Password reset link |
| `VerifyEmail` | Email | Email verification link |
| `LoginNotification` | Email | New device login alert |

---

## Next Steps

- [Authentication Methods](methods.md) - Configure login methods
- [Two-Factor Authentication](two-factor.md) - Enable 2FA
- [Social Authentication](social.md) - OAuth setup
- [Passkeys](passkeys.md) - WebAuthn integration
- [Profile Management](profile.md) - User profile features
