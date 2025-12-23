---
title: Session Management
description: View and revoke active sessions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: auth
concept: profile
---

# Session Management

View active sessions and revoke access from other devices.

## Session Data

```php
<?php

use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;

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

## Logout Other Sessions

```php
<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
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
}
```

## Logout Specific Session

```php
<?php

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

## Related

- [Security](security) - Security best practices
- [Delete Account](delete-account) - Account deletion
