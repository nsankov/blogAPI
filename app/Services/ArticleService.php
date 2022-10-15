<?php

namespace App\Services;

use App\Models\Article;
use App\Models\User;
use \Illuminate\Http\Request;
use App\Events\CreateArticle;
use App\Events\DeleteArticle;
use App\Events\UpdateArticle;
use App\Jobs\ProcessCheckProfanity;


class ArticleService
{

    protected Article $article;


    public function list(Request $request)
    {
        $articles = Article::search($request->search);
        if($request->has('category_id')){
            $articles = $articles->where('category_id', $request->input('category_id'));
        }
        return $articles;
    }

    public function create($data, Article $article){
      $article = $article->create($data);
      ProcessCheckProfanity::dispatch($article);
      event(new CreateArticle($article));
      return $article;
    }

    public function update($data, Article $article){
      $article->update(array_filter($data));
      // dd($article);
      ProcessCheckProfanity::dispatch($article);
      event(new UpdateArticle($article));
      return $article;
    }

    public function softDelete(Article $article){
      event(new DeleteArticle($article));
      $article->delete();
    }
}
