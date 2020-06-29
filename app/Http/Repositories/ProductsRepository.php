<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\JsonResponse;

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
        $products = $this->model->paginate($perPage);

        return ProductResource::collection($products)->response();
    }
    /**
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function find(Product $product):JsonResponse
    {
        $product = $product->load(['Categories']);
        return (new ProductResource($product))->response();
    }
    public function create(array $attributes): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }
    public function update(array $attribute, \App\Product $product): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }
    public function delete(\App\Product $product): \Illuminate\Http\JsonResponse
    {
        return response()->json();
    }
}