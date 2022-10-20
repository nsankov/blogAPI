<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use App\Models\ArticleVote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @see \App\Http\Controllers\ArticleVoteController
 */
class ArticleVoteControllerTest extends ApiTestCase
{
    use RefreshDatabase, WithFaker;

    protected Article $Article;
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs($this->users->first());
        $this->Article = $this->createArticle($this->users->last()->id, $this->categories->last()->id);
    }

    protected function createArticle($userId, $categoryId) : Article
    {
        return Article::factory()->create([
            'user_id' => $userId,
            'category_id' => $categoryId
        ]);
    }

    public function testIndex()
    {

        foreach ($this->users as $user){
            $articleVote1 = ArticleVote::factory()->create(['user_id' => $user->id, 'article_id' => $this->Article->id]);
        }
        $response = $this->getJson(route('articles.vote.index', $this->Article->id));
        $response->assertOk();
        $response->assertJsonCount(count($this->users), 'data');
    }

    public function testStore()
    {
        $this->actingAs($this->users->first());
        $articleVote = ArticleVote::factory()->make();
        $response = $this->post(route('articles.vote.store', $this->Article->id), $articleVote->toArray());
        $response->assertCreated();
        $articleVotes = ArticleVote::query()
            ->where('id', $response['data']['id'])
            ->get();
        $this->assertCount(1, $articleVotes);
    }

//    public function testShow()
//    {
//        $articleVote = ArticleVote::factory()->create(['user_id' => $this->users->first()->id, 'article_id' => $this->Article->id]);
//        $response = $this->getJson(route('articles.vote.show', $articleVote));
//        $response->assertOk();
//    }
}
