<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\storeRequest;
use App\Http\Requests\Product\updateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(\ProductRepository::paginated())->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeRequest $request)
    {
        $product = \ProductRepository::create($request->only([
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
        return (new ProductResource(\ProductRepository::find($product)));
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
        $updated = \ProductRepository::update($request->all(), $product);

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
        $deleted = \ProductRepository::delete($product);
        return response()->json(['status' => $deleted]);
    }
}
