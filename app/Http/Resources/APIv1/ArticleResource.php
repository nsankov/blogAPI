<?php

namespace App\Http\Resources\APIv1;

use App\Http\Resources\ApiResource;

class ArticleResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'category' => CategoryResource::make($this->whenLoaded('category')),
        ];
    }
}
