---
title: Passkeys (WebAuthn)
description: Biometric authentication with fingerprint, Face ID, and security keys
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
method: passkeys
---

# Passkeys (WebAuthn)

Passwordless authentication using biometrics (fingerprint, Face ID) or hardware security keys.

## Enable in Panel

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
            ->passkeys();
    }
}
```

## Requirements

- HTTPS required (except localhost)
- Browser support for WebAuthn
- Laravel package: `laragear/webauthn`

## Installation

```bash
composer require laragear/webauthn
php artisan vendor:publish --provider="Laragear\WebAuthn\WebAuthnServiceProvider"
php artisan migrate
```

## User Model Setup

```php
use Laragear\WebAuthn\Contracts\WebAuthnAuthenticatable;
use Laragear\WebAuthn\WebAuthnAuthentication;
use Laravilt\Auth\Concerns\HasPasskeys;

class User extends Authenticatable implements WebAuthnAuthenticatable
{
    use WebAuthnAuthentication;
    use HasPasskeys;
}
```

## Configuration

```php
// config/webauthn.php

return [
    'relying_party' => [
        'name' => env('APP_NAME'),
        'id' => env('WEBAUTHN_ID', parse_url(env('APP_URL'), PHP_URL_HOST)),
    ],

    'authenticator_selection' => [
        'resident_key' => 'preferred',
        'user_verification' => 'preferred',
    ],

    'attestation_conveyance' => 'none',

    'timeout' => 60,
];
```

## Profile Integration

Enable passkey management in user profile:

```php
$panel->profile()
    ->passkeyManagement();
```

## Passkey Registration

Users can register passkeys from their profile:

```php
// Register new passkey
$user->webAuthnCredentials()->create([
    'name' => 'My MacBook',
    'credential_id' => $credentialId,
    'public_key' => $publicKey,
    // ...
]);
```

## Passwordless Login

Enable login with passkey only (no password):

```php
$panel
    ->passkeys()
    ->magicLink();
```

## Customizing Passkey Pages

### Registration

```php
// app/Laravilt/Admin/Pages/RegisterPasskey.php

use Laravilt\Auth\Pages\RegisterPasskey as BaseRegister;

class RegisterPasskey extends BaseRegister
{
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Passkey Name')
                ->placeholder('e.g., MacBook Pro, iPhone')
                ->required()
                ->maxLength(255),
        ];
    }
}
```

### Authentication

```php
// app/Laravilt/Admin/Pages/PasskeyLogin.php

use Laravilt\Auth\Pages\PasskeyLogin as BaseLogin;

class PasskeyLogin extends BaseLogin
{
    protected function getHeading(): string
    {
        return 'Sign in with Passkey';
    }

    protected function getSubheading(): string
    {
        return 'Use your fingerprint, Face ID, or security key';
    }
}
```

## Passkey Management

Users can manage their passkeys:

```php
// List passkeys
$user->webAuthnCredentials;

// Delete passkey
$user->webAuthnCredentials()->find($id)->delete();

// Rename passkey
$credential->update(['name' => 'New Name']);
```

## Security Considerations

1. **HTTPS Required** - WebAuthn only works over HTTPS (except localhost)
2. **Credential Storage** - Public keys stored in database, private keys never leave user's device
3. **User Verification** - Configure based on security requirements
4. **Attestation** - Set to 'none' for privacy, 'direct' for enterprise

## Fallback Authentication

If passkey fails, allow fallback to password:

```php
$panel
    ->passkeys()
    ->allowPasswordFallback();
```

## API Reference

### Panel Methods

| Method | Parameters | Description |
|--------|-----------|-------------|
| `passkeys()` | — | Enable passkey auth |
| `passwordlessLogin()` | — | Allow passkey-only login |
| `allowPasswordFallback()` | — | Allow password if passkey fails |

### User Methods

| Method | Parameters | Description |
|--------|-----------|-------------|
| `webAuthnCredentials()` | — | Get passkey credentials |
| `hasPasskeys()` | — | Check if has passkeys |
| `registerPasskey()` | `array $data` | Register new passkey |
| `deletePasskey()` | `string $id` | Delete passkey |
