---
title: Two-Factor Authentication
description: TOTP, SMS OTP, and Email OTP second factor methods
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
method: two-factor
---

# Two-Factor Authentication

Add an extra layer of security with TOTP authenticator apps, SMS, or email verification codes.

## Enable in Panel

```php
<?php

namespace App\Laravilt\Admin;

use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Panel;
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\TotpDriver;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
                $builder->provider(TotpDriver::class);
            });
    }
}
```

## Available Methods

### TOTP (Authenticator App)

Time-based One-Time Password with apps like Google Authenticator, Authy, or 1Password.

```php
use Laravilt\Auth\Drivers\TotpDriver;

->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
    $builder->provider(TotpDriver::class);
})
```

### SMS OTP

One-time password sent via SMS:

```php
use Laravilt\Auth\Drivers\SmsDriver;

->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
    $builder->provider(SmsDriver::class);
})
```

### Email OTP

One-time password sent via email:

```php
use Laravilt\Auth\Drivers\EmailDriver;

->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
    $builder->provider(EmailDriver::class);
})
```

### Multiple Methods

```php
use Laravilt\Auth\Drivers\{TotpDriver, SmsDriver, EmailDriver};

->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
    $builder
        ->provider(TotpDriver::class)
        ->provider(SmsDriver::class)
        ->provider(EmailDriver::class);
})

## User Model Setup

```php
use Laravilt\Auth\Concerns\HasTwoFactorAuth;

class User extends Authenticatable
{
    use HasTwoFactorAuth;

    protected $casts = [
        'two_factor_secret' => 'encrypted',
        'two_factor_recovery_codes' => 'encrypted:array',
        'two_factor_confirmed_at' => 'datetime',
    ];
}
```

## Migration

```php
Schema::table('users', function (Blueprint $table) {
    $table->text('two_factor_secret')->nullable();
    $table->text('two_factor_recovery_codes')->nullable();
    $table->timestamp('two_factor_confirmed_at')->nullable();
    $table->string('two_factor_method')->nullable();  // totp, sms, email
});
```

## Configuration

```php
// config/laravilt-auth.php

return [
    'two_factor' => [
        'enabled' => true,
        'methods' => ['totp', 'sms', 'email'],

        'totp' => [
            'issuer' => env('APP_NAME'),
            'digits' => 6,
            'period' => 30,
            'algorithm' => 'sha1',
        ],

        'sms' => [
            'driver' => 'twilio',  // or 'vonage', 'aws-sns'
            'code_length' => 6,
            'expires_in' => 300,  // 5 minutes
        ],

        'email' => [
            'code_length' => 6,
            'expires_in' => 600,  // 10 minutes
        ],

        'recovery_codes' => [
            'count' => 8,
            'length' => 10,
        ],
    ],
];
```

## Profile Integration

Enable 2FA management in user profile:

```php
$panel->profile()
    ->twoFactorManagement();
```

## Recovery Codes

Recovery codes are generated when 2FA is enabled. Users can:
- View recovery codes
- Regenerate recovery codes
- Use recovery code if device is lost

```php
// Generate new recovery codes
$user->generateTwoFactorRecoveryCodes();

// Validate recovery code
$user->validateTwoFactorRecoveryCode($code);
```

## Enforcing 2FA

Require 2FA for all users:

```php
->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
    $builder
        ->provider(TotpDriver::class)
        ->required();  // Force all users to enable 2FA
})
```

For specific roles:

```php
->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
    $builder
        ->provider(TotpDriver::class)
        ->requiredFor(['admin', 'super_admin']);
})

## Customizing the Challenge

```php
// app/Laravilt/Admin/Pages/TwoFactorChallenge.php

use Laravilt\Auth\Pages\TwoFactorChallenge as BaseChallenge;

class TwoFactorChallenge extends BaseChallenge
{
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('code')
                ->label('Authentication Code')
                ->placeholder('Enter 6-digit code')
                ->required()
                ->maxLength(6)
                ->autofocus(),

            Toggle::make('use_recovery')
                ->label('Use recovery code instead'),
        ];
    }
}
```

## API Reference

### Panel Methods

| Method | Parameters | Description |
|--------|-----------|-------------|
| `twoFactorAuthentication()` | `?array $methods` | Enable 2FA |
| `required()` | — | Require 2FA for all users |
| `requiredFor()` | `array $roles` | Require 2FA for roles |

### User Methods

| Method | Parameters | Description |
|--------|-----------|-------------|
| `enableTwoFactor()` | `string $method` | Enable 2FA |
| `disableTwoFactor()` | — | Disable 2FA |
| `hasTwoFactorEnabled()` | — | Check if 2FA enabled |
| `generateTwoFactorRecoveryCodes()` | — | Generate recovery codes |
| `validateTwoFactorCode()` | `string $code` | Validate TOTP code |
| `validateTwoFactorRecoveryCode()` | `string $code` | Validate recovery code |
