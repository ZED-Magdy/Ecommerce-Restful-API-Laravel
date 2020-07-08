<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "stars" => (float) $this->stars,
            "comment" => [
                "id" => $this->comments[0]->id,
                "body" => $this->comments[0]->body,
                "user" => new UserResource($this->comments[0]->user),
            ],
            'create_time' => $this->created_at->diffForHumans()
        ];
    }
}
