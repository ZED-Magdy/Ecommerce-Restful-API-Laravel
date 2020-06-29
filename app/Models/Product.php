<?php

namespace App\Models;

use App\Triats\Imageable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Imageable;
    
    protected $fillable = ['user_id','name','description','stoke'];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(){
        return $this->belongsToMany('App\Models\Category','category_product');
    }
}
