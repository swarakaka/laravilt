# Profile Management

Laravilt provides comprehensive profile management features allowing users to update their information, manage security settings, and control their account.

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
$panel
    // Enable profile page
    ->profile()

    // Individual features
    ->sessionManagement()
    ->apiTokens()
    ->passkeys()
    ->connectedAccounts()
    ->deleteAccount();
```

---

## Profile Information

### Update Profile

```php
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
```

### Profile Form Schema

```php
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

### Avatar Upload

```php
$panel->profileAvatarUpload();

// In profile form
FileUpload::make('avatar')
    ->image()
    ->avatar()
    ->directory('avatars')
    ->maxSize(1024), // 1MB
```

---

## Password Update

### Change Password

```php
// Route: PUT /admin/profile/password
public function updatePassword(Request $request)
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
```

### Password Form Schema

```php
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

---

## Session Management

View active sessions and revoke access from other devices.

### Session Data

```php
// Get user's active sessions
$sessions = DB::table('sessions')
    ->where('user_id', $user->id)
    ->get()
    ->map(function ($session) use ($request) {
        $agent = new Agent();
        $agent->setUserAgent($session->user_agent);

        return [
            'id' => $session->id,
            'ip_address' => $session->ip_address,
            'user_agent' => $session->user_agent,
            'device' => $agent->device() ?: 'Unknown',
            'platform' => $agent->platform() ?: 'Unknown',
            'browser' => $agent->browser() ?: 'Unknown',
            'is_current' => $session->id === $request->session()->getId(),
            'last_active' => Carbon::createFromTimestamp($session->last_activity),
        ];
    });
```

### Logout Other Sessions

```php
// Route: DELETE /admin/profile/sessions
public function destroyOtherSessions(Request $request)
{
    $request->validate([
        'password' => ['required', 'current_password'],
    ]);

    Auth::logoutOtherDevices($request->password);

    DB::table('sessions')
        ->where('user_id', $request->user()->id)
        ->where('id', '!=', $request->session()->getId())
        ->delete();

    return back()->with('status', 'sessions-terminated');
}
```

### Logout Specific Session

```php
// Route: DELETE /admin/profile/sessions/{id}
public function destroySession(Request $request, string $sessionId)
{
    DB::table('sessions')
        ->where('user_id', $request->user()->id)
        ->where('id', $sessionId)
        ->delete();

    return back()->with('status', 'session-terminated');
}
```

---

## API Tokens (Sanctum)

Create and manage personal access tokens for API authentication.

### Create Token

```php
// Route: POST /admin/profile/api-tokens
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'abilities' => ['array'],
        'abilities.*' => ['string'],
    ]);

    $token = $request->user()->createToken(
        $validated['name'],
        $validated['abilities'] ?? ['*']
    );

    // Flash plaintext token (shown once)
    session()->flash('token', $token->plainTextToken);

    return back();
}
```

### Token Abilities

```php
$panel->apiTokenAbilities([
    'read' => 'Read resources',
    'create' => 'Create resources',
    'update' => 'Update resources',
    'delete' => 'Delete resources',
]);
```

### Delete Token

```php
// Route: DELETE /admin/profile/api-tokens/{id}
public function destroy(Request $request, $tokenId)
{
    $request->user()->tokens()
        ->where('id', $tokenId)
        ->delete();

    return back()->with('status', 'token-deleted');
}
```

### Revoke All Tokens

```php
// Route: DELETE /admin/profile/api-tokens
public function revokeAll(Request $request)
{
    $request->validate([
        'password' => ['required', 'current_password'],
    ]);

    $request->user()->tokens()->delete();

    return back()->with('status', 'tokens-revoked');
}
```

---

## Connected Accounts

Manage OAuth social accounts.

### List Connected Accounts

```php
// Get user's social accounts
$accounts = $user->socialAccounts()
    ->get()
    ->map(fn ($account) => [
        'id' => $account->id,
        'provider' => $account->provider,
        'name' => $account->name,
        'email' => $account->email,
        'avatar' => $account->avatar,
        'connected_at' => $account->created_at,
    ]);
```

### Disconnect Account

```php
// Route: DELETE /admin/profile/connected-accounts/{id}
public function disconnect(Request $request, $accountId)
{
    // Ensure user has another login method
    $user = $request->user();

    if (!$user->password && $user->socialAccounts()->count() <= 1) {
        return back()->withErrors([
            'account' => 'Cannot disconnect your only login method.',
        ]);
    }

    $user->socialAccounts()
        ->where('id', $accountId)
        ->delete();

    return back()->with('status', 'account-disconnected');
}
```

---

## Delete Account

Permanent account deletion with confirmation.

### Delete Account Flow

```
1. User clicks "Delete Account"
2. Confirmation modal appears
3. User types "DELETE" to confirm
4. User enters password
5. Account and all data deleted
6. Redirect to homepage
```

### Implementation

```php
// Route: DELETE /admin/profile
public function destroy(Request $request)
{
    $request->validate([
        'password' => ['required', 'current_password'],
        'confirmation' => ['required', 'in:DELETE'],
    ]);

    $user = $request->user();

    // Log out all sessions
    Auth::logoutOtherDevices($request->password);

    // Delete related data
    $user->tokens()->delete();
    $user->socialAccounts()->delete();
    $user->webauthnCredentials()->delete();

    // Delete user
    $user->delete();

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('status', 'account-deleted');
}
```

---

## Vue Components

### ProfilePage.vue

```vue
<template>
  <PanelPageLayout :breadcrumbs="breadcrumbs">
    <div class="space-y-6">
      <ProfileInformationSection
        :user="user"
        :schema="profileSchema"
        :action="profileAction"
      />

      <UpdatePasswordSection
        :schema="passwordSchema"
        :action="passwordAction"
      />

      <TwoFactorSection
        v-if="features.twoFactor"
        :status="twoFactorStatus"
      />

      <SessionManagementSection
        v-if="features.sessionManagement"
        :sessions="sessions"
      />

      <ApiTokensSection
        v-if="features.apiTokens"
        :tokens="tokens"
        :abilities="tokenAbilities"
      />

      <PasskeysSection
        v-if="features.passkeys"
        :passkeys="passkeys"
      />

      <ConnectedAccountsSection
        v-if="features.connectedAccounts"
        :accounts="connectedAccounts"
        :providers="socialProviders"
      />

      <DeleteAccountSection
        v-if="features.deleteAccount"
        :schema="deleteSchema"
        :action="deleteAction"
      />
    </div>
  </PanelPageLayout>
</template>
```

### Profile Section Component Pattern

```vue
<template>
  <Card>
    <CardHeader>
      <CardTitle>{{ title }}</CardTitle>
      <CardDescription>{{ description }}</CardDescription>
    </CardHeader>

    <CardContent>
      <Form :schema="schema" :action="action" @success="onSuccess">
        <template #actions>
          <Button type="submit" :disabled="form.processing">
            Save Changes
          </Button>
        </template>
      </Form>
    </CardContent>
  </Card>
</template>
```

---

## Preferences

### Locale Setting

```php
// User can set preferred locale
TextInput::make('locale')
    ->label('Language')
    ->options([
        'en' => 'English',
        'ar' => 'العربية',
        'es' => 'Español',
    ]);

// Applied via middleware
app()->setLocale($user->locale ?? config('app.locale'));
```

### Timezone Setting

```php
// User can set timezone
Select::make('timezone')
    ->label('Timezone')
    ->options(timezone_identifiers_list())
    ->searchable();

// Applied for date formatting
Carbon::setTimezone($user->timezone ?? config('app.timezone'));
```

---

## Events

| Event | When Fired |
|-------|------------|
| `ProfileUpdated` | Profile information changed |
| `PasswordChanged` | Password updated |
| `SessionTerminated` | Other sessions logged out |
| `TokenCreated` | API token created |
| `TokenRevoked` | API token deleted |
| `AccountDeleted` | Account permanently deleted |

---

## Complete Example

```php
// AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')

        // Profile features
        ->profile()
        ->profileAvatarUpload()
        ->sessionManagement()
        ->apiTokens()
        ->apiTokenAbilities([
            'read' => 'Read resources',
            'write' => 'Create and update resources',
            'delete' => 'Delete resources',
        ])
        ->passkeys()
        ->connectedAccounts()
        ->deleteAccount()

        // Security features
        ->twoFactorAuthentication()
        ->socialAuth([
            'google' => ['label' => 'Google', 'icon' => 'Google'],
            'github' => ['label' => 'GitHub', 'icon' => 'Github'],
        ])

        // Other config...
        ->discoverResources(in: app_path('Laravilt/Admin/Resources'));
}
```

---

## Security Best Practices

### 1. Password Confirmation

Require password for sensitive actions:

```php
$request->validate([
    'password' => ['required', 'current_password'],
]);
```

### 2. Rate Limiting

Limit password attempts:

```php
RateLimiter::for('password-confirm', function (Request $request) {
    return Limit::perMinute(5)->by($request->user()->id);
});
```

### 3. Audit Logging

Log security-sensitive changes:

```php
activity()
    ->causedBy($user)
    ->performedOn($user)
    ->withProperties(['changed' => 'password'])
    ->log('Password changed');
```

### 4. Email Notifications

Notify users of security changes:

```php
$user->notify(new PasswordChangedNotification());
$user->notify(new NewSessionNotification($session));
```

---

## Next Steps

- [Authentication Methods](methods.md) - Configure login options
- [Two-Factor Authentication](two-factor.md) - Enable 2FA
- [Passkeys](passkeys.md) - Biometric authentication
- [Social Authentication](social.md) - OAuth providers
