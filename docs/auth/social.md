# Social Authentication

Laravilt integrates with Laravel Socialite to provide OAuth authentication with popular providers.

## Supported Providers

| Provider | Config Key |
|----------|------------|
| Google | `google` |
| GitHub | `github` |
| Facebook | `facebook` |
| Twitter/X | `twitter` |
| LinkedIn | `linkedin` |
| Discord | `discord` |
| Jira/Atlassian | `jira` |

## Enable Social Auth in Panel

```php
$panel->socialAuth([
    'google' => [
        'label' => 'Google',
        'icon' => 'Google', // Lucide icon or custom SVG
    ],
    'github' => [
        'label' => 'GitHub',
        'icon' => 'Github',
    ],
    'facebook' => [
        'label' => 'Facebook',
        'icon' => 'Facebook',
    ],
]);
```

## Configuration

### Environment Variables

```env
# Google
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=https://yourapp.com/admin/auth/google/callback

# GitHub
GITHUB_CLIENT_ID=your-client-id
GITHUB_CLIENT_SECRET=your-client-secret
GITHUB_REDIRECT_URI=https://yourapp.com/admin/auth/github/callback

# Facebook
FACEBOOK_CLIENT_ID=your-client-id
FACEBOOK_CLIENT_SECRET=your-client-secret
FACEBOOK_REDIRECT_URI=https://yourapp.com/admin/auth/facebook/callback

# Discord
DISCORD_CLIENT_ID=your-client-id
DISCORD_CLIENT_SECRET=your-client-secret
DISCORD_REDIRECT_URI=https://yourapp.com/admin/auth/discord/callback

# Jira/Atlassian
ATLASSIAN_CLIENT_ID=your-client-id
ATLASSIAN_CLIENT_SECRET=your-client-secret
ATLASSIAN_REDIRECT_URI=https://yourapp.com/admin/auth/jira/callback
```

### Config File

```php
// config/laravilt-auth.php
'social' => [
    'providers' => [
        'google' => [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect' => env('GOOGLE_REDIRECT_URI'),
        ],
        'github' => [
            'client_id' => env('GITHUB_CLIENT_ID'),
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
            'redirect' => env('GITHUB_REDIRECT_URI'),
        ],
        // ... other providers
    ],
],
```

---

## OAuth Flow

### 1. Redirect to Provider

```
User clicks "Login with Google"
    ↓
GET /admin/auth/google/redirect
    ↓
Store panel context in session
    ↓
Redirect to provider OAuth page
```

### 2. Provider Callback

```
User authorizes app
    ↓
Provider redirects to callback
    ↓
GET /admin/auth/google/callback?code=xxx
    ↓
Exchange code for tokens
    ↓
Get user info from provider
    ↓
Find or create user
    ↓
Create social account record
    ↓
Check 2FA requirement
    ↓
Log user in
    ↓
Redirect to panel
```

---

## Database Schema

### Social Accounts Table

```php
Schema::create('social_accounts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('provider'); // google, github, etc.
    $table->string('provider_id'); // Provider's user ID
    $table->string('name')->nullable();
    $table->string('email')->nullable();
    $table->text('avatar')->nullable();
    $table->text('token')->nullable(); // Encrypted
    $table->text('refresh_token')->nullable(); // Encrypted
    $table->timestamp('expires_at')->nullable();
    $table->timestamps();

    $table->unique(['provider', 'provider_id']);
});
```

---

## User Creation

When a new user logs in via social auth:

```php
// Check if user exists by email
$user = User::where('email', $socialUser->getEmail())->first();

if (!$user) {
    // Create new user
    $user = User::create([
        'name' => $socialUser->getName(),
        'email' => $socialUser->getEmail(),
        'email_verified_at' => now(), // Auto-verify
        'password' => null, // No password for social users
    ]);
}

// Create/update social account
SocialAccount::updateOrCreate(
    [
        'provider' => $provider,
        'provider_id' => $socialUser->getId(),
    ],
    [
        'user_id' => $user->id,
        'name' => $socialUser->getName(),
        'email' => $socialUser->getEmail(),
        'avatar' => $socialUser->getAvatar(),
        'token' => encrypt($socialUser->token),
        'refresh_token' => encrypt($socialUser->refreshToken),
        'expires_at' => $socialUser->expiresIn
            ? now()->addSeconds($socialUser->expiresIn)
            : null,
    ]
);
```

---

## Requiring Password

Social auth users initially have no password. You can require them to set one:

```php
$panel
    ->socialAuth([...])
    ->requirePasswordAfterSocialLogin();
```

This redirects users to a "Set Password" page after their first social login.

---

## Connected Accounts Management

Users can connect multiple social accounts to their profile.

### Vue Component

```vue
<!-- ConnectedAccountsSection.vue -->
<template>
  <Card>
    <CardHeader>
      <CardTitle>Connected Accounts</CardTitle>
      <CardDescription>
        Connect your social accounts for easier login.
      </CardDescription>
    </CardHeader>

    <CardContent>
      <div v-for="account in accounts" :key="account.id" class="flex items-center gap-4">
        <Avatar>
          <AvatarImage :src="account.avatar" />
          <AvatarFallback>{{ account.name[0] }}</AvatarFallback>
        </Avatar>
        <div>
          <p class="font-medium">{{ account.provider }}</p>
          <p class="text-sm text-muted-foreground">{{ account.email }}</p>
        </div>
        <Button variant="ghost" size="sm" @click="disconnect(account)">
          Disconnect
        </Button>
      </div>

      <div v-for="provider in availableProviders" :key="provider.key">
        <Button variant="outline" @click="connect(provider)">
          Connect {{ provider.label }}
        </Button>
      </div>
    </CardContent>
  </Card>
</template>
```

### User Trait Methods

```php
// In LaraviltUser trait
public function socialAccounts(): HasMany
{
    return $this->hasMany(SocialAccount::class);
}

public function hasSocialAccount(string $provider): bool
{
    return $this->socialAccounts()
        ->where('provider', $provider)
        ->exists();
}

public function getSocialAccount(string $provider): ?SocialAccount
{
    return $this->socialAccounts()
        ->where('provider', $provider)
        ->first();
}
```

---

## Events

| Event | Data |
|-------|------|
| `SocialAuthenticationAttempt` | provider, email, providerId, panelId |
| `SocialAuthenticationSuccessful` | user, provider, providerId, isNewUser, panelId |

### Event Listeners

```php
// Log social auth attempts
Event::listen(SocialAuthenticationSuccessful::class, function ($event) {
    Log::info('Social login', [
        'user_id' => $event->user->id,
        'provider' => $event->provider,
        'new_user' => $event->isNewUser,
    ]);
});
```

---

## Provider-Specific Setup

### Google

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Add authorized redirect URI: `https://yourapp.com/admin/auth/google/callback`

### GitHub

1. Go to [GitHub Developer Settings](https://github.com/settings/developers)
2. Create new OAuth App
3. Set Authorization callback URL: `https://yourapp.com/admin/auth/github/callback`

### Facebook

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Create new app
3. Add Facebook Login product
4. Configure Valid OAuth Redirect URIs

### Discord

1. Go to [Discord Developer Portal](https://discord.com/developers/applications)
2. Create new application
3. Go to OAuth2 settings
4. Add redirect URL

### Jira/Atlassian

1. Go to [Atlassian Developer Console](https://developer.atlassian.com/console/myapps/)
2. Create new app
3. Configure OAuth 2.0 authorization
4. Add callback URL

---

## Custom Providers

Add custom OAuth providers using Socialite Providers:

```bash
composer require socialiteproviders/discord
```

```php
// In AuthServiceProvider
use SocialiteProviders\Discord\DiscordExtendSocialite;

Event::listen(
    \SocialiteProviders\Manager\SocialiteWasCalled::class,
    DiscordExtendSocialite::class . '@handle'
);
```

---

## SocialLogin Vue Component

```vue
<template>
  <div class="space-y-2">
    <template v-for="provider in providers" :key="provider.key">
      <Button
        variant="outline"
        class="w-full"
        @click="redirectToProvider(provider.key)"
      >
        <component :is="getIcon(provider.icon)" class="me-2 h-4 w-4" />
        Continue with {{ provider.label }}
      </Button>
    </template>
  </div>
</template>

<script setup lang="ts">
interface Provider {
  key: string;
  label: string;
  icon: string;
}

defineProps<{
  providers: Provider[];
  redirectUrl: string;
}>();

const redirectToProvider = (provider: string) => {
  window.location.href = redirectUrl.replace(':provider', provider);
};
</script>
```

---

## Complete Example

```php
// AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')

        // Enable social auth
        ->socialAuth([
            'google' => [
                'label' => 'Google',
                'icon' => 'Google',
            ],
            'github' => [
                'label' => 'GitHub',
                'icon' => 'Github',
            ],
            'discord' => [
                'label' => 'Discord',
                'icon' => 'MessageCircle',
            ],
        ])

        // Require password after first social login
        ->requirePasswordAfterSocialLogin()

        // Also enable regular login
        ->login()
        ->register()

        // 2FA for extra security
        ->twoFactorAuthentication()

        // Other config...
        ->discoverResources(in: app_path('Laravilt/Admin/Resources'));
}
```

---

## Security Considerations

### 1. Verify Email from Provider

```php
// Only trust verified emails from providers
if (!$socialUser->getEmail()) {
    return back()->withErrors(['email' => 'Provider did not return an email address.']);
}
```

### 2. Handle Orphaned Accounts

```php
// When user is deleted, their social accounts are also deleted
// due to cascadeOnDelete() in migration
```

### 3. Token Storage

```php
// Tokens are encrypted at rest
'token' => encrypt($socialUser->token),
'refresh_token' => encrypt($socialUser->refreshToken),
```

### 4. Prevent Account Takeover

```php
// If email already exists, verify before linking
if ($existingUser && !$existingUser->hasSocialAccount($provider)) {
    // Require email verification or password confirmation
    // before linking social account
}
```

---

## Next Steps

- [Passkeys](passkeys.md) - Biometric authentication
- [Profile Management](profile.md) - Manage connected accounts
- [Two-Factor Authentication](two-factor.md) - Additional security
