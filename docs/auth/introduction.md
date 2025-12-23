---
title: Auth Introduction
description: Complete authentication system for Laravilt panels
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
---

# Auth Introduction

The Auth package provides a complete, modular authentication system for Laravilt panels.

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

### Profile Management

- Update profile information
- Change password
- Manage two-factor authentication
- View/revoke active sessions
- Manage API tokens
- Register/delete passkeys
- Connect/disconnect social accounts
- Delete account

## Dependencies

| Package | Purpose |
|---------|---------|
| **Laravel Fortify** | Authentication scaffolding |
| **Laravel Socialite** | OAuth authentication |
| **Laravel Sanctum** | API tokens |
| **Laragear WebAuthn** | Passkeys/WebAuthn |
| **pragmarx/google2fa** | TOTP implementation |
| **bacon/bacon-qr-code** | QR code generation |

## Related

- [Configuration](configuration) - Configure auth settings
- [User Model](user-model) - Setup user model
- [Migrations](migrations) - Database migrations
- [Routes](routes) - Generated routes
- [Events](events) - Auth events
- [Profile Management](profile/introduction) - User profile features

## Authentication Methods

- [Email & Password](methods/email-password) - Traditional login
- [Social Authentication](methods/social-auth) - OAuth providers
- [Two-Factor Authentication](methods/two-factor) - TOTP, SMS, Email OTP
- [Passkeys](methods/passkeys) - WebAuthn biometric authentication
