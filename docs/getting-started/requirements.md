---
title: Requirements
description: System requirements for Laravilt
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# Requirements

## Server Requirements

### PHP 8.2+

Required extensions:
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML

### Database

Choose one:
- **MySQL** 8.0+
- **PostgreSQL** 13+
- **SQLite** 3.35+

### Web Server

- Apache 2.4+ with mod_rewrite
- Nginx 1.18+
- Laravel Herd / Valet

## Development Requirements

### Node.js 18+

Required for building frontend assets:

```bash
node --version  # v18.0.0+
npm --version   # 8.0.0+
```

### Composer 2.x

```bash
composer --version  # Composer version 2.x
```

## Browser Support

Laravilt supports modern browsers:
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Recommended Setup

For development:

```bash
# Using Laravel Herd (macOS)
herd install

# Using Laravel Valet (macOS)
valet install

# Using Laravel Sail (Docker)
./vendor/bin/sail up
```

For production:

- PHP-FPM with OPcache
- Redis for cache and sessions
- Queue worker for background jobs
- SSL certificate (required for passkeys)

## Next Steps

- [Installation](installation) - Install Laravilt
- [Configuration](configuration) - Configure your setup
