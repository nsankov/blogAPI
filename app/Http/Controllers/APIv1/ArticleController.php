<?php

namespace App\Http\Controllers\APIv1;



use App\Http\Controllers\ApiController;
use App\Http\Resources\APIv1\ArticleCollection;

use App\Services\ArticleService;
use Illuminate\Http\Request;
use App\Http\Resources\APIv1\ArticleResource;
use App\Http\Requests\APIv1\ArticleStoreRequest;
use App\Http\Requests\APIv1\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\User;
class ArticleController extends ApiController
{
    public function __construct(ArticleService $articleService)
    {
        $this->authorizeResource(Article::class, 'article');
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $articles = $this->articleService->list($request);
        return new ArticleCollection($articles->simplePaginate(self::PAGE_CHUNK_10));
    }

    public function store(ArticleStoreRequest $request, Article $article)
    {
        $article = $this->articleService->create($request->validated(), $article);
        return new ArticleResource($article);
    }

    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    public function update(ArticleUpdateRequest $request, Article $article)
    {
        $article = $this->articleService->update($request->validated(), $article);
        return $article;
    }

    public function destroy(Request $request, Article $article)
    {
        $this->articleService->softDelete($article);
        return response()->noContent();
    }
}
