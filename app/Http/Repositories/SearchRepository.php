<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SearchRepository
{
    private $model;
    private $attributes;
    private $perPage;

    /**
     *
     * @param string $model
     * @param array $attributes
     * @param integer $perPage
     */
    public function __construct($model, array $attributes, int $perPage = 15)
    {
        $validate = request()->validate([
            "query" => 'required|min:3',
            "order" => 'in:asc,desc,DESC,ASC'
        ]);
        if (isset($validate["message"])) {
            return response()->json($validate);
        }
        $this->model      = $model;
        $this->attributes = $attributes;
        $this->perPage    = $perPage;
    }

    public function search()
    {

        $term        = request()->get('query');
        $searchTerms = explode(' ', $term);
        $order       = request()->get('order', 'ASC');
        $attributes  = $this->attributes;

        $query = $this->model::query();
        $query = $query->where(function (Builder $query) use ($attributes, $searchTerms) {
            foreach ($attributes as $attribute) {
                foreach ($searchTerms as $searchTerm) {
                    $sql        = "LOWER(`{$attribute}`) LIKE ?";
                    $searchTerm = mb_strtolower($searchTerm, 'UTF8');
                    $query->orWhereRaw($sql, ["%{$searchTerm}%"]);
                }
            }
        })->orderBy('id', $order);
        $query = $query->paginate($this->perPage)
                       ->withPath(route('products.search', ["query" => $term, "order" => $order]));
        return $query;
    }
}
