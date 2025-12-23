---
title: Auth Routes
description: Generated authentication routes reference
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
---

# Auth Routes

The auth package generates these routes (prefixed with panel path).

## Authentication Routes

```
GET|POST  /{panel}/login              Login page
GET|POST  /{panel}/register           Registration page
POST      /{panel}/logout             Logout
GET|POST  /{panel}/password/forgot    Forgot password
GET|POST  /{panel}/password/reset     Reset password
GET       /{panel}/email/verify/{id}  Verify email
```

## Two-Factor Routes

```
GET|POST  /{panel}/two-factor/challenge    2FA challenge
POST      /{panel}/two-factor/verify       Verify code
```

## Social Auth Routes

```
GET   /{panel}/auth/{provider}/redirect   Redirect to provider
GET   /{panel}/auth/{provider}/callback   Handle callback
```

## Profile Routes

```
GET       /{panel}/profile                     Profile page
PATCH     /{panel}/profile                     Update profile
PUT       /{panel}/profile/password            Update password
DELETE    /{panel}/profile                     Delete account
```

## Two-Factor Profile Routes

```
POST      /{panel}/profile/two-factor/enable   Enable 2FA
POST      /{panel}/profile/two-factor/confirm  Confirm 2FA
DELETE    /{panel}/profile/two-factor          Disable 2FA
POST      /{panel}/profile/two-factor/recovery Regenerate codes
```

## API Token Routes

```
GET|POST  /{panel}/profile/api-tokens          API tokens
DELETE    /{panel}/profile/api-tokens/{id}     Delete token
```

## Passkey Routes

```
GET|POST  /{panel}/profile/passkeys            Passkeys
DELETE    /{panel}/profile/passkeys/{id}       Delete passkey
```

## Session Routes

```
DELETE    /{panel}/profile/sessions/{id}       Logout session
DELETE    /{panel}/profile/sessions            Logout all
```

## Related

- [Configuration](configuration) - Auth configuration
- [Events](events) - Auth events
