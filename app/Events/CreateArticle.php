<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CreateArticle
{
    use SerializesModels;

    public $article;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($article)
    {
        $this->article = $article;
    }
}
