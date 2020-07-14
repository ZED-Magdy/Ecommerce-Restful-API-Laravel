<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use SebastianBergmann\Type\NullType;

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
            "name"        => isset($this->translation) ? $this->translation->name : null,
            "description" => isset($this->translation) ? $this->translation->description : null,
            "price"       => (float)$this->price,
            "stock"       => (int)$this->stock,
            "rating"      => (float)$this->avgRating,
            "thumbnail"   => new ImageResource($this->avatar),
            "create_time" => $this->created_at->diffForHumans(),
            "images"      => ImageResource::collection($this->whenLoaded('images')),
            "attributes"  => AttributeResource::collection($this->whenLoaded('attributes')),
            "category"    => new CategoryResource($this->whenLoaded('category')),
            "seller"      => new UserResource($this->whenLoaded('user')),
            "ratings"     => [
                "link" => route('product.ratings.index', $this->id)
            ]
        ];
    }
}
