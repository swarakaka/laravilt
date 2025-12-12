# Table Columns

Complete reference for all column types available in Laravilt Tables.

## Overview

Laravilt provides 9 column types:

- **TextColumn** - Display text with various formatting options
- **IconColumn** - Display Lucide icons with colors
- **ImageColumn** - Display images with stacking and sizing
- **ColorColumn** - Display color swatches
- **ToggleColumn** - Inline toggle switch (editable)
- **SelectColumn** - Inline dropdown (editable)
- **TextInputColumn** - Inline text input (editable)
- **CheckboxColumn** - Inline checkbox (editable)

All columns share common features like sorting, searching, visibility control, and custom formatting.

---

## TextColumn

Display text with extensive formatting options.

### Basic Usage

```php
use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')
    ->label('Full Name')
    ->searchable()
    ->sortable();
```

### Text Formatting

```php
TextColumn::make('description')
    ->limit(50)                     // Character limit
    ->wrap()                        // Allow text wrapping
    ->weight('bold')                // Font weight
    ->html();                       // Render HTML
```

### Badge Display

```php
TextColumn::make('status')
    ->badge()
    ->color(fn (string $state): string => match($state) {
        'active' => 'success',
        'pending' => 'warning',
        'inactive' => 'danger',
        default => 'secondary',
    });
```

### Copyable Text

```php
TextColumn::make('api_key')
    ->copyable()                    // Show copy button
    ->copyable('Copy API Key');     // Custom copy message
```

### Date Formatting

```php
TextColumn::make('created_at')
    ->date()                        // Y-m-d
    ->date('M d, Y');               // Custom format

TextColumn::make('updated_at')
    ->dateTime()                    // Y-m-d H:i:s
    ->dateTime('M d, Y h:i A');     // Custom format

TextColumn::make('published_at')
    ->since();                      // Relative time (2 hours ago)
```

### Currency Display

```php
TextColumn::make('price')
    ->money('USD')                  // $1,234.56
    ->money('EUR', divideBy: 100);  // Convert from cents
```

### Icon Integration

```php
TextColumn::make('status')
    ->icon('CheckCircle')
    ->iconPosition('after')         // before or after
    ->color('success');
```

### Lists

```php
TextColumn::make('tags')
    ->separator(', ')               // Array join separator
    ->listWithLineBreaks()          // One per line
    ->bulleted();                   // • Bullet points
```

### Custom Formatting

```php
TextColumn::make('name')
    ->formatStateUsing(fn (string $state): string =>
        strtoupper($state)
    );
```

### All TextColumn Options

```php
TextColumn::make('field')
    ->limit(int)                    // Character limit
    ->wrap(bool)                    // Text wrapping
    ->weight(string)                // Font weight
    ->html(bool)                    // Render HTML
    ->badge(bool)                   // Badge display
    ->copyable(bool|string)         // Copy button
    ->date(format)                  // Date formatting
    ->dateTime(format)              // DateTime formatting
    ->since(bool)                   // Relative time
    ->money(currency, divideBy)     // Currency display
    ->icon(string|Closure)          // Icon name
    ->iconPosition(string)          // before/after
    ->color(string|Closure)         // Text/badge color
    ->separator(string)             // Array separator
    ->listWithLineBreaks(bool)      // Line breaks
    ->bulleted(bool)                // Bullet points
    ->formatStateUsing(Closure);    // Custom formatting
```

---

## IconColumn

Display Lucide icons with dynamic colors and sizes.

### Basic Usage

```php
use Laravilt\Tables\Columns\IconColumn;

IconColumn::make('icon')
    ->icon(fn ($record) => $record->icon_name);
```

### Boolean Icons

```php
IconColumn::make('is_verified')
    ->boolean()                     // CheckCircle/XCircle
    ->trueIcon('CheckCircle')       // Custom true icon
    ->falseIcon('XCircle')          // Custom false icon
    ->trueColor('success')          // True color
    ->falseColor('danger');         // False color
```

### Dynamic Icons

```php
IconColumn::make('status_icon')
    ->icon(fn ($record) => match($record->status) {
        'active' => 'CheckCircle',
        'pending' => 'Clock',
        'failed' => 'XCircle',
        default => 'AlertCircle',
    })
    ->color(fn ($record) => match($record->status) {
        'active' => 'success',
        'pending' => 'warning',
        'failed' => 'danger',
        default => 'secondary',
    });
```

### Icon Sizes

```php
IconColumn::make('icon')
    ->iconSize('small')             // small, medium, large
    ->iconSize(fn ($state) =>
        $state === 'important' ? 'large' : 'medium'
    );
```

### All IconColumn Options

```php
IconColumn::make('field')
    ->icon(string|Closure)          // Icon name
    ->color(string|Closure)         // Icon color
    ->iconSize(string|Closure)      // small/medium/large
    ->boolean()                     // Boolean mode
    ->trueIcon(string)              // True icon
    ->falseIcon(string)             // False icon
    ->trueColor(string)             // True color
    ->falseColor(string)            // False color
    ->wrap(bool);                   // Wrapping
```

---

## ImageColumn

Display images with various layouts and effects.

### Basic Usage

```php
use Laravilt\Tables\Columns\ImageColumn;

ImageColumn::make('avatar')
    ->circular()
    ->imageSize('lg');
```

### Image Shapes

```php
ImageColumn::make('photo')
    ->square()                      // Square shape
    ->circular();                   // Circular/rounded
```

### Image Sizing

```php
ImageColumn::make('thumbnail')
    ->imageSize('sm')               // sm, md, lg
    ->imageWidth(100)               // Custom width (px)
    ->imageHeight(100)              // Custom height (px)
    ->columnSize('md');             // Column width
```

### Stacked Images

```php
ImageColumn::make('team_members')
    ->stacked()                     // Stack multiple images
    ->ring(2)                       // Border ring width
    ->overlap(8)                    // Overlap amount (px)
    ->limit(3)                      // Show max 3 images
    ->limitedRemainingText();       // Show "+2 more"
```

### Storage Configuration

```php
ImageColumn::make('photo')
    ->disk('public')                // Storage disk
    ->visibility('public')          // Visibility
    ->defaultImageUrl('/images/placeholder.png');  // Fallback
```

### File Existence

```php
ImageColumn::make('avatar')
    ->checkFileExistence()          // Verify file exists
    ->defaultImageUrl('/default-avatar.png');
```

### Custom Attributes

```php
ImageColumn::make('image')
    ->extraImgAttributes([
        'alt' => 'Product image',
        'loading' => 'lazy',
        'class' => 'custom-image-class',
    ]);
```

### All ImageColumn Options

```php
ImageColumn::make('field')
    ->imageWidth(int)               // Image width
    ->imageHeight(int)              // Image height
    ->imageSize(string)             // sm/md/lg
    ->columnSize(string)            // Column width
    ->square()                      // Square shape
    ->circular()                    // Circular shape
    ->stacked()                     // Stack multiple
    ->ring(int)                     // Border ring
    ->overlap(int)                  // Overlap pixels
    ->limit(int)                    // Max images
    ->limitedRemainingText(bool)    // "+N more"
    ->disk(string)                  // Storage disk
    ->visibility(string)            // public/private
    ->defaultImageUrl(string)       // Fallback URL
    ->checkFileExistence(bool)      // Check file exists
    ->extraImgAttributes(array)     // Custom attributes
    ->wrap(bool);                   // Wrapping
```

---

## ColorColumn

Display color swatches with copyable hex values.

### Basic Usage

```php
use Laravilt\Tables\Columns\ColorColumn;

ColorColumn::make('color')
    ->copyable();
```

### Multiple Colors

```php
ColorColumn::make('brand_colors')
    ->wrap()                        // Allow wrapping
    ->maxVisible(3)                 // Show max 3
    ->copyable();                   // Copy on click
```

### Copy Configuration

```php
ColorColumn::make('color')
    ->copyable()
    ->copyMessage('Color copied!')
    ->copyMessageDuration(2000);    // 2 seconds
```

### All ColorColumn Options

```php
ColorColumn::make('field')
    ->copyable(bool)                // Enable copying
    ->copyMessage(string)           // Copy message
    ->copyMessageDuration(int)      // Message duration (ms)
    ->wrap(bool)                    // Allow wrapping
    ->maxVisible(int);              // Max visible colors
```

---

## ToggleColumn

Inline toggle switch for boolean values (editable).

### Basic Usage

```php
use Laravilt\Tables\Columns\ToggleColumn;

ToggleColumn::make('is_active')
    ->label('Active');
```

### With State Update

```php
ToggleColumn::make('is_featured')
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['is_featured' => $state]);

        \Laravilt\Notifications\Notification::make()
            ->title('Status updated')
            ->success()
            ->send();
    });
```

### With Validation

```php
ToggleColumn::make('is_published')
    ->rules(['boolean'])
    ->beforeStateUpdated(function ($record, $state) {
        if (!auth()->user()->can('publish', $record)) {
            throw new \Exception('Unauthorized');
        }
    });
```

### All ToggleColumn Options

```php
ToggleColumn::make('field')
    ->beforeStateUpdated(Closure)   // Before update hook
    ->afterStateUpdated(Closure)    // After update hook
    ->rules(array);                 // Validation rules
```

---

## SelectColumn

Inline dropdown selection (editable).

### Basic Usage

```php
use Laravilt\Tables\Columns\SelectColumn;

SelectColumn::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ]);
```

### With State Update

```php
SelectColumn::make('status')
    ->options([
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ])
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['status' => $state]);
    });
```

### Searchable Options

```php
SelectColumn::make('category_id')
    ->options(Category::pluck('name', 'id'))
    ->searchable();
```

### Multiple Selection

```php
SelectColumn::make('tags')
    ->options(Tag::pluck('name', 'id'))
    ->multiple();
```

### Disabled Options

```php
SelectColumn::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ])
    ->disableOptionWhen(fn ($value, $record) =>
        $value === 'published' && !$record->is_complete
    );
```

### All SelectColumn Options

```php
SelectColumn::make('field')
    ->options(array|Closure)        // Options array
    ->native(bool)                  // Native HTML select
    ->searchable(bool)              // Searchable options
    ->multiple(bool)                // Multiple selection
    ->disableOptionWhen(Closure)    // Conditional disable
    ->selectablePlaceholder(bool)   // Placeholder option
    ->beforeStateUpdated(Closure)   // Before update hook
    ->afterStateUpdated(Closure)    // After update hook
    ->rules(array);                 // Validation rules
```

---

## TextInputColumn

Inline text input field (editable).

### Basic Usage

```php
use Laravilt\Tables\Columns\TextInputColumn;

TextInputColumn::make('notes')
    ->placeholder('Add notes...');
```

### With Validation

```php
TextInputColumn::make('quantity')
    ->type('number')
    ->rules(['required', 'integer', 'min:0'])
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['quantity' => $state]);
    });
```

### With Prefix/Suffix

```php
TextInputColumn::make('price')
    ->type('number')
    ->prefix('$')
    ->suffix('.00')
    ->prefixIcon('DollarSign')
    ->prefixIconColor('success');
```

### Input Types

```php
TextInputColumn::make('email')
    ->type('email')                 // email, text, number, tel, url
    ->rules(['email']);
```

### All TextInputColumn Options

```php
TextInputColumn::make('field')
    ->type(string)                  // Input type
    ->prefix(string)                // Prefix text
    ->suffix(string)                // Suffix text
    ->prefixIcon(string)            // Prefix icon
    ->suffixIcon(string)            // Suffix icon
    ->prefixIconColor(string)       // Prefix color
    ->suffixIconColor(string)       // Suffix color
    ->beforeStateUpdated(Closure)   // Before update hook
    ->afterStateUpdated(Closure)    // After update hook
    ->rules(array);                 // Validation rules
```

---

## CheckboxColumn

Inline checkbox (editable).

### Basic Usage

```php
use Laravilt\Tables\Columns\CheckboxColumn;

CheckboxColumn::make('agreed_to_terms')
    ->label('Terms');
```

### With State Update

```php
CheckboxColumn::make('is_verified')
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['is_verified' => $state]);
    });
```

### All CheckboxColumn Options

```php
CheckboxColumn::make('field')
    ->beforeStateUpdated(Closure)   // Before update hook
    ->afterStateUpdated(Closure)    // After update hook
    ->rules(array);                 // Validation rules
```

---

## Common Column Features

All columns inherit these features:

### Searching & Sorting

```php
TextColumn::make('name')
    ->searchable()                  // Include in search
    ->sortable();                   // Enable sorting
```

### Visibility Control

```php
TextColumn::make('email')
    ->visible(fn () => auth()->user()->isAdmin())
    ->hidden(fn () => !auth()->user()->isAdmin());
```

### Toggleable Visibility

```php
TextColumn::make('created_at')
    ->toggleable()                  // User can toggle
    ->toggleable(isToggledHiddenByDefault: true);  // Hidden by default
```

### Alignment

```php
TextColumn::make('price')
    ->alignEnd()                    // Right align
    ->alignStart()                  // Left align
    ->alignCenter()                 // Center align
    ->alignJustify();               // Justify
```

### Size

```php
TextColumn::make('description')
    ->size('sm')                    // sm, md, lg, xl
    ->grow();                       // Flex-grow
```

### Tooltips

```php
TextColumn::make('status')
    ->tooltip(fn ($record) => "Status: {$record->status}");
```

### Clickable URLs

```php
TextColumn::make('name')
    ->url(fn ($record) => route('users.show', $record))
    ->url(fn ($record) => route('users.show', $record), shouldOpenInNewTab: true);
```

### Descriptions

```php
TextColumn::make('name')
    ->description(fn ($record) => $record->email)
    ->description(fn ($record) => $record->email, position: 'above');
```

### Prefix & Suffix

```php
TextColumn::make('price')
    ->prefix('$')
    ->suffix(' USD');
```

### Custom Formatting

```php
TextColumn::make('name')
    ->formatStateUsing(fn (string $state): string =>
        ucwords(strtolower($state))
    );
```

---

## Column Width

Control column width with Tailwind classes:

```php
TextColumn::make('description')
    ->grow()                        // Take remaining space
    ->size('sm');                   // Fixed size
```

---

## Complete Example

```php
use Laravilt\Tables\Columns\ImageColumn;
use Laravilt\Tables\Columns\TextColumn;
use Laravilt\Tables\Columns\IconColumn;
use Laravilt\Tables\Columns\ToggleColumn;
use Laravilt\Tables\Columns\SelectColumn;

->columns([
    ImageColumn::make('avatar')
        ->circular()
        ->imageSize('md')
        ->label('Photo'),

    TextColumn::make('name')
        ->searchable()
        ->sortable()
        ->description(fn ($record) => $record->email)
        ->url(fn ($record) => route('users.show', $record)),

    TextColumn::make('role')
        ->badge()
        ->color(fn (string $state) => match($state) {
            'admin' => 'danger',
            'editor' => 'warning',
            default => 'secondary',
        })
        ->icon(fn (string $state) => match($state) {
            'admin' => 'Shield',
            'editor' => 'Edit',
            default => 'User',
        }),

    SelectColumn::make('status')
        ->options([
            'active' => 'Active',
            'inactive' => 'Inactive',
            'pending' => 'Pending',
        ])
        ->afterStateUpdated(fn ($record, $state) =>
            $record->update(['status' => $state])
        ),

    ToggleColumn::make('is_verified')
        ->label('Verified')
        ->afterStateUpdated(fn ($record, $state) =>
            $record->update(['is_verified' => $state])
        ),

    IconColumn::make('email_verified')
        ->boolean()
        ->trueColor('success')
        ->falseColor('danger'),

    TextColumn::make('created_at')
        ->dateTime()
        ->sortable()
        ->since()
        ->toggleable(isToggledHiddenByDefault: true),
])
```

---

## Next Steps

- [Filters](filters.md) - Filter configuration
- [Actions](actions.md) - Row and bulk actions
- [Introduction](introduction.md) - Table basics
