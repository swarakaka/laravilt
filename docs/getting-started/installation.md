---
title: Installation
description: Install Laravilt in your Laravel project
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Installation

Get Laravilt up and running in minutes.

## Requirements

- PHP 8.2+ with BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, XML
- Composer 2.x
- Node.js 18+ with npm/pnpm
- MySQL 8.0+, PostgreSQL 13+, or SQLite 3.35+

## Step 1: Create Laravel Project

```bash
laravel new my-project
```

Select these options:
- **Starter kit**: Vue
- **Authentication**: Laravel's built-in
- **Testing**: Pest

```bash
cd my-project
```

## Step 2: Install Laravilt

```bash
php artisan laravilt:install
```

The installer configures:
- Configuration files
- Frontend assets
- Database migrations
- Default admin panel
- Service providers

## Step 3: Run Migrations

```bash
php artisan migrate
```

## Step 4: Create Admin User

```bash
php artisan laravilt:user
```

Enter name, email, and password when prompted.

## Step 5: Build Assets

```bash
npm install && npm run build
```

## Step 6: Start Server

```bash
php artisan serve
```

Visit `http://localhost:8000/admin` and log in.

## Installation Options

```bash
# Minimal installation
php artisan laravilt:install --minimal

# With specific features
php artisan laravilt:install --two-factor --social-auth

# Custom panel path
php artisan laravilt:install --path=dashboard
```

## Next Steps

- [Interactive Installation](interactive-install) - Detailed installation prompts
- [Requirements](requirements) - Detailed system requirements
- [Configuration](configuration) - Configure your installation
- [Troubleshooting](troubleshooting) - Common issues and solutions
- [Quick Start](quick-start) - Build your first resource
