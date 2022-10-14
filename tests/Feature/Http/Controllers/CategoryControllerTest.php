<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use App\Models\ArticleVote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @see \App\Http\Controllers\CategoryController
 */
class CategoryControllerTest extends ApiTestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        $this->actingAs($this->users->first());
        $categories = Category::factory()->times(3)->create();
        $response = $this->getJson(route('categories.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $this->actingAs($this->users->first());
        $category = Category::factory()->make();
        $response = $this->post(route('categories.store'), $category->toArray());
        $response->assertCreated();
        $categories = Category::query()
            ->where('id', $response['data']['id'])
            ->get();
        $this->assertCount(1, $categories);
    }


    public function testShow()
    {
        $this->actingAs($this->users->first());
        $category = Category::factory()->create();

        $response = $this->getJson(route('categories.show', $category));

        $response->assertOk();
    }

    public function testUpdate()
    {
        $this->actingAs($this->users->first());
        $category = Category::factory()->create();
        $update = Category::factory()->make();
        $response = $this->put(route('categories.update', $category), $update->toArray());
        $response->assertOk();
    }


    public function testDestroy()
    {
        $this->actingAs($this->users->first());
        $category = Category::factory()->create();
        $response = $this->delete(route('categories.destroy', $category->id));
        $response->assertNoContent();
        $this->assertDatabaseMissing(Category::class, $category->toArray());
    }


    public function testTop()
    {
        $categoryArticlesWithVotes = $this->createCategoryWithArticlesAndVotes($this->users, 4, 8, 3);
        $categoryWithoutVotes = $this->createCategoryWithArticlesAndVotes($this->users, 5);
        $categoryWithOneArticle = $this->createCategoryWithArticlesAndVotes($this->users, 5);
        $onlyOneArticle = $this->createCategoryWithArticlesAndVotes($this->users, 1);
die();
        $response = $this->getJson(route('categories.top'));
        $response->assertOk();
        $response->assertJson(['data' => [$categoryArticlesWithVotes, $categoryWithoutVotes, $categoryWithOneArticle]]);
        $response->assertJsonMissing(['data' => [$onlyOneArticle]]);
    }

    private function createCategoryWithArticlesAndVotes($users, $countArticles=1, $countVotesUp=0, $countVotesDown=0){
        $category = Category::factory()->create();

        $article = Article::factory($countArticles)->create([
            'user_id' => $users->first->id,
            'category_id' => $category->first()->id,
        ]);

        if ($countVotesUp){
            ArticleVote::factory($countVotesUp)->create([
                'article_id' => $article->first()->id,
                'user_id' => $users->random(1)->first()->id,
                'value' => ArticleVote::VOTE_UP
            ]);
        }

        if ($countVotesDown){
            ArticleVote::factory($countVotesUp)->create([
                'article_id' => $article->first()->id,
                'user_id' => $users->random(1)->first()->id,
                'value' => ArticleVote::VOTE_DOWN
            ]);
        }
        return $category->toArray();
    }
}
