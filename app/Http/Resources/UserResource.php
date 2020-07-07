<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $condition = auth()->check() && (auth()->id() == $this->id || auth()->user()->hasRole('admin'));
        return [
            "id"          => $this->id,
            "name"        => $this->name,
            "email"       => $this->when($condition,$this->email),
            "address"     => $this->when($condition,$this->address),
            "phone"       => $this->when($condition,$this->number),
            "gender"      => $this->when($condition,$this->gender),
            "avatar"      => new ImageResource($this->avatar),
            "roles"       => RoleResource::collection($this->whenLoaded('roles')),
            "signup_time" => $this->created_at->diffForHumans(),
        ];
    }
}
