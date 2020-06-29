<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,
            "attributes" => $this->whenLoaded('attributes',null,[]),
            "thumbnail" => $this->avatar,
            "images" => $this->whenLoaded('images',null,[]),
            "stoke" => (int)$this->whenLoaded('stoke',null,$this->stoke),
            "create_time" => $this->created_at->diffForHumans(),
            "categories" => CategoryResource::collection($this->whenLoaded('categories')),
            "user" => new UserResource($this->user),
        ];
    }
}
