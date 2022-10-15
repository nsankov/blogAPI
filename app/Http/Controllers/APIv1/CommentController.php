<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\APIv1\CommentStoreRequest;
use App\Http\Requests\APIv1\CommentUpdateRequest;
use App\Http\Resources\APIv1\CommentCollection;
use App\Http\Resources\APIv1\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends ApiController
{
    public function index(Request $request, $articleId)
    {
        $comments = Comment::get()->where('article_id', $articleId);
        return new CommentCollection($comments);
    }

    public function store(CommentStoreRequest $request, $articleId)
    {
        $comment = Comment::createComment($request->validated());
        return (new CommentResource($comment))->response()->setStatusCode(201);
    }

    public function show(Request $request, $articleId, $commentId) {
        $comment = Comment::find($commentId);
        return new CommentResource($comment);
    }

    public function destroy(Request $request, $articleId, $commentId)
    {
        $comment = Comment::find($commentId);
        $comment->delete();
        return response()->noContent();
    }
}
