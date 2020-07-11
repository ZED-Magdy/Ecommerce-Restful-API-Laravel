<?php

namespace App\Traits;

use App\Models\Wish;
use Illuminate\Database\Eloquent\Model;

trait Wishable {

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function wishes(){
        return $this->morphMany('App\Models\Wish','wishable');
    }
}