<?php

namespace App\Traits;

use App\Models\Rate;
use Illuminate\Support\Str;

trait Rateable {

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings(){
        return $this->MorphMany('App\Models\Rate','rateable');
    }

    /**
     *
     * @return float
     */
    public function getAvgRatingAttribute(){
        if($this->relationLoaded('ratings')){
            return Str::of($this->ratings->avg('stars'))->limit('4')->__toString();
        }
        return Str::of($this->ratings()->avg('stars'))->limit('4')->__toString();
    }

    /**
     *
     * @param float $stars
     * @param string $review
     * @return Rate
     */
    public function addRate(float $stars, string $review) :Rate {
        $rate = new Rate();
        $rate->stars = $stars;
        $rate->user_id = auth()->id();
        $this->ratings()->save($rate);
        $rate->addComment($review);

        return $rate;
    }

    /**
     *
     * @param float $stars
     * @param string $review
     * @param Rate $rate
     * @return bool
     */
    public function updateRate(float $stars, string $review, Rate $rate){
        $rate->update([
            'stars' => $stars
        ]);

        $rate->updateComment($review,$rate->comments()->first());
        
        return true;
    }

    /**
     *
     * @param Rate $rate
     * @return bool
     */
    public function deleteRate(Rate $rate){
        return $rate->user_id == auth()->id() ? $rate->delete() : false;
    }
}