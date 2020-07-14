<?php

namespace App\Models;

use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use Commentable;
    
    protected $fillable = ['user_id','stars'];
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function rateable()
    {
        return $this->morphTo();
    }
}
