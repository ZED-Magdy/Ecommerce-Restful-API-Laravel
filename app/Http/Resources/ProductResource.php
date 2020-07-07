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
            "id"          => $this->id,
            "name"        => $this->name,
            "description" => $this->description,
            "price"       => $this->price,
            "stock"       => (int)$this->stock,
            "rating"      => (float)$this->avgRating,
            "thumbnail"   => new ImageResource($this->avatar),
            "images"      => ImageResource::collection($this->whenLoaded('images')),
            "create_time" => $this->created_at->diffForHumans(),
            "attributes" => AttributeResource::collection($this->whenLoaded('attributes')),
            "category"   => new CategoryResource($this->whenLoaded('category')),
            "seller"       => new UserResource($this->user),
            "ratings"    => [
                "link" => route('product.ratings.index',$this->id)
            ]
        ];
    }
}
