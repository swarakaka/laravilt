# Actions Introduction

The Actions package provides interactive UI elements for triggering operations in your Laravilt applications.

## Overview

Laravilt Actions offers:

- **Regular Actions** - Single-record or global operations
- **Bulk Actions** - Operations on multiple records
- **Action Groups** - Organized action collections
- **Modal Forms** - Interactive forms in modal dialogs
- **Confirmation Dialogs** - User confirmations before execution
- **URL Navigation** - Link actions to routes
- **Authorization** - Built-in permission checks
- **Notifications** - Success/failure feedback

Actions integrate seamlessly with resources, tables, forms, and pages.

---

## Basic Usage

### Simple Action

```php
use Laravilt\Actions\Action;

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
    });
```

### Built-in Actions

```php
use Laravilt\Actions\ViewAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;

ViewAction::make();
EditAction::make();
DeleteAction::make();
```

---

## Action Types

### Regular Action

Operates on a single record or globally:

```php
Action::make('activate')
    ->action(function ($record) {
        $record->activate();
    });
```

### Bulk Action

Operates on multiple selected records:

```php
use Laravilt\Actions\BulkAction;

BulkAction::make('activate')
    ->action(function ($records) {
        $records->each->activate();
    })
    ->deselectRecordsAfterCompletion();
```

### Built-in Bulk Actions

```php
use Laravilt\Actions\DeleteBulkAction;
use Laravilt\Actions\RestoreBulkAction;
use Laravilt\Actions\ForceDeleteBulkAction;

DeleteBulkAction::make();
RestoreBulkAction::make();
ForceDeleteBulkAction::make();
```

---

## Action Styling

### Colors

```php
Action::make('action')
    ->color('primary')      // primary, secondary, success, warning, danger
    ->color('destructive')  // For delete actions
    ->color('success');     // For approve/activate actions
```

### Icons

```php
Action::make('send')
    ->icon('Send')              // Lucide icon name
    ->iconPosition('after');    // before or after
```

### Variants

```php
Action::make('view')
    ->button()          // Render as button (default)
    ->iconButton()      // Icon-only button
    ->link();           // Text link
```

### Sizes

```php
Action::make('action')
    ->size('sm')        // sm, default, lg
    ->size('lg');
```

### Outlined Style

```php
Action::make('action')
    ->outlined();       // Outlined button style
```

---

## Confirmation Modals

### Basic Confirmation

```php
Action::make('delete')
    ->requiresConfirmation()
    ->modalHeading('Delete Record')
    ->modalDescription('Are you sure you want to delete this record?')
    ->modalSubmitActionLabel('Yes, Delete')
    ->modalCancelActionLabel('Cancel')
    ->action(fn ($record) => $record->delete());
```

### Modal with Icon

```php
Action::make('delete')
    ->requiresConfirmation()
    ->modalHeading('Delete Record')
    ->modalIcon('AlertCircle')
    ->modalIconColor('destructive')
    ->action(fn ($record) => $record->delete());
```

### Modal Sizes

```php
Action::make('configure')
    ->requiresConfirmation()
    ->modalWidth('4xl')     // sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl
    ->modalHeading('Configure Settings');
```

### Slide-Over Instead of Modal

```php
Action::make('settings')
    ->slideOver()               // Use Sheet component
    ->modalHeading('Settings')
    ->modalFormSchema([...]);
```

---

## Action Forms

### Form Input

```php
Action::make('changeStatus')
    ->modalHeading('Change Status')
    ->modalFormSchema([
        Select::make('status')
            ->label('New Status')
            ->options([
                'draft' => 'Draft',
                'published' => 'Published',
                'archived' => 'Archived',
            ])
            ->required(),

        Textarea::make('reason')
            ->label('Reason')
            ->rows(3),
    ])
    ->action(function ($record, array $data) {
        $record->update([
            'status' => $data['status'],
            'reason' => $data['reason'],
        ]);
    });
```

### View-Only Modal (Infolist)

```php
Action::make('viewDetails')
    ->modalHeading('User Details')
    ->modalInfolistSchema([
        TextEntry::make('name'),
        TextEntry::make('email'),
        TextEntry::make('created_at')->dateTime(),
    ])
    ->isViewOnly();     // No submit button
```

---

## Action Execution

### Basic Action Closure

```php
Action::make('archive')
    ->action(function ($record) {
        $record->update(['archived_at' => now()]);
    });
```

### With Form Data

```php
Action::make('updatePrice')
    ->modalFormSchema([
        TextInput::make('price')->numeric()->required(),
    ])
    ->action(function ($record, array $data) {
        $record->update(['price' => $data['price']]);
    });
```

### Bulk Action Execution

```php
BulkAction::make('publish')
    ->action(function ($records) {
        $records->each(function ($record) {
            $record->publish();
        });

        \Laravilt\Notifications\Notification::make()
            ->title("{$records->count()} posts published")
            ->success()
            ->send();
    });
```

---

## URL Navigation

### Static URL

```php
Action::make('docs')
    ->url('https://docs.laravilt.com')
    ->openUrlInNewTab();
```

### Dynamic URL

```php
Action::make('view')
    ->url(fn ($record) => route('products.show', $record));

Action::make('edit')
    ->url(fn ($record) => route('products.edit', $record));
```

### Internal Routes

```php
ViewAction::make();     // Auto-resolves to view route
EditAction::make();     // Auto-resolves to edit route
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

### Authorize Using Policy

```php
Action::make('publish')
    ->authorize('publish', $record)
    ->action(fn ($record) => $record->publish());
```

---

## Visibility Control

### Hidden/Visible

```php
Action::make('restore')
    ->visible(fn ($record) => $record->trashed());

Action::make('delete')
    ->hidden(fn ($record) => $record->trashed());
```

### Soft Delete Visibility

Built-in actions automatically handle soft-delete visibility:

```php
DeleteAction::make();       // Hidden when trashed
EditAction::make();         // Hidden when trashed
RestoreAction::make();      // Visible only when trashed
ForceDeleteAction::make();  // Visible only when trashed
```

---

## Action Groups

### Basic Group

```php
use Laravilt\Actions\ActionGroup;

ActionGroup::make([
    Action::make('duplicate')
        ->icon('Copy')
        ->action(fn ($record) => $record->duplicate()),

    Action::make('export')
        ->icon('Download')
        ->action(fn ($record) => $this->export($record)),

    Action::make('share')
        ->icon('Share2')
        ->url(fn ($record) => route('share', $record)),
])
->label('More Actions')
->icon('MoreVertical')
->color('secondary');
```

### Bulk Action Groups

```php
use Laravilt\Actions\BulkActionGroup;

BulkActionGroup::make([
    BulkAction::make('publish')->action(...),
    BulkAction::make('draft')->action(...),
    BulkAction::make('archive')->action(...),
])
->label('Change Status')
->icon('Edit');
```

---

## Notifications

### Success Notification

```php
Action::make('approve')
    ->action(fn ($record) => $record->approve())
    ->successNotificationTitle('Approved successfully');
```

### Custom Success Notification

```php
Action::make('process')
    ->action(fn ($record) => $record->process())
    ->successNotification(
        \Laravilt\Notifications\Notification::make()
            ->title('Processing complete')
            ->body('The record has been processed.')
            ->success()
    );
```

### Failure Notification

```php
Action::make('process')
    ->action(function ($record) {
        if (!$record->canBeProcessed()) {
            throw new \Exception('Cannot process this record');
        }
        $record->process();
    })
    ->failureNotificationTitle('Processing failed');
```

---

## Password Confirmation

Require password for sensitive actions:

```php
Action::make('deleteAccount')
    ->requiresPassword()
    ->modalHeading('Delete Account')
    ->modalDescription('Enter your password to confirm deletion')
    ->action(fn ($record) => $record->delete());
```

---

## State Preservation

### Preserve Page State

```php
Action::make('action')
    ->preserveState()       // Keep form data (default: true)
    ->preserveScroll();     // Keep scroll position (default: true)
```

### Force Page Reload

```php
DeleteAction::make()
    ->preserveState(false)  // Forces full page reload
    ->preserveScroll(false);
```

---

## HTTP Methods

### Custom Method

```php
Action::make('action')
    ->method('DELETE')      // POST, GET, PUT, PATCH, DELETE
    ->action(...);
```

### Form Submission

```php
Action::make('submit')
    ->submit()              // type="submit"
    ->form('checkout-form'); // Specific form ID
```

---

## Tooltips

```php
Action::make('delete')
    ->icon('Trash2')
    ->tooltip('Delete this record')
    ->iconButton();
```

---

## Disabled State

```php
Action::make('approve')
    ->disabled(fn ($record) => $record->is_locked)
    ->disabledTooltip('This record is locked');
```

---

## Complete Example

```php
use Laravilt\Actions\Action;
use Laravilt\Actions\ActionGroup;
use Laravilt\Actions\ViewAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;
use Laravilt\Forms\Components\Select;
use Laravilt\Forms\Components\Textarea;

->actions([
    ViewAction::make(),

    EditAction::make()
        ->can(fn ($record) => auth()->user()->can('update', $record)),

    Action::make('publish')
        ->icon('Send')
        ->color('success')
        ->visible(fn ($record) => $record->status === 'draft')
        ->requiresConfirmation()
        ->modalHeading('Publish Post')
        ->modalDescription('This will make the post visible to everyone.')
        ->action(function ($record) {
            $record->publish();

            \Laravilt\Notifications\Notification::make()
                ->title('Post published')
                ->success()
                ->send();
        }),

    Action::make('changeStatus')
        ->icon('Edit')
        ->color('warning')
        ->modalHeading('Change Status')
        ->modalFormSchema([
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
        }),

    ActionGroup::make([
        Action::make('duplicate')
            ->icon('Copy')
            ->action(fn ($record) => $record->replicate()->save()),

        Action::make('export')
            ->icon('Download')
            ->action(fn ($record) => $this->exportRecord($record)),

        Action::make('share')
            ->icon('Share2')
            ->url(fn ($record) => route('share', $record))
            ->openUrlInNewTab(),
    ])->label('More'),

    DeleteAction::make()
        ->can(fn ($record) => auth()->user()->can('delete', $record)),
])
```

---

## Action Contexts

Actions can be used in multiple contexts:

### Table Actions

```php
// In Table configuration
->actions([
    ViewAction::make(),
    EditAction::make(),
    DeleteAction::make(),
])
```

### Table Bulk Actions

```php
->bulkActions([
    DeleteBulkAction::make(),
])
```

### Page Header Actions

```php
// In Page class
protected function getHeaderActions(): array
{
    return [
        CreateAction::make(),
    ];
}
```

### Form Actions

```php
// In form footer
->actions([
    Action::make('save')
        ->submit()
        ->label('Save Changes'),

    Action::make('cancel')
        ->url(route('products.index'))
        ->color('secondary'),
])
```

---

## Best Practices

### 1. Use Built-in Actions

```php
// Preferred
ViewAction::make()
EditAction::make()
DeleteAction::make()

// Avoid reinventing
Action::make('view')->url(...)
```

### 2. Provide Clear Labels

```php
Action::make('approve')
    ->label('Approve Application')
    ->icon('CheckCircle');
```

### 3. Add Confirmations for Destructive Actions

```php
DeleteAction::make()
    ->requiresConfirmation()
    ->modalHeading('Delete Record?')
    ->modalDescription('This action cannot be undone.');
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
    ->successNotificationTitle('Processing complete');
```

### 6. Use Appropriate Colors

```php
Action::make('approve')->color('success')
Action::make('reject')->color('danger')
Action::make('pending')->color('warning')
```

---

## Next Steps

- [Action Configuration](configuration.md) - Detailed configuration options
- [Modal Forms](modal-forms.md) - Interactive modal forms
- [Bulk Actions](bulk-actions.md) - Multi-record operations
