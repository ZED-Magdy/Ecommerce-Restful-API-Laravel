<?php

namespace App\Http\Repositories;

use App\Category;
use App\Http\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductsRepository extends BaseRepository implements ProductsRepositoryInterface {

    public function __construct(Product $product)
    {
        parent::__construct($product);
    }
    /**
     *
     * @param integer $perPage
     * @return JsonResponse
     */
    public function paginated($perPage = 30):JsonResponse
    {
        $products = $this->model->with(['categories'])->paginate($perPage);

        return ProductResource::collection($products)->response();
    }
    /**
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function find(Product $product):JsonResponse
    {
        $product = $product->load(['categories','images']);
        return (new ProductResource($product))->response();
    }
    public function create(array $attributes): \Illuminate\Http\JsonResponse
    {
        $product = DB::transaction(function () use($attributes) {
            $product = $this->model->create([
                "name"        => $attributes['name'],
                "description" => $attributes['description'],
                "stock"       => $attributes['stock'],
                "price"       => $attributes['price'],
                "user_id"     => auth()->id()
            ]);
            $product->categories()->attach($attributes['category_id']);
             //TODO: Add Product Attributes
            $product->addAvatar($attributes['thumbnail']);
            $product->addImages($attributes['images']);
            return $product;
        });

        return (new ProductResource($product))->response();
    }
    public function update(array $attribute, Product $product): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }
    public function delete(Product $product): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }
}