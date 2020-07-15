<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['parent_id'];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function childProducts()
    {
        return $this->hasManyThrough('App\Models\Product', 'App\Models\Category', 'parent_id', 'category_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }
    public function translation()
    {
        $lang = \config('app.locale');
        return $this->hasOne('App\Models\categoryTranslation')->where('lang', $lang);
    }
}
