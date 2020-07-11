<?php

namespace App\Http\Repositories;

use App\Category;
use App\Http\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Mixed_;

class ProductsRepository extends BaseRepository implements ProductsRepositoryInterface {

    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    /**
     *
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function paginated(int $perPage = 30):LengthAwarePaginator
    {
        $products = $this->model->with(['category','user'])->paginate($perPage);

        return $products;
    }

    /**
     *
     * @param Product $product
     * @return Product
     */
    public function find(Product $product):Product
    {
        $product = $product->load(['category','user','images','attributes']);
        return $product;
    }

    /**
     *
     * @param array $attributes
     * @return Product
     */
    public function create(array $attributes): Product
    {
        $product = DB::transaction(function () use($attributes) {
            $product = $this->model->create([
                "name"        => $attributes['name'],
                "description" => $attributes['description'],
                "stock"       => $attributes['stock'],
                "price"       => $attributes['price'],
                "category_id" => $attributes['category_id'],
                "user_id"     => auth()->id()
            ]);
            $product->attributes()->attach($attributes['attributes']);
            $product->addAvatar($attributes['thumbnail']);
            $product->addImages($attributes['images']);
            return $product;
        });

        return $product;
    }

    /**
     *
     * @param array $attributes
     * @param Product $product
     * @return boolean
     */
    public function update(array $attributes, Product $product): bool
    {
        $updated = DB::transaction(function () use($attributes, $product) {
            $updated = false;
            if(isset($attributes['product_updated'])){
                $updated = $product->update([
                    'name'        => $attributes['name'],
                    'description' => $attributes['description'],
                    'stock'       => $attributes['stock'],
                    'price'       => $attributes['price'],
                    'category_id' => $attributes['category_id']
                ]);
            }
            if(isset($attributes['thumbnail_updated'])){
                $updated = $product->addAvatar($attributes['thumbnail'],true) ? true : false;
                
            }
            if(isset($attributes['images_updated'])){
                $updated = $product->addImages($attributes['images'],true) ? true : false;
            }
            if(isset($attributes['attributes_updated'])){
                foreach ($product->attributes as $attribute) {
                    $product->attributes()->detach($attribute->id);
                }
                $product->attributes()->attach($attributes['attributes']);
                $updated = true;
            }

            return $updated;
        });
        return $updated;
    }

    /**
     *
     * @param Product $product
     * @return boolean
     */
    public function delete(Product $product): bool
    {
        $deleted = DB::transaction(function () use($product) {
            foreach ($product->attributes as $attribute) {
                $product->attributes()->detach($attribute->id);
            }
            $product->deleteImages();
            return $product->delete();
        });
        return $deleted;
    }
}