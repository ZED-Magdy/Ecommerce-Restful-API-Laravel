<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\Imageable;
use App\Traits\Rateable;
use App\Traits\Wishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Product extends Model
{
    use Imageable, Rateable, Commentable, Wishable;

    protected $fillable = ['user_id','stock','price','category_id'];

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
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany('App\Models\Attribute', 'attribute_product');
    }
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function translation()
    {
        $lang = \config('app.locale');
        return $this->hasOne(ProductTranslation::class)->where('lang', $lang);
    }
}
