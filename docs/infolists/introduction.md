# Infolists Introduction

The Infolists package provides read-only data display components for viewing record information in an organized, visually appealing format.

## Overview

Infolists are perfect for:

- **View Pages** - Display complete record details
- **Dashboards** - Show key information
- **Modals** - Quick record preview
- **Summaries** - Formatted data display

The Infolists package provides:

- **TextEntry** - Display text with formatting
- **BadgeEntry** - Display badges
- **IconEntry** - Display icons
- **ImageEntry** - Display images
- **ColorEntry** - Display color swatches
- **KeyValueEntry** - Display key-value pairs
- **RepeatableEntry** - Display arrays/collections
- **CodeEntry** - Display code with syntax highlighting

All entries support the same layout components as forms (Section, Grid, Tabs, etc.).

---

## Basic Usage

### Simple Infolist

```php
use Laravilt\Infolists\Infolist;
use Laravilt\Infolists\Entries\TextEntry;

Infolist::make()
    ->schema([
        TextEntry::make('name'),
        TextEntry::make('email'),
        TextEntry::make('created_at')->dateTime(),
    ])
    ->fill($record);
```

### Infolist with Sections

```php
use Laravilt\Schemas\Components\Section;

Infolist::make()
    ->schema([
        Section::make('User Information')
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('email'),
                TextEntry::make('phone'),
            ]),

        Section::make('Account Details')
            ->schema([
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('status')->badge(),
                TextEntry::make('role')->badge(),
            ]),
    ])
    ->fill($user);
```

---

## TextEntry

Display text with various formatting options.

### Basic Text

```php
use Laravilt\Infolists\Entries\TextEntry;

TextEntry::make('name')
    ->label('Full Name');
```

### Date Formatting

```php
TextEntry::make('created_at')
    ->date()                    // Y-m-d
    ->dateTime()                // Y-m-d H:i:s
    ->since()                   // Relative (2 hours ago)
    ->date('M d, Y');           // Custom format
```

### Currency

```php
TextEntry::make('price')
    ->money('USD')              // $1,234.56
    ->money('EUR', divideBy: 100);  // Convert from cents
```

### Badge Display

```php
TextEntry::make('status')
    ->badge()
    ->color(fn (string $state): string => match($state) {
        'active' => 'success',
        'pending' => 'warning',
        'inactive' => 'danger',
        default => 'secondary',
    });
```

### Icon Integration

```php
TextEntry::make('status')
    ->icon('CheckCircle')
    ->iconPosition('before')
    ->color('success');
```

### Copyable Text

```php
TextEntry::make('api_key')
    ->copyable()
    ->copyMessage('API key copied!');
```

### HTML Content

```php
TextEntry::make('description')
    ->html()                    // Render HTML
    ->markdown();               // Render Markdown
```

### List Formatting

```php
TextEntry::make('tags')
    ->separator(', ')           // Array join
    ->listWithLineBreaks()      // One per line
    ->bulleted();               // • Bullet points
```

### Prose Formatting

```php
TextEntry::make('content')
    ->prose()                   // Typography formatting
    ->html();
```

### Character Limit

```php
TextEntry::make('description')
    ->limit(100)                // Character limit
    ->tooltip(fn ($state) => $state);  // Show full text on hover
```

---

## BadgeEntry

Display data as styled badges.

### Basic Badge

```php
use Laravilt\Infolists\Entries\BadgeEntry;

BadgeEntry::make('status')
    ->color(fn (string $state): string => match($state) {
        'active' => 'success',
        'inactive' => 'danger',
        default => 'secondary',
    });
```

---

## IconEntry

Display Lucide icons.

### Basic Icon

```php
use Laravilt\Infolists\Entries\IconEntry;

IconEntry::make('icon')
    ->icon(fn ($record) => $record->icon_name)
    ->color('primary')
    ->size('lg');              // sm, md, lg
```

### Boolean Icons

```php
IconEntry::make('is_verified')
    ->boolean()                 // CheckCircle/XCircle
    ->trueIcon('CheckCircle')
    ->falseIcon('XCircle')
    ->trueColor('success')
    ->falseColor('danger');
```

---

## ImageEntry

Display images.

### Basic Image

```php
use Laravilt\Infolists\Entries\ImageEntry;

ImageEntry::make('avatar')
    ->circular()
    ->size('lg');
```

### Image Gallery

```php
ImageEntry::make('gallery')
    ->size('md')
    ->stacked()                 // Stack images
    ->limit(4)                  // Show max 4
    ->limitedRemainingText();   // "+2 more"
```

---

## ColorEntry

Display color swatches.

### Basic Color

```php
use Laravilt\Infolists\Entries\ColorEntry;

ColorEntry::make('brand_color')
    ->copyable();
```

### Multiple Colors

```php
ColorEntry::make('theme_colors')
    ->copyable()
    ->copyMessage('Color copied!');
```

---

## KeyValueEntry

Display key-value pairs.

### Basic Key-Value

```php
use Laravilt\Infolists\Entries\KeyValueEntry;

KeyValueEntry::make('metadata')
    ->keyLabel('Setting')
    ->valueLabel('Value');
```

---

## RepeatableEntry

Display arrays or collections.

### Basic Repeatable

```php
use Laravilt\Infolists\Entries\RepeatableEntry;

RepeatableEntry::make('addresses')
    ->schema([
        TextEntry::make('street'),
        TextEntry::make('city'),
        TextEntry::make('zip'),
    ]);
```

---

## CodeEntry

Display code with syntax highlighting.

### Basic Code

```php
use Laravilt\Infolists\Entries\CodeEntry;

CodeEntry::make('config')
    ->language('json')          // php, javascript, json, etc.
    ->lineNumbers()
    ->copyable();
```

---

## Layout Components

Infolists support all schema layout components:

### Sections

```php
Section::make('Personal Information')
    ->schema([
        TextEntry::make('name'),
        TextEntry::make('email'),
    ])
    ->columns(2);
```

### Tabs

```php
use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;

Tabs::make('tabs')
    ->tabs([
        Tab::make('details')
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('email'),
            ]),

        Tab::make('activity')
            ->schema([
                TextEntry::make('last_login')->dateTime(),
                TextEntry::make('login_count'),
            ]),
    ]);
```

### Grid

```php
use Laravilt\Schemas\Components\Grid;

Grid::make(3)
    ->schema([
        TextEntry::make('field1'),
        TextEntry::make('field2'),
        TextEntry::make('field3'),
    ]);
```

---

## Common Entry Features

### Labels

```php
TextEntry::make('email')
    ->label('Email Address');
```

### Icons

```php
TextEntry::make('status')
    ->icon('CheckCircle')
    ->iconPosition('before');
```

### Colors

```php
TextEntry::make('status')
    ->color('success');
```

### Tooltips

```php
TextEntry::make('status')
    ->tooltip('Current status');
```

### Visibility

```php
TextEntry::make('secret')
    ->visible(fn () => auth()->user()->isAdmin());
```

### Column Spanning

```php
TextEntry::make('description')
    ->columnSpanFull();
```

### Default Values

```php
TextEntry::make('optional_field')
    ->default('N/A')
    ->placeholder('Not set');
```

### URL Links

```php
TextEntry::make('website')
    ->url(fn ($state) => $state)
    ->openUrlInNewTab();
```

---

## Resource View Page

Use infolist in view pages:

```php
<?php

namespace App\Laravilt\Admin\Resources\Product\Pages;

use Laravilt\Panel\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    // Infolist automatically generated from ProductResource::infolist()
}
```

### Resource Infolist Configuration

```php
<?php

namespace App\Laravilt\Admin\Resources\Product\InfoList;

use Laravilt\Schemas\Schema;
use Laravilt\Schemas\Components\Section;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Infolists\Entries\ImageEntry;

class ProductInfoList
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Product Information')
                    ->schema([
                        ImageEntry::make('thumbnail')
                            ->circular()
                            ->size('xl'),

                        TextEntry::make('name'),
                        TextEntry::make('sku'),
                        TextEntry::make('description')
                            ->markdown()
                            ->prose(),
                    ]),

                Section::make('Pricing')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('price')
                            ->money('USD'),

                        TextEntry::make('cost')
                            ->money('USD'),

                        TextEntry::make('stock_quantity')
                            ->badge()
                            ->color(fn ($state) => match(true) {
                                $state === 0 => 'danger',
                                $state < 10 => 'warning',
                                default => 'success',
                            }),
                    ]),

                Section::make('Status')
                    ->schema([
                        TextEntry::make('status')
                            ->badge(),

                        TextEntry::make('is_active')
                            ->boolean(),

                        TextEntry::make('created_at')
                            ->dateTime(),
                    ]),
            ]);
    }
}
```

---

## Complete Example

```php
use Laravilt\Infolists\Infolist;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Components\Grid;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Infolists\Entries\ImageEntry;
use Laravilt\Infolists\Entries\BadgeEntry;
use Laravilt\Infolists\Entries\IconEntry;

Infolist::make()
    ->schema([
        Section::make('User Information')
            ->description('Basic user details')
            ->icon('User')
            ->columns(2)
            ->schema([
                ImageEntry::make('avatar')
                    ->circular()
                    ->size('xl')
                    ->columnSpan(1),

                Grid::make(1)
                    ->schema([
                        TextEntry::make('name')
                            ->size('lg')
                            ->weight('bold'),

                        TextEntry::make('email')
                            ->icon('Mail')
                            ->copyable(),

                        TextEntry::make('phone')
                            ->icon('Phone'),
                    ]),
            ]),

        Section::make('Account Status')
            ->columns(3)
            ->schema([
                BadgeEntry::make('role')
                    ->color(fn ($state) => match($state) {
                        'admin' => 'danger',
                        'editor' => 'warning',
                        default => 'secondary',
                    }),

                IconEntry::make('email_verified_at')
                    ->label('Email Verified')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextEntry::make('created_at')
                    ->label('Member Since')
                    ->since(),
            ]),

        Section::make('Activity')
            ->schema([
                TextEntry::make('last_login_at')
                    ->dateTime()
                    ->placeholder('Never logged in'),

                TextEntry::make('login_count')
                    ->badge()
                    ->color('primary'),
            ]),
    ])
    ->fill($user);
```

---

## Best Practices

### 1. Use Sections for Organization

```php
Section::make('Basic Info')->schema([...]),
Section::make('Contact')->schema([...]),
```

### 2. Provide Default Values

```php
TextEntry::make('optional')
    ->default('N/A')
    ->placeholder('Not provided');
```

### 3. Use Icons for Visual Clarity

```php
TextEntry::make('email')
    ->icon('Mail'),
TextEntry::make('phone')
    ->icon('Phone'),
```

### 4. Apply Consistent Formatting

```php
TextEntry::make('created_at')->dateTime(),
TextEntry::make('updated_at')->dateTime(),
```

### 5. Use Badges for Status

```php
TextEntry::make('status')
    ->badge()
    ->color(fn ($state) => ...);
```

---

## Next Steps

- [Schemas](../schemas/introduction.md) - Layout components
- [Forms](../forms/introduction.md) - Editable forms
