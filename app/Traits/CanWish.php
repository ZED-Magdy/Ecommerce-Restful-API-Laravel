<?php

namespace App\Traits;

use App\Models\Wish;
use Illuminate\Database\Eloquent\Model;

trait CanWish {

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishes(){
        return $this->hasMany('App\Models\Wish');
    }

    /**
     *
     * @param Model $model
     * @return Model|false
     */
    public function wish(Model $model){

        if(!in_array(Wishable::class, class_uses($model))){
            return false;
        }

        $wish = new Wish();
        $wish->user_id = auth()->id();
        return $model->wishes()->save($wish);
    }

    /**
     *
     * @param Model $model
     * @return bool|null
     * @throws \Exception
     */
    public function removeWishOf(Model $model){

        if(!in_array(Wishable::class, class_uses($model))){
            return false;
        }
        return $this->wishes()->where('wishable_id',$model->id)
                              ->where('wishable_type',get_class($model))
                              ->delete();
    }
}