# Passkeys (WebAuthn)

Passkeys provide passwordless authentication using biometrics, security keys, or device credentials. Laravilt uses the [Laragear WebAuthn](https://github.com/Laragear/WebAuthn) package for implementation.

## Overview

Passkeys allow users to:

- **Register** a device credential (fingerprint, Face ID, security key)
- **Authenticate** using biometrics instead of password
- **Bypass 2FA** using passkey verification

## Enable Passkeys in Panel

```php
$panel
    ->passkeys()

    // Allow passwordless login with passkeys
    ->passwordlessLogin();
```

## How Passkeys Work

### Registration Flow

```
1. User clicks "Register Passkey"
2. Frontend requests attestation options from server
3. Server generates challenge with user info
4. Browser prompts authenticator (Touch ID, Face ID, Security Key)
5. User authenticates with biometric
6. Authenticator creates key pair
7. Public key sent to server
8. Server stores credential
9. Passkey ready to use
```

### Authentication Flow

```
1. User chooses "Login with Passkey"
2. Frontend requests assertion options from server
3. Server generates challenge
4. Browser prompts authenticator
5. User authenticates with biometric
6. Authenticator signs challenge with private key
7. Signature sent to server
8. Server verifies with stored public key
9. User logged in
```

---

## Database Schema

```php
Schema::create('webauthn_credentials', function (Blueprint $table) {
    $table->string('id')->primary(); // Credential ID
    $table->string('authenticatable_type');
    $table->unsignedBigInteger('authenticatable_id');
    $table->string('user_id'); // WebAuthn user handle
    $table->string('alias')->nullable(); // User-provided name
    $table->unsignedInteger('counter')->nullable(); // Signature counter
    $table->string('rp_id'); // Relying Party ID (domain)
    $table->string('origin'); // Origin URL
    $table->json('transports')->nullable(); // usb, ble, nfc, internal
    $table->uuid('aaguid')->nullable(); // Authenticator model ID
    $table->text('public_key'); // Public key for verification
    $table->string('attestation_format')->default('none');
    $table->json('certificates')->nullable();
    $table->timestamp('disabled_at')->nullable();
    $table->timestamps();

    $table->index(['authenticatable_type', 'authenticatable_id']);
});
```

---

## API Endpoints

### Registration

```
GET  /admin/profile/passkeys/register-options
     Returns: PublicKeyCredentialCreationOptions

POST /admin/profile/passkeys/register
     Body: { credential: AuthenticatorAttestationResponse, alias: string }
     Returns: { success: true, passkey: { id, alias, created_at } }
```

### Authentication

```
GET  /admin/two-factor/passkey/options
     Returns: PublicKeyCredentialRequestOptions

POST /admin/two-factor/passkey/verify
     Body: { credential: AuthenticatorAssertionResponse }
     Returns: Redirect to panel
```

### Management

```
GET    /admin/profile/passkeys
       Returns: List of user's passkeys

DELETE /admin/profile/passkeys/{id}
       Deletes a passkey
```

---

## Frontend Implementation

### Registration

```typescript
// composables/usePasskeys.ts
export function usePasskeys(panelId: string) {
  const registerPasskey = async (alias: string) => {
    // 1. Get registration options from server
    const optionsResponse = await fetch(
      `/${panelId}/profile/passkeys/register-options`
    );
    const options = await optionsResponse.json();

    // 2. Convert base64 to ArrayBuffer
    options.challenge = base64urlToBuffer(options.challenge);
    options.user.id = base64urlToBuffer(options.user.id);

    if (options.excludeCredentials) {
      options.excludeCredentials = options.excludeCredentials.map((cred) => ({
        ...cred,
        id: base64urlToBuffer(cred.id),
      }));
    }

    // 3. Create credential with browser API
    const credential = await navigator.credentials.create({
      publicKey: options,
    });

    // 4. Convert credential to JSON-serializable format
    const attestation = {
      id: credential.id,
      rawId: bufferToBase64url(credential.rawId),
      type: credential.type,
      response: {
        clientDataJSON: bufferToBase64url(
          credential.response.clientDataJSON
        ),
        attestationObject: bufferToBase64url(
          credential.response.attestationObject
        ),
      },
    };

    // 5. Send to server
    await fetch(`/${panelId}/profile/passkeys/register`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ credential: attestation, alias }),
    });
  };

  return { registerPasskey };
}
```

### Authentication

```typescript
const loginWithPasskey = async () => {
  // 1. Get assertion options
  const optionsResponse = await fetch(
    `/${panelId}/two-factor/passkey/options`
  );
  const options = await optionsResponse.json();

  // 2. Convert base64 to ArrayBuffer
  options.challenge = base64urlToBuffer(options.challenge);
  options.allowCredentials = options.allowCredentials?.map((cred) => ({
    ...cred,
    id: base64urlToBuffer(cred.id),
  }));

  // 3. Get credential from authenticator
  const credential = await navigator.credentials.get({
    publicKey: options,
  });

  // 4. Convert to JSON-serializable
  const assertion = {
    id: credential.id,
    rawId: bufferToBase64url(credential.rawId),
    type: credential.type,
    response: {
      clientDataJSON: bufferToBase64url(
        credential.response.clientDataJSON
      ),
      authenticatorData: bufferToBase64url(
        credential.response.authenticatorData
      ),
      signature: bufferToBase64url(credential.response.signature),
      userHandle: credential.response.userHandle
        ? bufferToBase64url(credential.response.userHandle)
        : null,
    },
  };

  // 5. Verify on server
  await fetch(`/${panelId}/two-factor/passkey/verify`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ credential: assertion }),
  });
};
```

### Helper Functions

```typescript
function base64urlToBuffer(base64url: string): ArrayBuffer {
  const base64 = base64url.replace(/-/g, '+').replace(/_/g, '/');
  const padding = '='.repeat((4 - (base64.length % 4)) % 4);
  const binary = atob(base64 + padding);
  const buffer = new ArrayBuffer(binary.length);
  const view = new Uint8Array(buffer);
  for (let i = 0; i < binary.length; i++) {
    view[i] = binary.charCodeAt(i);
  }
  return buffer;
}

function bufferToBase64url(buffer: ArrayBuffer): string {
  const bytes = new Uint8Array(buffer);
  let binary = '';
  for (let i = 0; i < bytes.length; i++) {
    binary += String.fromCharCode(bytes[i]);
  }
  const base64 = btoa(binary);
  return base64.replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
}
```

---

## Vue Components

### ManagePasskeysPage.vue

```vue
<template>
  <Card>
    <CardHeader>
      <CardTitle>Passkeys</CardTitle>
      <CardDescription>
        Manage your passkeys for passwordless authentication.
      </CardDescription>
    </CardHeader>

    <CardContent>
      <div v-if="passkeys.length === 0" class="text-muted-foreground">
        No passkeys registered yet.
      </div>

      <div v-else class="space-y-4">
        <div
          v-for="passkey in passkeys"
          :key="passkey.id"
          class="flex items-center justify-between"
        >
          <div class="flex items-center gap-3">
            <Key class="h-5 w-5" />
            <div>
              <p class="font-medium">{{ passkey.alias || 'Unnamed Passkey' }}</p>
              <p class="text-sm text-muted-foreground">
                Added {{ formatDate(passkey.created_at) }}
              </p>
            </div>
          </div>
          <Button
            variant="ghost"
            size="sm"
            @click="deletePasskey(passkey.id)"
          >
            <Trash class="h-4 w-4" />
          </Button>
        </div>
      </div>

      <Button class="mt-4" @click="showRegisterDialog = true">
        <Plus class="me-2 h-4 w-4" />
        Register New Passkey
      </Button>
    </CardContent>
  </Card>

  <!-- Register Dialog -->
  <Dialog v-model:open="showRegisterDialog">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Register Passkey</DialogTitle>
        <DialogDescription>
          Give your passkey a name to identify it later.
        </DialogDescription>
      </DialogHeader>

      <Input
        v-model="passkeyAlias"
        placeholder="e.g., MacBook Touch ID"
      />

      <DialogFooter>
        <Button variant="outline" @click="showRegisterDialog = false">
          Cancel
        </Button>
        <Button @click="registerPasskey" :disabled="registering">
          {{ registering ? 'Registering...' : 'Register' }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
```

---

## Server-Side Implementation

### PasskeyController

```php
class PasskeyController extends Controller
{
    public function registerOptions(AttestationRequest $request)
    {
        return $request
            ->toCreate()
            ->userHandle($request->user()->id)
            ->allowCredentials($request->user()->webauthnCredentials)
            ->toArray();
    }

    public function register(AttestedRequest $request)
    {
        $credential = $request->save();

        $credential->alias = $request->input('alias');
        $credential->save();

        event(new PasskeyRegistered(
            $request->user(),
            $credential->id,
            $credential->alias,
            Panel::getCurrent()->getId()
        ));

        return response()->json([
            'success' => true,
            'passkey' => $credential->only(['id', 'alias', 'created_at']),
        ]);
    }

    public function loginOptions(AssertionRequest $request)
    {
        $userId = session('login.id');
        $user = User::findOrFail($userId);

        return $request
            ->toVerify()
            ->allowCredentials($user->webauthnCredentials)
            ->toArray();
    }

    public function login(AssertedRequest $request)
    {
        $credential = $request->login();
        $user = $credential->authenticatable;

        Auth::login($user, session('login.remember', false));

        session()->forget(['login.id', 'login.remember']);
        session(['auth.two_factor_confirmed_at' => now()]);

        return redirect()->intended(Panel::getCurrent()->getUrl());
    }

    public function destroy(Request $request, string $credentialId)
    {
        $credential = $request->user()
            ->webauthnCredentials()
            ->findOrFail($credentialId);

        $credential->delete();

        event(new PasskeyDeleted(
            $request->user(),
            $credentialId,
            Panel::getCurrent()->getId()
        ));

        return back()->with('status', 'Passkey deleted successfully.');
    }
}
```

---

## User Model Methods

```php
// In LaraviltUser trait
public function webauthnCredentials(): MorphMany
{
    return $this->morphMany(WebAuthnCredential::class, 'authenticatable');
}

public function passkeys(): MorphMany
{
    return $this->webauthnCredentials();
}

public function hasPasskeys(): bool
{
    return $this->webauthnCredentials()->exists();
}
```

---

## Events

| Event | Data |
|-------|------|
| `PasskeyRegistered` | user, credentialId, alias, panelId |
| `PasskeyDeleted` | user, credentialId, panelId |

### Event Listeners

```php
Event::listen(PasskeyRegistered::class, function ($event) {
    Log::info('Passkey registered', [
        'user_id' => $event->user->id,
        'credential_id' => $event->credentialId,
        'alias' => $event->alias,
    ]);

    // Notify user
    $event->user->notify(new PasskeyRegisteredNotification($event->alias));
});
```

---

## Configuration

### WebAuthn Config

```php
// config/webauthn.php
return [
    'relying_party' => [
        'name' => env('APP_NAME', 'Laravilt'),
        'id' => env('WEBAUTHN_RP_ID'), // Usually your domain
    ],

    'user_verification' => 'preferred', // required, preferred, discouraged

    'attachment' => null, // platform, cross-platform, null (any)

    'attestation' => 'none', // none, indirect, direct

    'timeout' => 60000, // 60 seconds
];
```

### Environment Variables

```env
WEBAUTHN_RP_ID=yourapp.com
```

---

## Browser Support

Passkeys are supported in:

- **Chrome** 67+ (Windows, macOS, Linux, Android)
- **Safari** 14+ (macOS, iOS)
- **Firefox** 60+ (Windows, macOS, Linux)
- **Edge** 18+

### Feature Detection

```javascript
const passkeySupported = window.PublicKeyCredential !== undefined;

// Check if platform authenticator available (Touch ID, Face ID)
const platformSupported = await PublicKeyCredential
  .isUserVerifyingPlatformAuthenticatorAvailable();
```

---

## Security Considerations

### 1. Signature Counter

The credential includes a counter that increments with each use. If the counter doesn't increment, the credential may have been cloned:

```php
// Laragear WebAuthn handles this automatically
// If counter mismatch detected, authentication fails
```

### 2. Credential ID Exclusion

Prevent registering the same authenticator twice:

```php
->allowCredentials($user->webauthnCredentials)
// Excludes already registered credentials
```

### 3. User Verification

Require biometric verification:

```php
// In webauthn.php config
'user_verification' => 'required',
```

---

## Complete Example

```php
// Panel configuration
$panel
    ->passkeys()
    ->passwordlessLogin()
    ->twoFactorAuthentication();

// User can now:
// 1. Register passkeys in profile
// 2. Use passkeys to bypass 2FA challenge
// 3. Use passkeys for passwordless login
```

### Login Page with Passkey Option

```vue
<template>
  <div class="space-y-4">
    <!-- Email/Password Form -->
    <form @submit="loginWithPassword">
      <Input v-model="email" type="email" placeholder="Email" />
      <Input v-model="password" type="password" placeholder="Password" />
      <Button type="submit">Sign In</Button>
    </form>

    <div class="relative">
      <div class="absolute inset-0 flex items-center">
        <span class="w-full border-t" />
      </div>
      <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-background px-2 text-muted-foreground">
          Or continue with
        </span>
      </div>
    </div>

    <!-- Passkey Button -->
    <Button
      v-if="passkeySupported"
      variant="outline"
      class="w-full"
      @click="loginWithPasskey"
    >
      <Fingerprint class="me-2 h-4 w-4" />
      Sign in with Passkey
    </Button>
  </div>
</template>
```

---

## Next Steps

- [Profile Management](profile.md) - Manage passkeys in profile
- [Two-Factor Authentication](two-factor.md) - Use passkeys as 2FA
- [Authentication Methods](methods.md) - Other auth options
