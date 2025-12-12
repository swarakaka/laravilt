# Table Actions

Complete reference for row actions and bulk actions in Laravilt Tables.

## Overview

Laravilt Tables support multiple action types:

- **Row Actions** - Actions for individual records (View, Edit, Delete)
- **Bulk Actions** - Actions for multiple selected records
- **Header Actions** - Actions in table header
- **Toolbar Actions** - Custom toolbar buttons
- **Inline Actions** - Editable columns (Toggle, Select, TextInput)

Actions integrate with the **Actions package** for consistent behavior across the application.

---

## Row Actions

Actions that operate on individual table records.

### Built-in Actions

```php
use Laravilt\Actions\ViewAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;

->actions([
    ViewAction::make(),
    EditAction::make(),
    DeleteAction::make(),
])
```

### Custom Row Action

```php
use Laravilt\Actions\Action;

->actions([
    Action::make('publish')
        ->label('Publish')
        ->icon('Send')
        ->color('success')
        ->action(function ($record) {
            $record->update(['status' => 'published']);

            \Laravilt\Notifications\Notification::make()
                ->title('Post published')
                ->success()
                ->send();
        }),
])
```

### Action with Confirmation

```php
Action::make('archive')
    ->label('Archive')
    ->icon('Archive')
    ->color('warning')
    ->requiresConfirmation()
    ->modalHeading('Archive Post')
    ->modalDescription('Are you sure you want to archive this post?')
    ->modalSubmitActionLabel('Archive')
    ->action(fn ($record) => $record->archive());
```

### Conditional Visibility

```php
Action::make('restore')
    ->visible(fn ($record) => $record->trashed())
    ->action(fn ($record) => $record->restore());

Action::make('approve')
    ->hidden(fn ($record) => $record->status === 'approved')
    ->action(fn ($record) => $record->approve());
```

### Action with Form

```php
Action::make('changeStatus')
    ->form([
        Select::make('status')
            ->label('New Status')
            ->options([
                'draft' => 'Draft',
                'published' => 'Published',
                'archived' => 'Archived',
            ])
            ->required(),

        Textarea::make('reason')
            ->label('Reason for change')
            ->rows(3),
    ])
    ->action(function ($record, array $data) {
        $record->update([
            'status' => $data['status'],
            'status_change_reason' => $data['reason'],
        ]);
    });
```

### Action Groups

```php
use Laravilt\Actions\ActionGroup;

->actions([
    ActionGroup::make([
        ViewAction::make(),
        EditAction::make(),

        Action::make('duplicate')
            ->icon('Copy')
            ->action(fn ($record) => $record->duplicate()),

        Action::make('export')
            ->icon('Download')
            ->action(fn ($record) => $this->exportRecord($record)),
    ])->label('More Actions'),

    DeleteAction::make(),
])
```

### URL Actions

```php
Action::make('view')
    ->url(fn ($record) => route('products.show', $record))
    ->openUrlInNewTab();

Action::make('edit')
    ->url(fn ($record) => route('products.edit', $record));
```

---

## Bulk Actions

Actions that operate on multiple selected records.

### Built-in Bulk Actions

```php
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\RestoreBulkAction;
use Laravilt\Actions\ForceDeleteBulkAction;

->bulkActions([
    DeleteBulkAction::make(),
    RestoreBulkAction::make(),
    ForceDeleteBulkAction::make(),
])
```

### Custom Bulk Action

```php
use Laravilt\Actions\BulkAction;

->bulkActions([
    BulkAction::make('activate')
        ->label('Activate Selected')
        ->icon('CheckCircle')
        ->color('success')
        ->action(function ($records) {
            $records->each->activate();

            \Laravilt\Notifications\Notification::make()
                ->title("{$records->count()} records activated")
                ->success()
                ->send();
        }),
])
```

### Bulk Action with Confirmation

```php
BulkAction::make('archive')
    ->label('Archive Selected')
    ->icon('Archive')
    ->color('warning')
    ->requiresConfirmation()
    ->modalHeading('Archive Records')
    ->modalDescription(fn ($records) =>
        "Are you sure you want to archive {$records->count()} records?"
    )
    ->action(fn ($records) => $records->each->archive());
```

### Bulk Action with Form

```php
BulkAction::make('assignCategory')
    ->label('Assign Category')
    ->icon('Tag')
    ->form([
        Select::make('category_id')
            ->label('Category')
            ->options(Category::pluck('name', 'id'))
            ->required(),
    ])
    ->action(function ($records, array $data) {
        $records->each->update([
            'category_id' => $data['category_id'],
        ]);
    });
```

### Bulk Action Groups

```php
use Laravilt\Actions\BulkActionGroup;

->bulkActions([
    BulkActionGroup::make([
        BulkAction::make('publish')->action(...),
        BulkAction::make('draft')->action(...),
        BulkAction::make('archive')->action(...),
    ])->label('Change Status'),

    DeleteBulkAction::make(),
])
```

---

## Header Actions

Actions displayed in the table header.

### Create Action

```php
use Laravilt\Actions\CreateAction;

->headerActions([
    CreateAction::make()
        ->url(route('products.create')),
])
```

### Custom Header Action

```php
->headerActions([
    Action::make('export')
        ->label('Export All')
        ->icon('Download')
        ->color('secondary')
        ->action(function () {
            return response()->download(
                $this->exportTable(),
                'products.csv'
            );
        }),

    Action::make('import')
        ->label('Import')
        ->icon('Upload')
        ->form([
            FileUpload::make('file')
                ->acceptedFileTypes(['.csv', '.xlsx'])
                ->required(),
        ])
        ->action(function (array $data) {
            $this->importFile($data['file']);
        }),
])
```

---

## Action Positioning

### Fixed Actions Column

Keep actions column visible while scrolling:

```php
$table->fixedActions();
```

### Actions Position

```php
// Default: right side
->actions([...])

// Or specify position in card view
->card(
    Card::make()
        ->actionsPosition('bottom')  // top, bottom, overlay
)
```

---

## Action Hooks

### Before Action

```php
Action::make('delete')
    ->before(function ($record) {
        // Log before deletion
        activity()
            ->performedOn($record)
            ->log('Attempting to delete');
    })
    ->action(fn ($record) => $record->delete());
```

### After Action

```php
Action::make('publish')
    ->action(fn ($record) => $record->publish())
    ->after(function ($record) {
        // Send notification after publishing
        $record->author->notify(new PostPublished($record));
    });
```

### Success Notification

```php
Action::make('activate')
    ->action(fn ($record) => $record->activate())
    ->successNotificationTitle('Record activated')
    ->successNotification(
        \Laravilt\Notifications\Notification::make()
            ->title('Successfully activated')
            ->body('The record has been activated.')
            ->success()
    );
```

### Failure Notification

```php
Action::make('process')
    ->action(function ($record) {
        if (!$record->canBeProcessed()) {
            throw new \Exception('Record cannot be processed');
        }
        $record->process();
    })
    ->failureNotificationTitle('Processing failed')
    ->failureNotification(
        \Laravilt\Notifications\Notification::make()
            ->title('Failed to process')
            ->danger()
    );
```

---

## Authorization

### Can Method

```php
EditAction::make()
    ->can(fn ($record) => auth()->user()->can('update', $record));

DeleteAction::make()
    ->can(fn ($record) => auth()->user()->can('delete', $record));
```

### Authorize Using

```php
Action::make('publish')
    ->authorize('publish', $record)
    ->action(fn ($record) => $record->publish());
```

---

## Action State

### Disabled Actions

```php
Action::make('edit')
    ->disabled(fn ($record) => $record->is_locked)
    ->disabledTooltip('This record is locked');
```

---

## Complete Examples

### Full Row Actions Example

```php
->actions([
    ViewAction::make(),

    EditAction::make()
        ->can(fn ($record) => auth()->user()->can('update', $record)),

    Action::make('publish')
        ->icon('Send')
        ->color('success')
        ->visible(fn ($record) => $record->status === 'draft')
        ->requiresConfirmation()
        ->action(fn ($record) => $record->publish())
        ->successNotificationTitle('Published successfully'),

    Action::make('archive')
        ->icon('Archive')
        ->color('warning')
        ->visible(fn ($record) => $record->status === 'published')
        ->requiresConfirmation()
        ->modalHeading('Archive this post?')
        ->action(fn ($record) => $record->archive()),

    ActionGroup::make([
        Action::make('duplicate')
            ->icon('Copy')
            ->action(fn ($record) => $record->replicate()->save()),

        Action::make('export')
            ->icon('Download')
            ->action(fn ($record) => $this->export($record)),

        Action::make('share')
            ->icon('Share2')
            ->url(fn ($record) => route('share', $record))
            ->openUrlInNewTab(),
    ])->label('More'),

    DeleteAction::make()
        ->can(fn ($record) => auth()->user()->can('delete', $record)),
])
```

### Full Bulk Actions Example

```php
->bulkActions([
    BulkActionGroup::make([
        BulkAction::make('publish')
            ->label('Publish')
            ->icon('Send')
            ->color('success')
            ->requiresConfirmation()
            ->action(function ($records) {
                $records->each->publish();

                \Laravilt\Notifications\Notification::make()
                    ->title("{$records->count()} posts published")
                    ->success()
                    ->send();
            }),

        BulkAction::make('archive')
            ->label('Archive')
            ->icon('Archive')
            ->color('warning')
            ->requiresConfirmation()
            ->action(fn ($records) => $records->each->archive()),
    ])->label('Change Status'),

    BulkAction::make('assignCategory')
        ->label('Assign Category')
        ->icon('Tag')
        ->form([
            Select::make('category_id')
                ->label('Category')
                ->options(Category::pluck('name', 'id'))
                ->required(),
        ])
        ->action(function ($records, array $data) {
            $records->each->update(['category_id' => $data['category_id']]);
        }),

    BulkAction::make('export')
        ->label('Export Selected')
        ->icon('Download')
        ->action(fn ($records) => $this->exportRecords($records)),

    DeleteBulkAction::make()
        ->can(fn () => auth()->user()->can('delete-posts')),
])
```

### Header Actions Example

```php
->headerActions([
    CreateAction::make()
        ->url(route('products.create'))
        ->can('create', Product::class),

    Action::make('export')
        ->label('Export All')
        ->icon('Download')
        ->color('secondary')
        ->action(function () {
            return Excel::download(
                new ProductsExport(),
                'products.xlsx'
            );
        }),

    Action::make('import')
        ->label('Import')
        ->icon('Upload')
        ->form([
            FileUpload::make('file')
                ->acceptedFileTypes(['.csv', '.xlsx'])
                ->required(),
        ])
        ->action(function (array $data) {
            Excel::import(new ProductsImport(), $data['file']);

            \Laravilt\Notifications\Notification::make()
                ->title('Import completed')
                ->success()
                ->send();
        }),
])
```

---

## Best Practices

### 1. Use Built-in Actions When Possible

```php
// Good
ViewAction::make()
EditAction::make()
DeleteAction::make()

// Avoid reinventing
Action::make('view')->url(...)
```

### 2. Provide Clear Labels and Icons

```php
Action::make('publish')
    ->label('Publish Post')      // Clear label
    ->icon('Send')               // Appropriate icon
```

### 3. Add Confirmations for Destructive Actions

```php
DeleteAction::make()
    ->requiresConfirmation()
    ->modalHeading('Delete record?')
    ->modalDescription('This cannot be undone.');
```

### 4. Use Authorization

```php
EditAction::make()
    ->can(fn ($record) => auth()->user()->can('update', $record));
```

### 5. Provide Feedback

```php
Action::make('process')
    ->action(fn ($record) => $record->process())
    ->successNotificationTitle('Processing complete')
    ->failureNotificationTitle('Processing failed');
```

### 6. Group Related Actions

```php
ActionGroup::make([
    Action::make('export'),
    Action::make('duplicate'),
    Action::make('share'),
])->label('More Options');
```

---

## Next Steps

- [Columns](columns.md) - Table column types
- [Filters](filters.md) - Filter configuration
- [Introduction](introduction.md) - Table basics
