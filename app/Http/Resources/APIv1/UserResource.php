<?php

namespace App\Http\Resources\APIv1;

use App\Http\Resources\ApiResource;

class UserResource extends ApiResource
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
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->whenLoaded('avatar'),
        ];
    }
}
