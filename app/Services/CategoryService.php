<?php

namespace App\Services;

use App\Models\Category;


class CategoryService
{

    public function getTopFive(){
      $categories = Category::select('categories.id', 'title', \DB::raw('SUM(article_votes.value) as rating'))
          ->has('articles', '>=', 3)
          ->join('article_votes', 'categories.id', '=', 'article_votes.article_id')
          ->groupBy('categories.id')
          ->orderByRaw('SUM(article_votes.value) DESC')
          ->limit(5)
          ->get();
      return $categories;
    }
}
