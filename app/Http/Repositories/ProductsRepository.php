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
    public function paginated(int $perPage = 30):JsonResponse
    {
        $products = $this->model->with(['category'])->paginate($perPage);

        return ProductResource::collection($products)->response();
    }
    /**
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function find(Product $product):JsonResponse
    {
        $product = $product->load(['category','images','attributes']);
        return (new ProductResource($product))->response();
    }

    /**
     *
     * @param array $attributes
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(array $attributes): \Illuminate\Http\JsonResponse
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

        return (new ProductResource($product))->response();
    }
    
    /**
     *
     * @param array $attributes
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(array $attributes, Product $product): \Illuminate\Http\JsonResponse
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
        return response()->json(['status' => $updated]);
    }

    /**
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Product $product): \Illuminate\Http\JsonResponse
    {
        $deleted = DB::transaction(function () use($product) {
            foreach ($product->attributes as $attribute) {
                $product->attributes()->detach($attribute->id);
            }
            $product->deleteImages();
            return $product->delete();
        });
        return response()->json(['status' => $deleted]);
    }
}