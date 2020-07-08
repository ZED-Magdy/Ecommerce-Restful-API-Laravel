<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Builder;


class SearchRepository {
    private $model, $attributes, $perPage;

    public function __construct($model,array $attributes,int $perPage = 15)
    {
        $validate = request()->validate([
            "query" => 'required|min:3',
            "limit" => 'numeric|min:1',
            "order" => 'in:asc,desc,DESC,ASC'
        ]);
        if(isset($validate["message"])){
            return response()->json($validate);
        }
        $this->model      = $model;
        $this->attributes = $attributes;
        $this->perPage = $perPage;
    }

    public function search(){

        $term        = request()->get('query');
        $searchTerms = explode(' ',$term);
        $order       = request()->get('order','ASC');
        $attributes  = $this->attributes;

        $query = (new $this->model)->newQuery();
        $query = $query->where(function (Builder $query) use ($attributes ,$searchTerms) {
            foreach ($attributes as $attribute) {
                foreach ($searchTerms as $searchTerm) {
                    $sql        = "LOWER(`{$attribute}`) LIKE ?";
                    $searchTerm = mb_strtolower($searchTerm, 'UTF8');
                    $query->orWhereRaw($sql, ["%{$searchTerm}%"]);
            }
           }
        })->orderBy('id',$order);
        $query = $query->paginate($this->perPage);
        return $query;
    }
}