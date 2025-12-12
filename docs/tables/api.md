# Table API

Complete reference for REST API generation from Laravilt Tables.

## Overview

Laravilt Tables can automatically generate complete REST APIs with:

- **CRUD Endpoints** - List, Show, Create, Update, Delete operations
- **OpenAPI Documentation** - Auto-generated Swagger/OpenAPI 3.0.3 specs
- **Validation** - Built-in request validation
- **Authorization** - Middleware-based access control
- **Custom Actions** - Define custom API actions
- **Relationships** - Load related data with includes
- **Filtering & Sorting** - Query parameters for data filtering
- **Pagination** - Configurable pagination
- **API Tester** - Interactive API testing UI in the panel

---

## Enabling API for Resources

### Basic Setup

In your Resource class:

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use Laravilt\Panel\Resources\Resource;

class UserResource extends Resource
{
    protected static bool $hasApi = true; // Enable API

    public static function api(ApiResource $api): ApiResource
    {
        return UserApi::configure($api);
    }
}
```

### API Configuration Class

```php
<?php

namespace App\Laravilt\Admin\Resources\User\Api;

use Laravilt\Tables\ApiResource;
use Laravilt\Tables\ApiColumn;

class UserApi
{
    public static function configure(ApiResource $api): ApiResource
    {
        return $api
            ->endpoint('/api/users')
            ->columns([
                ApiColumn::make('id')
                    ->type('integer')
                    ->sortable(),

                ApiColumn::make('name')
                    ->type('string')
                    ->searchable()
                    ->sortable()
                    ->required(),

                ApiColumn::make('email')
                    ->type('string')
                    ->format('email')
                    ->searchable()
                    ->sortable()
                    ->required()
                    ->unique(),

                ApiColumn::make('created_at')
                    ->type('string')
                    ->format('date-time')
                    ->sortable()
                    ->readonly(),
            ])
            ->paginated()
            ->perPage(15);
    }
}
```

---

## API Column Types

### Type System

ApiColumn supports the following types:

```php
ApiColumn::make('field')->type('integer')    // Integer numbers
ApiColumn::make('field')->type('string')     // Text strings
ApiColumn::make('field')->type('boolean')    // True/false values
ApiColumn::make('field')->type('datetime')   // Date and time
ApiColumn::make('field')->type('date')       // Date only
ApiColumn::make('field')->type('time')       // Time only
ApiColumn::make('field')->type('decimal')    // Decimal numbers
ApiColumn::make('field')->type('array')      // Arrays
ApiColumn::make('field')->type('object')     // Objects/JSON
```

### Format Support

Additional formats for type validation:

```php
// String formats
->format('email')        // Email address
->format('uri')          // URL/URI
->format('uuid')         // UUID v4
->format('date-time')    // ISO 8601 datetime
->format('date')         // Date only
->format('time')         // Time only
```

---

## Column Configuration

### Query Capabilities

```php
// Enable sorting
ApiColumn::make('name')->sortable()

// Enable filtering
ApiColumn::make('status')->filterable()

// Enable full-text search
ApiColumn::make('description')->searchable()

// Load relationships
ApiColumn::make('posts')
    ->relationship('posts')
    ->nestedColumns([
        ApiColumn::make('title')->type('string'),
        ApiColumn::make('published_at')->type('datetime'),
    ])
```

### Access Control

```php
// Readable in responses (default: true)
ApiColumn::make('name')->readable()

// Write-only (not in responses)
ApiColumn::make('password')->writeOnly()

// Writable in create/update
ApiColumn::make('email')->writable()

// Not writable
ApiColumn::make('id')->notWritable()

// Fine-grained control
ApiColumn::make('role')
    ->creatable()      // Can be set on create
    ->updatable()      // Can be changed on update
```

### Default Values

```php
ApiColumn::make('status')
    ->type('string')
    ->default('active')

ApiColumn::make('is_verified')
    ->type('boolean')
    ->default(false)
```

### Transformations

```php
// Custom transformation
ApiColumn::make('price')
    ->type('integer')
    ->transformUsing(fn ($value) => $value / 100) // Cents to dollars

// Type casting
ApiColumn::make('is_active')
    ->castAs('bool')

ApiColumn::make('metadata')
    ->castAs('json')
```

---

## Validation

### Basic Validation

```php
ApiColumn::make('email')
    ->type('string')
    ->required()
    ->email()
    ->unique('users', 'email')

ApiColumn::make('age')
    ->type('integer')
    ->min(18)
    ->max(120)

ApiColumn::make('website')
    ->type('string')
    ->url()
```

### Custom Rules

```php
ApiColumn::make('password')
    ->type('string')
    ->required()
    ->rules(['min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'])

ApiColumn::make('category_id')
    ->type('integer')
    ->exists('categories', 'id')
```

### Operation-Specific Rules

```php
ApiColumn::make('email')
    ->type('string')
    ->createRules(['required', 'email', 'unique:users,email'])
    ->updateRules(['email', 'unique:users,email,{{id}}'])
```

### Available Validators

```php
->required()
->email()
->url()
->uuid()
->unique(string $table, string $column)
->exists(string $table, string $column)
->date()
->min(int|float $value)
->max(int|float $value)
->regex(string $pattern)
->in(array $values)
->notIn(array $values)
->alpha()
->alphaNum()
->numeric()
->integer()
->json()
->accepted()
->declined()
->rules(array $rules)
->createRules(array $rules)
->updateRules(array $rules)
```

---

## API Resource Configuration

### Operations Control

Enable/disable specific operations:

```php
$api->list(true, ['auth:sanctum'])          // GET /endpoint
    ->show(true, ['auth:sanctum'])          // GET /endpoint/{id}
    ->create(true, ['auth:sanctum'])        // POST /endpoint
    ->update(true, ['auth:sanctum'])        // PUT/PATCH /endpoint/{id}
    ->delete(true, ['auth:sanctum'])        // DELETE /endpoint/{id}
    ->bulkDelete(true, ['auth:sanctum'])    // DELETE /endpoint (bulk)
```

**Middleware Options:**
- `null` - Use default `auth:sanctum`
- `[]` - Public access (no auth)
- `['custom:middleware']` - Custom middleware

### Public API Example

```php
$api->list(true, [])      // Public list endpoint
    ->show(true, [])      // Public show endpoint
    ->create(false)       // Disable create
    ->update(false)       // Disable update
    ->delete(false)       // Disable delete
```

### Query Configuration

```php
// Restrict filterable fields
$api->allowedFilters(['status', 'category', 'is_active'])

// Restrict sortable fields
$api->allowedSorts(['name', 'created_at', 'price'])

// Define relationship includes
$api->allowedIncludes(['posts', 'comments', 'author'])
```

If not specified, automatically detected from columns with `filterable()`, `sortable()`, and `relationship()`.

### Pagination

```php
$api->paginated(true)     // Enable pagination (default)
    ->perPage(15)         // Items per page (default: 12)

$api->paginated(false)    // Disable pagination
```

### Validation Requests

```php
// Global validation rules
$api->rules([
    'name' => 'required|string|max:255',
    'email' => 'required|email',
])

// Operation-specific rules
$api->createRules([
    'password' => 'required|min:8',
])
->updateRules([
    'password' => 'nullable|min:8',
])

// Custom FormRequest classes
$api->validationRequest(CreateUserRequest::class, 'create')
    ->validationRequest(UpdateUserRequest::class, 'update')

// Or
$api->createValidationRequest(CreateUserRequest::class)
    ->updateValidationRequest(UpdateUserRequest::class)
```

### Documentation

```php
$api->title('User Management API')
    ->name('users')
    ->description('API for managing user accounts')
    ->version('v1')
    ->authenticated(true)
    ->headers([
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])
    ->sampleRequest([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ])
    ->sampleResponse([
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ])
```

---

## Custom API Actions

Define custom endpoints beyond CRUD:

```php
use Laravilt\Tables\ApiAction;

$api->actions([
    ApiAction::make('toggle_status')
        ->label('Toggle Status')
        ->description('Toggle user active status')
        ->method('POST')
        ->requiresRecord(true)
        ->action(function ($record, $request) {
            $record->update([
                'is_active' => !$record->is_active,
            ]);
            return $record;
        })
        ->successMessage('Status toggled successfully'),

    ApiAction::make('bulk_verify')
        ->label('Bulk Verify Users')
        ->description('Verify multiple users at once')
        ->method('POST')
        ->bulk(true)
        ->fields([
            ApiColumn::make('verified_at')
                ->type('datetime')
                ->default(fn () => now()),
        ])
        ->action(function ($records, $request) {
            $records->each->update([
                'verified_at' => $request->input('verified_at'),
            ]);
            return $records;
        })
        ->successMessage('Users verified successfully'),
])
```

### Action Configuration

```php
ApiAction::make('action_slug')
    ->label('Action Label')
    ->description('Action description')
    ->icon('CheckCircle')
    ->color('success')
    ->method('POST')                    // HTTP method
    ->requiresRecord(bool)              // Operates on single record
    ->bulk(bool)                        // Operates on multiple records
    ->requiresConfirmation(?string)     // Require confirmation
    ->fields(array<ApiColumn>)          // Input fields
    ->rules(array)                      // Validation rules
    ->before(Closure)                   // Before execution
    ->action(Closure)                   // Main execution
    ->after(Closure)                    // After execution
    ->successMessage(string)            // Success notification
    ->errorMessage(string)              // Error notification
    ->hidden(bool)                      // Hide from API tester
```

### Action Endpoints

**Record Action:**
```
POST /api/users/{id}/actions/toggle_status
```

**Bulk Action:**
```
POST /api/users/actions/bulk_verify
```

---

## Generated Endpoints

### CRUD Operations

For resource at `/api/users`:

| Operation | Method | Endpoint | Description |
|-----------|--------|----------|-------------|
| List | GET | `/api/users` | Get paginated list |
| Show | GET | `/api/users/{id}` | Get single record |
| Create | POST | `/api/users` | Create new record |
| Update | PUT/PATCH | `/api/users/{id}` | Update record |
| Delete | DELETE | `/api/users/{id}` | Delete record |
| Bulk Delete | DELETE | `/api/users` | Delete multiple records |

### Query Parameters

**Pagination:**
```
GET /api/users?page=2&per_page=20
```

**Search:**
```
GET /api/users?search=john
```

**Filtering:**
```
GET /api/users?status=active&role=admin
```

**Sorting:**
```
GET /api/users?sort=created_at&direction=desc
```

**Includes:**
```
GET /api/users?include=posts,comments
```

**Combined:**
```
GET /api/users?search=john&status=active&sort=name&direction=asc&page=1&per_page=15
```

---

## OpenAPI/Swagger Documentation

### Generate OpenAPI Spec

```php
$api = UserResource::getApiResource();

// Get as array
$openapi = $api->toOpenApi();

// Get as JSON
$json = $api->toOpenApiJson();

// Get as YAML
$yaml = $api->toOpenApiYaml();
```

### Auto-Generated Documentation

The API resource automatically generates:

- **Schemas** - Request/response schemas for all operations
- **Paths** - All CRUD endpoints with parameters
- **Security** - Authentication requirements
- **Validation** - Request validation constraints
- **Examples** - Sample requests/responses

**Example OpenAPI Output:**

```json
{
  "openapi": "3.0.3",
  "info": {
    "title": "User Management API",
    "version": "v1",
    "description": "API for managing user accounts"
  },
  "paths": {
    "/api/users": {
      "get": {
        "summary": "List Users",
        "parameters": [
          {"name": "page", "in": "query", "schema": {"type": "integer"}},
          {"name": "per_page", "in": "query", "schema": {"type": "integer"}},
          {"name": "search", "in": "query", "schema": {"type": "string"}},
          {"name": "sort", "in": "query", "schema": {"type": "string"}},
          {"name": "direction", "in": "query", "schema": {"type": "string", "enum": ["asc", "desc"]}}
        ],
        "responses": {
          "200": {
            "description": "Successful response",
            "content": {
              "application/json": {
                "schema": {"$ref": "#/components/schemas/UserListResponse"}
              }
            }
          }
        }
      },
      "post": {
        "summary": "Create User",
        "requestBody": {
          "content": {
            "application/json": {
              "schema": {"$ref": "#/components/schemas/UserCreateRequest"}
            }
          }
        },
        "responses": {
          "201": {"description": "User created"}
        }
      }
    }
  },
  "components": {
    "schemas": {
      "User": {
        "type": "object",
        "properties": {
          "id": {"type": "integer"},
          "name": {"type": "string"},
          "email": {"type": "string", "format": "email"}
        }
      }
    }
  }
}
```

---

## API Tester

Enable interactive API testing in the panel:

```php
$api->useAPITester(true)
```

The API tester provides:
- **Interactive UI** - Test API endpoints from the panel
- **Request Builder** - Build requests with form inputs
- **Response Viewer** - View formatted responses
- **Authentication** - Automatically includes auth headers
- **Action Testing** - Test custom actions
- **Documentation** - View OpenAPI docs

---

## Complete Example

### Product API Configuration

```php
<?php

namespace App\Laravilt\Admin\Resources\Product\Api;

use Laravilt\Tables\ApiResource;
use Laravilt\Tables\ApiColumn;
use Laravilt\Tables\ApiAction;

class ProductApi
{
    public static function configure(ApiResource $api): ApiResource
    {
        return $api
            ->endpoint('/api/products')
            ->title('Product Management API')
            ->description('Manage product catalog')
            ->version('v1')
            ->paginated()
            ->perPage(20)
            ->columns([
                // Identification
                ApiColumn::make('id')
                    ->type('integer')
                    ->sortable()
                    ->readonly(),

                // Basic Information
                ApiColumn::make('name')
                    ->type('string')
                    ->searchable()
                    ->sortable()
                    ->required()
                    ->rules(['min:3', 'max:255']),

                ApiColumn::make('slug')
                    ->type('string')
                    ->sortable()
                    ->unique('products', 'slug')
                    ->rules(['alpha_dash']),

                ApiColumn::make('description')
                    ->type('string')
                    ->searchable(),

                // Pricing
                ApiColumn::make('price')
                    ->type('integer')
                    ->sortable()
                    ->filterable()
                    ->required()
                    ->min(0)
                    ->transformUsing(fn ($value) => $value / 100),

                ApiColumn::make('cost')
                    ->type('integer')
                    ->min(0)
                    ->transformUsing(fn ($value) => $value / 100),

                // Inventory
                ApiColumn::make('stock_quantity')
                    ->type('integer')
                    ->sortable()
                    ->filterable()
                    ->default(0)
                    ->min(0),

                ApiColumn::make('sku')
                    ->type('string')
                    ->sortable()
                    ->unique('products', 'sku'),

                // Status
                ApiColumn::make('is_active')
                    ->type('boolean')
                    ->filterable()
                    ->default(true),

                ApiColumn::make('is_featured')
                    ->type('boolean')
                    ->filterable()
                    ->default(false),

                ApiColumn::make('status')
                    ->type('string')
                    ->sortable()
                    ->filterable()
                    ->in(['draft', 'published', 'archived'])
                    ->default('draft'),

                // Category
                ApiColumn::make('category_id')
                    ->type('integer')
                    ->filterable()
                    ->exists('categories', 'id'),

                ApiColumn::make('category')
                    ->relationship('category')
                    ->nestedColumns([
                        ApiColumn::make('id')->type('integer'),
                        ApiColumn::make('name')->type('string'),
                    ]),

                // Media
                ApiColumn::make('thumbnail')
                    ->type('string')
                    ->format('uri'),

                ApiColumn::make('images')
                    ->type('array'),

                // Metadata
                ApiColumn::make('metadata')
                    ->type('object')
                    ->castAs('json'),

                // Timestamps
                ApiColumn::make('created_at')
                    ->type('string')
                    ->format('date-time')
                    ->sortable()
                    ->readonly(),

                ApiColumn::make('updated_at')
                    ->type('string')
                    ->format('date-time')
                    ->sortable()
                    ->readonly(),
            ])
            ->list(true)
            ->show(true)
            ->create(true)
            ->update(true)
            ->delete(true)
            ->bulkDelete(true)
            ->allowedFilters(['status', 'category_id', 'is_active', 'is_featured', 'price', 'stock_quantity'])
            ->allowedSorts(['name', 'price', 'stock_quantity', 'created_at'])
            ->allowedIncludes(['category'])
            ->actions([
                ApiAction::make('toggle_featured')
                    ->label('Toggle Featured')
                    ->description('Toggle product featured status')
                    ->icon('Star')
                    ->color('warning')
                    ->method('POST')
                    ->requiresRecord(true)
                    ->action(function ($record) {
                        $record->update([
                            'is_featured' => !$record->is_featured,
                        ]);
                        return $record;
                    })
                    ->successMessage('Featured status toggled'),

                ApiAction::make('update_stock')
                    ->label('Update Stock')
                    ->description('Update product stock quantity')
                    ->icon('Package')
                    ->color('primary')
                    ->method('POST')
                    ->requiresRecord(true)
                    ->fields([
                        ApiColumn::make('stock_quantity')
                            ->type('integer')
                            ->required()
                            ->min(0),
                    ])
                    ->action(function ($record, $request) {
                        $record->update([
                            'stock_quantity' => $request->input('stock_quantity'),
                        ]);
                        return $record;
                    })
                    ->successMessage('Stock updated successfully'),

                ApiAction::make('bulk_publish')
                    ->label('Publish Selected')
                    ->description('Publish multiple products')
                    ->icon('Send')
                    ->color('success')
                    ->method('POST')
                    ->bulk(true)
                    ->requiresConfirmation('Publish selected products?')
                    ->action(function ($records) {
                        $records->each->update([
                            'status' => 'published',
                            'is_active' => true,
                        ]);
                        return $records;
                    })
                    ->successMessage('Products published successfully'),
            ])
            ->useAPITester(true);
    }
}
```

---

## Best Practices

### 1. Use Type Validation

```php
// Good: Explicit types with validation
ApiColumn::make('age')
    ->type('integer')
    ->min(0)
    ->max(120)

// Avoid: No type or validation
ApiColumn::make('age')
```

### 2. Secure Sensitive Fields

```php
// Good: Write-only for passwords
ApiColumn::make('password')
    ->type('string')
    ->writeOnly()
    ->required()
    ->min(8)

// Avoid: Readable passwords
ApiColumn::make('password')
    ->type('string')
```

### 3. Use Appropriate Middleware

```php
// Good: Protected endpoints
$api->create(true, ['auth:sanctum', 'can:create-users'])

// Avoid: Public create without validation
$api->create(true, [])
```

### 4. Provide Documentation

```php
// Good: Clear API documentation
$api->title('Product API')
    ->description('Manage product catalog with CRUD operations')
    ->sampleRequest([...])
    ->sampleResponse([...])
```

### 5. Enable Useful Query Features

```php
// Good: Enable search, filter, sort on relevant fields
ApiColumn::make('name')
    ->searchable()
    ->sortable()

ApiColumn::make('status')
    ->filterable()
    ->sortable()
```

---

## Next Steps

- [Columns](columns.md) - Table column types
- [Filters](filters.md) - Filter configuration
- [Actions](actions.md) - Row and bulk actions
- [Introduction](introduction.md) - Table basics
