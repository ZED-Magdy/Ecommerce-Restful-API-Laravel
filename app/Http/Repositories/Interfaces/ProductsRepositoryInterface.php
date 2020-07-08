<?php
namespace App\Http\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductsRepositoryInterface {

    /**
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function paginated(int $perPage = 30) : LengthAwarePaginator;

    /**
     *
     * @param Product $product
     * @return Product
     */
    public function find(Product $product) : Product;

    /**
     *
     * @param array $attributes
     * @return Product
     */
    public function create(array $attributes) : Product;

    /**
     *
     * @param array $attributes
     * @param Product $product
     * @return boolean
     */
    public function update(array $attributes,Product $product) : bool;

    /**
     *
     * @param Product $product
     * @return boolean
     */
    public function delete(Product $product) :bool;
}