<?php

namespace App\Services;

use App\Models\Comment;
use App\Events\CreateComment;

class CommentService
{

  public function list($articleId)
  {
      return Comment::get()->where('article_id', $articleId);
  }

  public function save($data)
  {
      $comment = Comment::createComment($data);
      event(new CreateComment($comment));
      return $comment;
  }

  public function get($commentId) {
      return Comment::find($commentId);
  }

  public function delete($commentId)
  {
      $comment = Comment::find($commentId);
      $comment->delete();
  }
}
