<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $products = $this->whenLoaded('products');
        if(!$products instanceof MissingValue){
            $products = $products->merge($this->childProducts)->sortBy("id");
        }
        return [
            "id"             => $this->id,
            "name"           => $this->name,
            "products"       => ProductResource::collection($products),
        ];
    }
}
