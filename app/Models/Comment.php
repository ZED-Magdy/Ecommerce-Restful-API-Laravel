<?php

namespace App\Models;

use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Commentable;
    
    protected $fillable = ['user_id','body'];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }
    
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
