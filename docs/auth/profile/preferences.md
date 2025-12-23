---
title: User Preferences
description: Locale and timezone settings
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
concept: profile
---

# User Preferences

Configure user locale and timezone preferences.

## Locale Setting

```php
<?php

use Laravilt\Schemas\Components\Select;

// User can set preferred locale
Select::make('locale')
    ->label('Language')
    ->options([
        'en' => 'English',
        'ar' => 'العربية',
        'es' => 'Español',
        'fr' => 'Français',
        'de' => 'Deutsch',
    ]);
```

Apply locale via middleware:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if ($user = $request->user()) {
            app()->setLocale($user->locale ?? config('app.locale'));
        }

        return $next($request);
    }
}
```

## Timezone Setting

```php
<?php

use Laravilt\Schemas\Components\Select;

// User can set timezone
Select::make('timezone')
    ->label('Timezone')
    ->options(timezone_identifiers_list())
    ->searchable();
```

Apply timezone for date formatting:

```php
<?php

use Carbon\Carbon;

// In your service provider or middleware
Carbon::setTimezone($user->timezone ?? config('app.timezone'));
```

## Save Preferences

```php
<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PreferencesController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'locale' => ['nullable', 'string', 'max:5'],
            'timezone' => ['nullable', 'timezone'],
        ]);

        $request->user()->update($validated);

        return back()->with('status', 'preferences-updated');
    }
}
```

## Related

- [Profile Info](profile-info) - Update profile
- [User Model](../user-model) - User model setup
