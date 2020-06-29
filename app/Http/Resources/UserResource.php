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
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "address" => $this->address,
            "phone" => $this->number,
            "gender" => $this->gender,
            "avatar" => $this->avatar,
            "roles" => [ //TODO: When Roles loaded Resource
                [
                    "id" => 1,
                    "name" => "admin"
                ]
            ],
            "signup_time" => $this->created_at->diffForHumans(),
        ];
    }
}
