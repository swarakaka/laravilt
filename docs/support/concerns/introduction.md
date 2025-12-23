---
title: Concerns
description: Reusable component traits
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: support
vue_package: "@laravilt/support"
---

# Concerns

Reusable traits for component functionality.

## Available Concerns

| Trait | Description |
|-------|-------------|
| `CanBeDisabled` | Disable component |
| `CanBeReadonly` | Make read-only |
| `CanBeRequired` | Mark required |
| `HasLabel` | Label support |
| `HasPlaceholder` | Placeholder text |
| `HasHelperText` | Helper text |
| `HasColumnSpan` | Grid column span |
| `HasVisibility` | Show/hide |
| `HasId` | ID attribute |
| `InteractsWithState` | State management |
| `EvaluatesClosures` | Closure evaluation |

## CanBeDisabled

```php
<?php

use Laravilt\Support\Concerns\CanBeDisabled;

$component->disabled();
$component->disabled(fn () => $condition);
$component->isDisabled();
$component->isEnabled();
```

## CanBeReadonly

```php
<?php

use Laravilt\Support\Concerns\CanBeReadonly;

$component->readonly();
$component->readonly(fn () => $condition);
$component->isReadonly();
```

## CanBeRequired

```php
<?php

use Laravilt\Support\Concerns\CanBeRequired;

$component->required();
$component->required(fn () => $condition);
$component->isRequired();
```

## HasLabel

```php
<?php

use Laravilt\Support\Concerns\HasLabel;

$component->label('Field Label');
$component->getLabel();
```

## HasPlaceholder

```php
<?php

use Laravilt\Support\Concerns\HasPlaceholder;

$component->placeholder('Enter value...');
$component->getPlaceholder();
```

## HasHelperText

```php
<?php

use Laravilt\Support\Concerns\HasHelperText;

$component->helperText('Help text');
$component->hint('Hint text');
$component->getHelperText();
```

## HasVisibility

```php
<?php

use Laravilt\Support\Concerns\HasVisibility;

$component->hidden();
$component->visible(fn () => $condition);
$component->isHidden();
$component->isVisible();
```

## HasColumnSpan

```php
<?php

use Laravilt\Support\Concerns\HasColumnSpan;

$component->columnSpan(2);
$component->columnSpan(['default' => 1, 'md' => 2]);
$component->columnSpanFull();
$component->columnStart(2);
$component->getColumnSpan();
$component->getColumnStart();
```

## HasId

```php
<?php

use Laravilt\Support\Concerns\HasId;

$component->id('custom-id');
$component->getId();
```

## InteractsWithState

```php
<?php

use Laravilt\Support\Concerns\InteractsWithState;

$component->state($value);
$component->default($defaultValue);
$component->getState();
$component->hasState();
```

## Related

- [Component](../component) - Base class

