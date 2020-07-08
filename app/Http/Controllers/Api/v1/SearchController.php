<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(){
        $term = request()->get('query');
        $searchTerms = explode(' ',$term);
        $order = request()->get('order','ASC');
        $limit = request()->get('limit');
        $products = (new Product())->newQuery();
        $products = $products->where(function (Builder $query) use ($searchTerms) {
                foreach ($searchTerms as $searchTerm) {
                    $sql = "name LIKE ?";
                    $searchTerm = mb_strtolower($searchTerm, 'UTF8');
                    $query->orWhereRaw($sql, ["%{$searchTerm}%"]);
            }
        })->orderBy('id',$order);
        if($limit){
            $products = $products->limit($limit)->get();
            return  response()->json(["data" => ProductResource::collection($products)]);
        }
        else{
            $products = $products->paginate(15);
        }
        return ProductResource::collection($products)->response();
    }
}
