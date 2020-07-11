<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    protected $fillable = ['user_id','wishable_type','wishable_id'];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function wishable(){
        return $this->morphTo();
    }
}
