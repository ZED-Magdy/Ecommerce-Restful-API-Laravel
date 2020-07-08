<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\Imageable;
use App\Traits\Rateable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Imageable, Rateable, Commentable;
    
    protected $fillable = ['user_id','name','description','stock','price','category_id'];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes(){
        return $this->belongsToMany('App\Models\Attribute','attribute_product');
    }
}
