<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishResource;
use App\Models\Product;
use App\Models\Wish;
use Illuminate\Http\Request;

class WishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wishes = auth()->user()->wishes()->with('wishable')->paginate();
        return WishResource::collection($wishes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $found = auth()->user()->wishes()->where("wishable_type",Product::class)->where('wishable_id',$request->product_id)->first();
        if($found) {
            return response()->json(["status" => false, "message" => "already exists"],422);
        }
        $product = Product::find($request->product_id);
        if($product == null){
            return response()->json(["status" => false, "message" => "product not found"],404);
        }
        $wish = auth()->user()->wish($product);
        return (new WishResource($wish))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $removed = auth()->user()->removeWishOf($product);
        return response()->json(["status" => $removed]);
    }
}
