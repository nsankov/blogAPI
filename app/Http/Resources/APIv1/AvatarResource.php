<?php

namespace App\Http\Resources\APIv1;

use App\Http\Resources\ApiResource;

class AvatarResource extends ApiResource
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
            'user_id' => $this->user_id,
            'filename' => $this->filename,
            'sizes' => $this->sizes,
        ];
    }
}
