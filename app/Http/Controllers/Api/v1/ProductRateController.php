<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRateController extends Controller
{
    public function index(Product $product){
        $rates = $product->ratings()->with('comments')->orderBy('stars','desc')->paginate(15);
        return RatingResource::collection($rates)->response();
    }
    public function store(Request $request,Product $product){
        $product->addRate($request->stars,$request->comment);
        return response()->json(['status' => true]);
    }
}
