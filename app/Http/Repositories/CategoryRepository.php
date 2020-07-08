<?php

namespace App\Http\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository {

    public function __construct(Category $category){
        parent::__construct($category);
    }

    /**
     *
     * @return Collection
     */
    public function all()
    {
        $categories = $this->model->where('parent_id',null)->with('children')->get();
        return $categories;
    }

    /**
     *
     * @param  \App\Category  $category
     * @return Collection
     */
    public function find(Category $category)
    {
        $category = $category->load(['products','childProducts']);
        return $category;
    }

}