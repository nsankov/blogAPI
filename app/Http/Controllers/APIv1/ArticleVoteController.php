<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\APIv1\ArticleVoteStoreRequest;
use App\Http\Resources\APIv1\ArticleVoteCollection;
use App\Http\Resources\APIv1\ArticleVoteResource;
use App\Models\ArticleVote;
use Illuminate\Http\Request;

class ArticleVoteController extends ApiController
{

    public function index(Request $request, $article_id)
    {
        $articleVotes = ArticleVote::select()->where(compact('article_id'))
            ->with('user')
            ->get();

        return new ArticleVoteCollection($articleVotes);
    }

    public function store(ArticleVoteStoreRequest $request, $article_id)
    {
        $postVote = ArticleVote::updateOrCreate(['article_id' => $article_id, 'user_id' => auth()->id()], $request->validated());
        return new ArticleVoteResource($postVote);
    }

    public function show(Request $request, $article_id, $id)
    {
        $articleVote = ArticleVote::find($id);

        return new ArticleVoteResource($articleVote);
    }
}
