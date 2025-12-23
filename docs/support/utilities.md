---
title: Utilities
description: Helper classes for state management
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: support
vue_package: "@laravilt/support"
---

# Utilities

Helper classes for state management.

## Get Utility

Retrieve nested array values using dot notation:

```php
<?php

use Laravilt\Support\Utilities\Get;

$data = ['user' => ['name' => 'John']];
$get = new Get($data);

$name = $get('user.name');        // 'John'
$email = $get('user.email', '');  // Default value
```

Static method:

```php
<?php

use Laravilt\Support\Utilities\Get;

$value = Get::value($data, 'user.name', 'default');
```

Injected in closures:

```php
<?php

use Laravilt\Support\Utilities\Get;

TextInput::make('state')
    ->visible(fn (Get $get) => $get('country') === 'US');
```

## Set Utility

Set nested array values with change tracking:

```php
<?php

use Laravilt\Support\Utilities\Set;

$data = [];
$set = new Set($data);

$set('user.name', 'John');
$set('user.address.city', 'NYC');

if ($set->hasChanges()) {
    $allData = $set->getData();
}
```

Static method:

```php
<?php

use Laravilt\Support\Utilities\Set;

Set::value($data, 'user.name', 'John');
```

Injected in closures:

```php
<?php

use Laravilt\Support\Utilities\Set;

TextInput::make('full_name')
    ->afterStateUpdated(function (Set $set, $state) {
        $set('display_name', strtoupper($state));
    });
```

## Translator Utility

RTL/LTR language detection:

```php
<?php

use Laravilt\Support\Utilities\Translator;

Translator::isRTL('ar');        // true
Translator::isRTL('en');        // false
Translator::isRTL();            // Check current locale
Translator::direction('he');    // 'rtl'
Translator::getRTLLocales();    // ['ar', 'he', 'fa', ...]
Translator::addRTLLocale('ku'); // Add Kurdish
```

## Related

- [Component](component) - Base class
- [Concerns](concerns/introduction) - Traits

