<?php

namespace App\Http\Resources\APIv1;

use App\Http\Resources\ApiResource;

class CommentResource extends ApiResource
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
            'content' => $this->content,
            'parent_id' => $this->parent_id,
            'number' => $this->number,
            'path' => $this->path,

            'article' => ArticleResource::make($this->whenLoaded('post')),
        ];

    }
}
