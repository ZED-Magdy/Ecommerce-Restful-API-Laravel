<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\SearchRepository;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    private $repo;

    public function __construct()
    {
        $this->repo = new SearchRepository(Product::class,["name","description"], 5);
    }
    public function search(){
        return ProductResource::collection($this->repo->search());
    }
}
