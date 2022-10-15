<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @see \App\Http\Controllers\CommentController
 */
class CommentControllerTest extends ApiTestCase
{
    use RefreshDatabase, WithFaker;


    protected Article $Article;
    protected function setUp(): void
    {
        parent::setUp();
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
        $this->actingAs($this->users->first());
        $comment = Comment::factory()->create(['article_id' => $this->Article->id, 'user_id' => $this->Article->user_id, 'path' => '001', 'number' => 1]);
        $response = $this->getJson(route('articles.comments.index', $this->Article));
        $response->assertOk();
    }

    public function testStore()
    {
        $this->actingAs($this->users->first());
        $comment = Comment::factory()->make();
        $response = $this->post(route('articles.comments.store', $this->Article->id), $comment->toArray());
        $response->assertCreated();
        $comments = Comment::query()
            ->where('id', $response['data']['id'])
            ->get();
        $this->assertCount(1, $comments);
    }

    public function testShow()
    {
        $this->actingAs($this->users->first());
        $comment = Comment::factory()->create(['article_id' => $this->Article->id, 'user_id' => $this->Article->user_id, 'path' => '001', 'number' => 1]);
        $response = $this->getJson(route('articles.comments.show', ['comment' => $comment, 'article_id' => $this->Article->id]));
        $response->assertOk();
    }

    public function testDestroy()
    {
        $this->actingAs($this->users->first());
        $comment = Comment::factory()->create(['article_id' => $this->Article->id, 'user_id' => $this->Article->user_id, 'path' => '001', 'number' => 1]);
        $response = $this->delete(route('articles.comments.destroy', ['comment' => $comment, 'article_id' => $this->Article->id]));
        $response->assertNoContent();
        $this->assertSoftDeleted($comment);
    }
}
