<?php

namespace App\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

trait Commentable {
    
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments(){
        return $this->morphMany('App\Models\Comment','commentable');
    }

    /**
     *
     * @param string $body
     * @return Model|false
     */
    public function addComment(string $body) :Model {
        $comment = new Comment();
        $comment->body = $body;
        $comment->user_id = auth()->id();

        return $this->comments()->save($comment);
    }
    /**
     *
     * @param string $body
     * @return bool
     */
    public function updateComment(string $body){
        $this->comments()->first()->update([
            'body' => $body
        ]);
        return true;
    }
}