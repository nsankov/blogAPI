<?php

namespace App\Http\Resources\APIv1;

use App\Http\Resources\ApiResource;

class ArticleVoteResource extends ApiResource
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
            'user_id' => $this->user_id,
            'article_id' => $this->article_id,
            'value' => $this->value,
//            'article' => ArticleResource::make($this->whenLoaded('article')), // withoutWrapping
        ];
    }
}
