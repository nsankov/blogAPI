<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\APIv1\CommentVoteStoreRequest;
use App\Http\Resources\APIv1\CommentVoteCollection;
use App\Http\Resources\APIv1\CommentVoteResource;
use App\Models\CommentVote;
use App\Models\User;
use Illuminate\Http\Request;

class CommentVoteController extends ApiController
{
    public function index(Request $request, $article_id, $comment_id)
    {
        $commentVotes = CommentVote::select()->where(compact('comment_id'))
            ->with('user')
            ->get();

        return new CommentVoteCollection($commentVotes);
    }

    public function store(CommentVoteStoreRequest $request, $comment_id, User $user)
    {
        $commentVote = CommentVote::updateOrCreate(['comment_id' => $comment_id, 'user_id' => auth()->id()], $request->validated());
        return new CommentVoteResource($commentVote);
    }

    public function show(Request $request,  $articleId, $commentId, $voteId)
    {
        $commentVote = CommentVote::find($voteId);

        return new CommentVoteResource($commentVote);
    }
}
