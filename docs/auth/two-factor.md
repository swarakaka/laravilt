# Two-Factor Authentication

Laravilt provides comprehensive two-factor authentication (2FA) with multiple verification methods.

## Overview

Supported 2FA methods:

1. **TOTP** - Time-based One-Time Password (Google Authenticator)
2. **Email OTP** - Code sent via email
3. **SMS OTP** - Code sent via SMS
4. **Recovery Codes** - Backup codes for emergencies

## Enabling 2FA in Panel

```php
$panel
    ->twoFactorAuthentication()

    // Available methods
    ->twoFactorMethods(['totp', 'email', 'sms'])

    // Require 2FA for all users
    ->requireTwoFactorAuthentication();
```

## Configuration

```php
// config/laravilt-auth.php
'two_factor' => [
    'enabled' => true,

    // Available methods
    'methods' => ['totp', 'email', 'sms'],

    // TOTP issuer name (shown in authenticator apps)
    'issuer' => env('APP_NAME', 'Laravilt'),

    // Code length
    'code_length' => 6,

    // Code expiry for email/SMS (minutes)
    'code_expiry' => 5,

    // Recovery codes count
    'recovery_codes_count' => 8,
],
```

---

## TOTP (Time-based OTP)

Uses authenticator apps like Google Authenticator, Authy, or 1Password.

### Enable Flow

```
1. User clicks "Enable Two-Factor"
2. System generates secret + QR code
3. User scans QR code with authenticator app
4. User enters 6-digit code to confirm
5. Recovery codes displayed
6. 2FA is now active
```

### QR Code Generation

```php
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Writer;

$google2fa = new Google2FA();

// Generate secret
$secret = $google2fa->generateSecretKey();

// Generate QR code URL
$qrCodeUrl = $google2fa->getQRCodeUrl(
    config('laravilt-auth.two_factor.issuer'),
    $user->email,
    $secret
);

// Generate SVG QR code
$renderer = new ImageRenderer(/* ... */);
$writer = new Writer($renderer);
$qrCodeSvg = $writer->writeString($qrCodeUrl);
```

### Verification

```php
$google2fa = new Google2FA();

$valid = $google2fa->verifyKey(
    decrypt($user->two_factor_secret),
    $code,
    2 // window (allows 30 second drift)
);
```

---

## Email OTP

Sends verification code via email.

### Enable

```php
$panel->twoFactorMethods(['email']);
```

### Flow

```
1. User logs in with email/password
2. 2FA challenge page shown
3. 6-digit code sent to email
4. User enters code
5. Session created
```

### Code Generation

```php
$code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

Cache::put(
    "2fa.email.{$user->id}",
    Hash::make($code),
    now()->addMinutes(5)
);

// Send notification
$user->notify(new TwoFactorCodeNotification($code));
```

### Verification

```php
$cached = Cache::get("2fa.email.{$user->id}");

if ($cached && Hash::check($code, $cached)) {
    Cache::forget("2fa.email.{$user->id}");
    return true;
}

return false;
```

---

## SMS OTP

Sends verification code via SMS.

### Enable

```php
$panel->twoFactorMethods(['sms']);
```

### SMS Provider Setup

```php
// In AppServiceProvider
use Laravilt\Auth\Contracts\SMSProvider;

$this->app->bind(SMSProvider::class, function () {
    return new class implements SMSProvider {
        public function send(string $phone, string $message): bool
        {
            // Your SMS implementation
            // Twilio, Nexmo, etc.
            return true;
        }
    };
});
```

### Twilio Example

```php
use Twilio\Rest\Client;

class TwilioSMSProvider implements SMSProvider
{
    public function __construct(
        private string $sid,
        private string $token,
        private string $from
    ) {}

    public function send(string $phone, string $message): bool
    {
        $client = new Client($this->sid, $this->token);

        $client->messages->create($phone, [
            'from' => $this->from,
            'body' => $message,
        ]);

        return true;
    }
}
```

---

## Recovery Codes

Backup codes for when other 2FA methods are unavailable.

### Generation

```php
// Generate 8 recovery codes
$codes = collect(range(1, 8))->map(fn () =>
    Str::upper(Str::random(10))
)->toArray();

// Store hashed codes
$user->two_factor_recovery_codes = encrypt(
    collect($codes)->map(fn ($code) => Hash::make($code))->toJson()
);
$user->save();

// Return plaintext codes to user (one time only)
return $codes;
```

### Verification

```php
$storedCodes = json_decode(
    decrypt($user->two_factor_recovery_codes),
    true
);

foreach ($storedCodes as $index => $hashedCode) {
    if (Hash::check($submittedCode, $hashedCode)) {
        // Remove used code
        unset($storedCodes[$index]);

        $user->two_factor_recovery_codes = encrypt(
            json_encode(array_values($storedCodes))
        );
        $user->save();

        return true;
    }
}

return false;
```

### Regeneration

Users can regenerate recovery codes (requires current password):

```php
// POST /admin/profile/two-factor/recovery-codes
public function regenerate(Request $request)
{
    $request->validate(['password' => 'required|current_password']);

    $codes = $this->twoFactorService->generateRecoveryCodes($request->user());

    return response()->json(['codes' => $codes]);
}
```

---

## 2FA Challenge Flow

When a user with 2FA enabled logs in:

```
1. User enters email/password (success)
2. System checks: user.two_factor_enabled && user.two_factor_confirmed_at
3. If 2FA required:
   a. Logout user temporarily
   b. Store user ID in session
   c. Redirect to /admin/two-factor/challenge
4. Challenge page shows options:
   - Enter code (TOTP or Email/SMS)
   - Use passkey
   - Use recovery code
   - Send magic link
5. User verifies with chosen method
6. Session created
7. Redirect to panel
```

### Session Storage

```php
// Store during login
session([
    'login.id' => $user->id,
    'login.remember' => $request->boolean('remember'),
]);

// Retrieve during challenge
$userId = session('login.id');
$remember = session('login.remember', false);

// Clear after successful verification
session()->forget(['login.id', 'login.remember']);
```

---

## Database Schema

### User Columns

```php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('two_factor_enabled')->default(false);
    $table->string('two_factor_method')->nullable(); // totp, email, sms
    $table->text('two_factor_secret')->nullable(); // encrypted
    $table->text('two_factor_recovery_codes')->nullable(); // encrypted
    $table->timestamp('two_factor_confirmed_at')->nullable();
});
```

### Two-Factor Codes Table

```php
Schema::create('two_factor_codes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('phone')->nullable();
    $table->string('email')->nullable();
    $table->string('code');
    $table->timestamp('expires_at');
    $table->timestamps();
});
```

---

## Events

| Event | When Fired |
|-------|------------|
| `TwoFactorEnabled` | User enables 2FA |
| `TwoFactorDisabled` | User disables 2FA |
| `TwoFactorChallengeSuccessful` | Correct code entered |
| `TwoFactorChallengeFailed` | Invalid code entered |

### Event Listeners

```php
// In EventServiceProvider
protected $listen = [
    TwoFactorChallengeFailed::class => [
        LogFailedAttempt::class,
        NotifySecurityTeam::class,
    ],
];

// Listener example
class LogFailedAttempt
{
    public function handle(TwoFactorChallengeFailed $event)
    {
        Log::warning('2FA challenge failed', [
            'user_id' => $event->user->id,
            'method' => $event->method,
            'panel' => $event->panelId,
        ]);
    }
}
```

---

## Vue Components

### TwoFactorSection.vue

Profile section for managing 2FA:

```vue
<template>
  <Card>
    <CardHeader>
      <CardTitle>Two-Factor Authentication</CardTitle>
      <CardDescription>
        Add additional security to your account using two-factor authentication.
      </CardDescription>
    </CardHeader>

    <CardContent>
      <div v-if="enabled">
        <Badge variant="success">Enabled</Badge>
        <p>Method: {{ method }}</p>
        <Button @click="showRecoveryCodes">View Recovery Codes</Button>
        <Button variant="destructive" @click="disable">Disable</Button>
      </div>

      <div v-else>
        <Button @click="enable">Enable Two-Factor</Button>
      </div>
    </CardContent>
  </Card>
</template>
```

### ManageTwoFactorPage.vue

Full 2FA management page with:
- Method selection
- QR code display
- Secret key display
- Confirmation form
- Recovery codes display

### TwoFactorChallengePage.vue

Challenge page with:
- Code input
- Method switcher (code, passkey, magic link)
- Recovery code option
- Resend button for email/SMS

---

## API Reference

### TwoFactorService

```php
use Laravilt\Auth\Services\TwoFactorService;

// Enable 2FA
$result = $twoFactorService->enable($user, 'totp');
// Returns: ['secret' => '...', 'qr_code' => '...']

// Confirm 2FA setup
$twoFactorService->confirm($user, $code);

// Verify code
$valid = $twoFactorService->verify($user, $code);

// Disable 2FA
$twoFactorService->disable($user);

// Generate recovery codes
$codes = $twoFactorService->generateRecoveryCodes($user);

// Verify recovery code
$valid = $twoFactorService->verifyRecoveryCode($user, $code);
```

---

## Best Practices

### 1. Always Show Recovery Codes

```php
// After enabling 2FA, display recovery codes
return response()->json([
    'enabled' => true,
    'recovery_codes' => $codes,
    'message' => 'Save these codes in a safe place. You will need them if you lose access to your authenticator.',
]);
```

### 2. Rate Limit Verification

```php
RateLimiter::for('two-factor', function (Request $request) {
    return Limit::perMinute(5)->by(session('login.id'));
});
```

### 3. Log Failed Attempts

```php
Log::warning('2FA verification failed', [
    'user_id' => $user->id,
    'ip' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);
```

### 4. Notify on 2FA Changes

```php
// When 2FA is disabled
$user->notify(new TwoFactorDisabledNotification());
```

---

## Complete Example

```php
// Enable 2FA in panel
$panel
    ->twoFactorAuthentication()
    ->twoFactorMethods(['totp', 'email'])
    ->passkeys() // Allow passkeys as 2FA bypass
    ->passwordlessLogin(); // Allow magic links as 2FA bypass

// Custom 2FA enforcement
$panel->requireTwoFactorAuthentication(function ($user) {
    // Only require for admin users
    return $user->hasRole('admin');
});
```

---

## Next Steps

- [Social Authentication](social.md) - OAuth providers
- [Passkeys](passkeys.md) - Biometric authentication
- [Profile Management](profile.md) - User profile features
