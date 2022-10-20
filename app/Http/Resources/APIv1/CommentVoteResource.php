<?php

namespace App\Http\Resources\APIv1;

use Database\Factories\UserFactory;
use App\Http\Resources\ApiResource;

class CommentVoteResource extends ApiResource
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
            'comment_id' => $this->comment_id,
            'value' => $this->value,
            'comment' => CommentResource::make($this->whenLoaded('comments')),
            'user' => UserResource::make($this->whenLoaded('user'))
        ];
    }
}
