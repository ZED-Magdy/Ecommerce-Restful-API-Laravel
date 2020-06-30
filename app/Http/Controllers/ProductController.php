<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Http\Requests\Product\storeRequest;
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
        return $this->repo->paginated();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeRequest $request)
    {
        return $this->repo->create($request->only([
            "name","description","attributes","thumbnail",
            "images","stock","category_id","price"
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->repo->find($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        return $this->repo->update($request->only([
            // Update request attributes
        ]),$product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return $this->repo->delete($product);
    }
}
