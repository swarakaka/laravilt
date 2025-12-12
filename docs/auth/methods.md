# Authentication Methods

Laravilt supports multiple authentication methods that can be enabled individually or combined through panel configuration.

## Overview

Configure authentication in your panel provider (`app/Providers/Laravilt/{Panel}PanelProvider.php`):

```php
<?php

namespace App\Providers\Laravilt;

use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->path('admin')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->otp()
            ->magicLinks()
            ->passkeys()
            ->profile();
    }
}
```

---

## Email/Password Authentication

Traditional login with email and password credentials.

### Enable Login

```php
$panel->login();
```

This enables the login page at `/admin/login` with email and password fields.

### Enable Registration

```php
$panel->registration();
```

Enables user registration at `/admin/register`.

### Password Reset

```php
$panel->passwordReset();
```

Enables password reset flow with email-based reset links.

### Email Verification

```php
$panel->emailVerification();
```

Enables email verification after registration. Users receive a verification link via email.

### Login Flow

```
1. User enters email + password
2. Validate credentials
3. Check if 2FA enabled
   - If yes: redirect to 2FA challenge
   - If no: create session
4. Redirect to panel dashboard
```

---

## OTP (One-Time Password) Authentication

Authenticate users with one-time passwords sent via email or SMS.

### Enable OTP

```php
$panel->otp();
```

### How It Works

```
1. User enters email/phone
2. System generates OTP code (6 digits)
3. Code sent via email/SMS
4. User enters OTP code
5. Code verified (expires after 5 minutes)
6. Session created
```

### OTP Configuration

OTP settings are configured in `config/laravilt-auth.php`:

```php
'otp' => [
    'length' => 6,
    'expiry' => 5, // minutes
    'throttle' => 60, // seconds between requests
],
```

---

## Magic Links (Passwordless)

Email-based passwordless authentication with secure signed URLs.

### Enable Magic Links

```php
$panel->magicLinks();
```

### Magic Link Flow

```
1. User enters email address
2. System generates secure token
3. Signed URL created with 15-minute expiry
4. Email sent with magic link
5. User clicks link
6. Token verified and session created
```

### How It Works

```php
// Generate magic link
$token = Str::random(64);

Cache::put("magic-link.{$token}", [
    'user_id' => $user->id,
    'panel_id' => $panelId,
    'guard' => 'web',
], now()->addMinutes(15));

$url = URL::temporarySignedRoute(
    "{$panelId}.auth.magic-link.verify",
    now()->addMinutes(15),
    ['token' => $token]
);
```

---

## Social Authentication (OAuth)

Login with third-party OAuth providers.

### Enable Social Login

```php
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Drivers\SocialProviders\GoogleProvider;
use Laravilt\Auth\Drivers\SocialProviders\GitHubProvider;
use Laravilt\Auth\Drivers\SocialProviders\FacebookProvider;
use Laravilt\Auth\Drivers\SocialProviders\TwitterProvider;
use Laravilt\Auth\Drivers\SocialProviders\LinkedInProvider;
use Laravilt\Auth\Drivers\SocialProviders\DiscordProvider;
use Laravilt\Auth\Drivers\SocialProviders\JiraProvider;

$panel->socialLogin(function (SocialProviderBuilder $builder) {
    $builder->provider(GoogleProvider::class, function (GoogleProvider $provider) {
        $provider->enabled();
    });

    $builder->provider(GitHubProvider::class, function (GitHubProvider $provider) {
        $provider
            ->label('Sign in with GitHub')
            ->colorClasses('!bg-black !text-white')
            ->enabled();
    });

    $builder->provider(FacebookProvider::class, function (FacebookProvider $provider) {
        $provider->enabled();
    });

    $builder->provider(TwitterProvider::class, function (TwitterProvider $provider) {
        $provider->enabled();
    });

    $builder->provider(LinkedInProvider::class, function (LinkedInProvider $provider) {
        $provider->enabled();
    });

    $builder->provider(DiscordProvider::class, function (DiscordProvider $provider) {
        $provider->enabled();
    });

    $builder->provider(JiraProvider::class, function (JiraProvider $provider) {
        $provider->enabled();
    });
});
```

### Available Social Providers

| Provider | Class | Default Label |
|----------|-------|---------------|
| Google | `GoogleProvider::class` | "Sign in with Google" |
| GitHub | `GitHubProvider::class` | "Sign in with GitHub" |
| Facebook | `FacebookProvider::class` | "Sign in with Facebook" |
| Twitter | `TwitterProvider::class` | "Sign in with Twitter" |
| LinkedIn | `LinkedInProvider::class` | "Sign in with LinkedIn" |
| Discord | `DiscordProvider::class` | "Sign in with Discord" |
| Jira | `JiraProvider::class` | "Sign in with Jira" |

### Provider Configuration

Each provider can be customized:

```php
$builder->provider(GoogleProvider::class, function (GoogleProvider $provider) {
    $provider
        ->label('Custom Label')
        ->icon('CustomIcon')
        ->colorClasses('!bg-blue-600 !text-white')
        ->enabled();
});
```

### Environment Variables

Configure OAuth credentials in `.env`:

```env
# Google
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/admin/auth/google/callback

# GitHub
GITHUB_CLIENT_ID=your-client-id
GITHUB_CLIENT_SECRET=your-client-secret
GITHUB_REDIRECT_URI=https://yourdomain.com/admin/auth/github/callback

# Facebook
FACEBOOK_CLIENT_ID=your-app-id
FACEBOOK_CLIENT_SECRET=your-app-secret
FACEBOOK_REDIRECT_URI=https://yourdomain.com/admin/auth/facebook/callback
```

See [Social Authentication](social.md) for detailed OAuth setup.

---

## Two-Factor Authentication

Add extra security layer with TOTP or Email-based verification.

### Enable Two-Factor

```php
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\TotpDriver;
use Laravilt\Auth\Drivers\EmailDriver;

$panel->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
    // TOTP (Authenticator App)
    $builder->provider(TotpDriver::class);

    // Email-based 2FA
    $builder->provider(EmailDriver::class);
});
```

### Available 2FA Drivers

| Driver | Description | Setup |
|--------|-------------|-------|
| `TotpDriver` | Authenticator app (Google Authenticator, Authy) | QR code scan |
| `EmailDriver` | Email-based verification code | Automatic |

### Two-Factor Flow

```
1. User logs in with credentials
2. Primary authentication succeeds
3. 2FA challenge presented
4. User provides 2FA code
5. Code verified
6. Session created
```

See [Two-Factor Authentication](two-factor.md) for detailed configuration.

---

## Passkeys (WebAuthn)

Biometric authentication using WebAuthn standard.

### Enable Passkeys

```php
$panel->passkeys();
```

### Passkey Flow

```
1. User clicks "Sign in with passkey"
2. Browser prompts for biometric (Face ID, Touch ID, fingerprint)
3. Credential verified
4. Session created
```

Passkeys use:
- Face ID / Touch ID on Apple devices
- Windows Hello on Windows
- Fingerprint on Android
- Hardware security keys (YubiKey, etc.)

See [Passkeys](passkeys.md) for detailed WebAuthn setup.

---

## Profile Management

User profile features including password change, session management, and API tokens.

### Enable Profile

```php
$panel->profile();
```

### Profile Features

Enable individual profile features:

```php
$panel
    ->profile()
    ->sessionManagement()    // View and revoke active sessions
    ->apiTokens()           // Create/manage API tokens
    ->connectedAccounts()   // Manage linked social accounts
    ->localeTimezone();     // Set locale and timezone preferences
```

### Session Management

```php
$panel->sessionManagement();
```

Allows users to:
- View all active sessions
- See device and browser information
- Revoke access from other devices
- Logout specific sessions

### API Tokens (Sanctum)

```php
$panel->apiTokens();
```

Enable personal access token creation for API authentication.

Features:
- Create named tokens
- Configure token abilities/permissions
- Revoke tokens
- View token last used timestamp

### Connected Accounts

```php
$panel->connectedAccounts();
```

Manage linked OAuth social accounts:
- View connected social accounts
- Disconnect accounts
- Link additional accounts

### Locale & Timezone

```php
$panel->localeTimezone();
```

Allow users to set:
- Preferred language/locale
- Timezone for date/time display

See [Profile Management](profile.md) for detailed configuration.

---

## Global Search

AI-powered global search across all resources.

### Enable Global Search

```php
use Laravilt\AI\Builders\GlobalSearchBuilder;

$panel->globalSearch(function (GlobalSearchBuilder $search) {
    $search
        ->enabled()
        ->limit(5)              // Results per resource
        ->debounce(300);        // Debounce in milliseconds
});
```

### Search Configuration

```php
$search
    ->enabled(true)
    ->limit(10)
    ->debounce(500)
    ->placeholder('Search everything...')
    ->keybinding(['cmd', 'k']); // or ['ctrl', 'k']
```

---

## AI Providers

Configure AI providers for enhanced features.

### Enable AI Providers

```php
use Laravilt\AI\Builders\AIProviderBuilder;
use Laravilt\AI\Providers\OpenAIProvider;
use Laravilt\AI\Enums\OpenAIModel;

$panel->aiProviders(function (AIProviderBuilder $ai) {
    $ai->provider(OpenAIProvider::class, function (OpenAIProvider $openai) {
        $openai->model(OpenAIModel::GPT_4O_MINI);
    })->default('openai');
});
```

### Available AI Models

```php
use Laravilt\AI\Enums\OpenAIModel;

OpenAIModel::GPT_4O;           // GPT-4 Optimized
OpenAIModel::GPT_4O_MINI;      // GPT-4 Mini
OpenAIModel::GPT_4_TURBO;      // GPT-4 Turbo
OpenAIModel::GPT_3_5_TURBO;    // GPT-3.5 Turbo
```

---

## Database Notifications

Enable real-time database notifications.

### Enable Notifications

```php
$panel->databaseNotifications();
```

Features:
- Bell icon in navigation
- Unread count badge
- Notification center dropdown
- Mark as read/unread
- Notification actions

---

## Middleware Configuration

### Panel Middleware

```php
$panel->middleware(['web', 'auth']);
```

Middleware applied to all panel routes.

### Auth Middleware

```php
$panel->authMiddleware(['auth']);
```

Middleware for authenticated routes only.

### Custom Middleware

```php
$panel->middleware([
    'web',
    'auth',
    \App\Http\Middleware\CheckPanelAccess::class,
]);
```

---

## Rate Limiting

Protect authentication endpoints from brute-force attacks.

### Configuration

Configure in `config/laravilt-auth.php`:

```php
'rate_limits' => [
    'login' => [
        'max_attempts' => 5,
        'decay_minutes' => 1,
    ],
    'registration' => [
        'max_attempts' => 3,
        'decay_minutes' => 60,
    ],
    'password_reset' => [
        'max_attempts' => 3,
        'decay_minutes' => 60,
    ],
    'otp' => [
        'max_attempts' => 3,
        'decay_minutes' => 5,
    ],
],
```

### Custom Rate Limiter

```php
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->email . $request->ip());
});
```

---

## Events

Authentication events for logging and monitoring:

| Event | When Fired | Payload |
|-------|-----------|---------|
| `LoginAttempt` | Before authentication | `$email, $panelId, $ip` |
| `LoginSuccessful` | After successful login | `$user, $panelId, $remember` |
| `LoginFailed` | After failed login | `$email, $panelId, $reason` |
| `RegistrationAttempt` | Before registration | `$data, $panelId` |
| `RegistrationSuccessful` | After registration | `$user, $panelId` |
| `PasswordResetRequested` | Password reset requested | `$email, $panelId` |
| `PasswordReset` | Password changed | `$user, $panelId` |
| `EmailVerified` | Email verified | `$user, $panelId` |
| `MagicLinkSent` | Magic link sent | `$user, $url, $expiresAt` |
| `MagicLinkVerified` | Magic link used | `$user, $panelId` |
| `OtpSent` | OTP code sent | `$identifier, $channel` |
| `OtpVerified` | OTP code verified | `$user, $panelId` |

### Listening to Events

```php
// In EventServiceProvider
protected $listen = [
    \Laravilt\Auth\Events\LoginSuccessful::class => [
        \App\Listeners\LogSuccessfulLogin::class,
        \App\Listeners\NotifyAdminOfLogin::class,
    ],
    \Laravilt\Auth\Events\LoginFailed::class => [
        \App\Listeners\LogFailedLogin::class,
    ],
];
```

---

## Complete Example

```php
<?php

namespace App\Providers\Laravilt;

use Laravilt\AI\Builders\AIProviderBuilder;
use Laravilt\AI\Builders\GlobalSearchBuilder;
use Laravilt\AI\Enums\OpenAIModel;
use Laravilt\AI\Providers\OpenAIProvider;
use Laravilt\Auth\Builders\SocialProviderBuilder;
use Laravilt\Auth\Builders\TwoFactorProviderBuilder;
use Laravilt\Auth\Drivers\EmailDriver;
use Laravilt\Auth\Drivers\SocialProviders\GitHubProvider;
use Laravilt\Auth\Drivers\SocialProviders\GoogleProvider;
use Laravilt\Auth\Drivers\TotpDriver;
use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->path('admin')
            ->default()

            // Basic Authentication
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()

            // Alternative Auth Methods
            ->otp()
            ->magicLinks()
            ->passkeys()

            // Social Authentication
            ->socialLogin(function (SocialProviderBuilder $builder) {
                $builder->provider(GoogleProvider::class, function (GoogleProvider $provider) {
                    $provider->enabled();
                });

                $builder->provider(GitHubProvider::class, function (GitHubProvider $provider) {
                    $provider
                        ->label('Sign in with GitHub')
                        ->colorClasses('!bg-black !text-white')
                        ->enabled();
                });
            })

            // Two-Factor Authentication
            ->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
                $builder->provider(TotpDriver::class);
                $builder->provider(EmailDriver::class);
            })

            // Profile Features
            ->profile()
            ->sessionManagement()
            ->apiTokens()
            ->passkeys()
            ->connectedAccounts()
            ->localeTimezone()

            // AI & Search
            ->globalSearch(function (GlobalSearchBuilder $search) {
                $search
                    ->enabled()
                    ->limit(5)
                    ->debounce(300);
            })
            ->aiProviders(function (AIProviderBuilder $ai) {
                $ai->provider(OpenAIProvider::class, function (OpenAIProvider $openai) {
                    $openai->model(OpenAIModel::GPT_4O_MINI);
                })->default('openai');
            })

            // Notifications
            ->databaseNotifications()

            // Middleware
            ->middleware(['web', 'auth'])
            ->authMiddleware(['auth']);
    }
}
```

---

## Security Best Practices

### 1. Always Use HTTPS

```php
// Force HTTPS in production
if (app()->environment('production')) {
    URL::forceScheme('https');
}
```

### 2. Enable Rate Limiting

Configure aggressive rate limits for auth endpoints.

### 3. Require Email Verification

```php
$panel->emailVerification();
```

### 4. Enable Two-Factor

```php
$panel->twoFactor(builder: function (TwoFactorProviderBuilder $builder) {
    $builder->provider(TotpDriver::class);
});
```

### 5. Monitor Failed Logins

```php
// Listen to LoginFailed events
protected $listen = [
    LoginFailed::class => [
        NotifyAdminOfFailedLogin::class,
        BlockSuspiciousIP::class,
    ],
];
```

### 6. Session Security

```php
// config/session.php
'secure' => true,           // HTTPS only
'http_only' => true,        // JavaScript cannot access
'same_site' => 'lax',       // CSRF protection
```

---

## Next Steps

- [Two-Factor Authentication](two-factor.md) - Detailed 2FA setup
- [Social Authentication](social.md) - OAuth provider configuration
- [Passkeys](passkeys.md) - WebAuthn biometric authentication
- [Profile Management](profile.md) - User profile features
