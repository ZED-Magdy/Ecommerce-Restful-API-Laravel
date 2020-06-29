<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','parent_id'];
    
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories(){
        return $this->hasMany('App\Models\Category','parent_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(){
        return $this->belongsToMany('App\Models\Product','category_product');
    }
}
