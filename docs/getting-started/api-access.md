---
title: API Access
description: Accessing your resources via API
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: getting-started
---

# API Access

Laravilt automatically generates API endpoints for your resources.

## Enabling API

Enable API access in your resource:

```php
class ProductResource extends Resource
{
    protected static bool $hasApi = true;

    // API route prefix (default: 'api')
    protected static ?string $apiPrefix = 'api/v1';
}
```

## Generated Endpoints

For each resource, these endpoints are created:

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/products` | List all products |
| POST | `/api/products` | Create product |
| GET | `/api/products/{id}` | Get single product |
| PUT | `/api/products/{id}` | Update product |
| DELETE | `/api/products/{id}` | Delete product |

## API Controller

Create a custom API controller:

```php
namespace App\Laravilt\Admin\Resources\Product\Api;

use App\Models\Product;
use Laravilt\Panel\Http\Controllers\ApiController;

class ProductApi extends ApiController
{
    protected static string $model = Product::class;

    public function index()
    {
        return $this->query()
            ->with('category')
            ->paginate(request('per_page', 15));
    }

    public function store()
    {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'integer|min:0',
        ]);

        return Product::create($validated);
    }

    public function show(Product $product)
    {
        return $product->load('category');
    }

    public function update(Product $product)
    {
        $validated = request()->validate([
            'name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
        ]);

        $product->update($validated);

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
```

## API Authentication

Configure API authentication in your panel:

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->apiTokens()  // Enable API token authentication
        ->apiMiddleware(['auth:sanctum']);
}
```

## API Resources

Use Laravel API Resources for response formatting:

```php
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'formatted_price' => '$' . number_format($this->price, 2),
            'stock' => $this->stock,
            'is_active' => $this->is_active,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
```

## Next Steps

- [First Resource](first-resource) - Resource configuration
- [Quick Start](quick-start) - Basic setup
- [Auth](../auth/introduction) - API authentication
