<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Http\Requests\Product\storeRequest;
use App\Http\Requests\Product\updateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
    *
    * @var ProductsRepositoryInterface $repo
    *
    */
    private $repo;
    
    /**
    *
    * @param ProductsRepositoryInterface $productsRepositoryInterface
    *
    */
    public function __construct(ProductsRepositoryInterface $productsRepositoryInterface)
    {
        $this->repo = $productsRepositoryInterface;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection($this->repo->paginated())->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeRequest $request)
    {
        $product = $this->repo->create($request->only([
            "name","description","attributes","thumbnail",
            "images","stock","category_id","price"]));
        
        return (new ProductResource($product))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return (new ProductResource($this->repo->find($product)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(updateRequest $request, Product $product)
    {
        $updated = $this->repo->update($request->all(),$product);

        return response()->json(['status' => $updated]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $deleted = $this->repo->delete($product);
        return response()->json(['status' => $deleted]);
    }
}
