---
title: Interactive Installation
description: Step-by-step interactive installation guide
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Interactive Installation

Detailed walkthrough of the installation prompts.

## Laravel Installation Prompts

When running `laravel new my-project`:

```
 ┌ Would you like to install a starter kit? ─────────────────────┐
 │ › ○ None                                                      │
 │   ○ Breeze                                                    │
 │   ● Vue with Inertia (recommended for Laravilt)               │
 │   ○ React with Inertia                                        │
 │   ○ Livewire                                                  │
 └───────────────────────────────────────────────────────────────┘
```

Select **Vue with Inertia** for full Laravilt compatibility.

```
 ┌ Which authentication features would you like? ────────────────┐
 │ ◼ Email Verification                                          │
 │ ◼ Profile Management                                          │
 │ ◼ Password Reset                                              │
 └───────────────────────────────────────────────────────────────┘
```

Select all authentication features.

```
 ┌ Which testing framework do you prefer? ───────────────────────┐
 │ › ● Pest (recommended)                                        │
 │   ○ PHPUnit                                                   │
 └───────────────────────────────────────────────────────────────┘
```

## Laravilt Install Prompts

When running `php artisan laravilt:install`:

```
 ┌ Panel Configuration ──────────────────────────────────────────┐
 │ Panel ID: admin                                               │
 │ Panel Path: admin                                             │
 │ Panel Name: Admin Panel                                       │
 └───────────────────────────────────────────────────────────────┘
```

```
 ┌ Select features to install ───────────────────────────────────┐
 │ ◼ Two-Factor Authentication                                   │
 │ ◼ Social Authentication                                       │
 │ ◼ Passkeys                                                    │
 │ ◼ API Tokens                                                  │
 │ ◼ Session Management                                          │
 └───────────────────────────────────────────────────────────────┘
```

```
 ┌ Database Configuration ───────────────────────────────────────┐
 │ Run migrations now? [yes/no]: yes                             │
 │ Seed database with sample data? [yes/no]: no                  │
 └───────────────────────────────────────────────────────────────┘
```

## User Creation Prompts

When running `php artisan laravilt:user`:

```
 ┌ Create Admin User ────────────────────────────────────────────┐
 │ Name: John Doe                                                │
 │ Email: admin@example.com                                      │
 │ Password: ********                                            │
 │ Confirm Password: ********                                    │
 └───────────────────────────────────────────────────────────────┘

 ✓ Admin user created successfully!
```

## Post-Installation Structure

After installation completes:

```
app/
├── Laravilt/
│   └── Admin/
│       ├── AdminPanelProvider.php
│       ├── Pages/
│       │   └── Dashboard.php
│       └── Resources/
│           └── UserResource/
│               ├── UserResource.php
│               ├── Form/UserForm.php
│               ├── Table/UserTable.php
│               └── Pages/
│                   ├── ListUser.php
│                   ├── CreateUser.php
│                   └── EditUser.php
├── Models/
│   └── User.php
└── Providers/
    └── LaraviltServiceProvider.php

config/
├── laravilt.php
├── laravilt-panel.php
└── laravilt-auth.php

resources/
├── js/
│   └── laravilt/
│       ├── app.ts
│       └── components/
└── css/
    └── laravilt.css
```

## Next Steps

- [Configuration](configuration) - Configure your panel
- [Quick Start](quick-start) - Build your first resource
- [Troubleshooting](troubleshooting) - Common issues
