<?php
namespace App\Http\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

interface ProductsRepositoryInterface {
    /**
     *
     * @param integer $perPage
     * @return JsonResponse
     */
    public function paginated($perPage = 15) : JsonResponse;
    /**
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function find(Product $product) : JsonResponse;
    /**
     *
     * @param array $attributes
     * @return JsonResponse
     */
    public function create(array $attributes) : JsonResponse;
    /**
     *
     * @param array $attribute
     * @param Product $product
     * @return JsonResponse
     */
    public function update(array $attribute,Product $product) : JsonResponse;
    /**
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function delete(Product $product) :JsonResponse;
}