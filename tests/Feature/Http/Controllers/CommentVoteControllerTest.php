<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentVote;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @see \App\Http\Controllers\CommentVoteController
 */
class CommentVoteControllerTest extends ApiTestCase
{
    use RefreshDatabase, WithFaker;
    protected Article $Article;
    protected Comment $Comment;
    protected function setUp(): void
    {
        parent::setUp();
        $this->Article = Article::factory()->create([
            'user_id' => $this->users->last()->id,
            'category_id' => $this->categories->last()->id
        ]);
        $this->Comment = $this->createComment($this->users->last()->id, $this->Article->id);
    }

    protected function createComment($userId, $articleId) : Comment
    {
        return Comment::factory()->create([
            'user_id' => $userId,
            'article_id' => $articleId,
            'number' => 1,
            'path' => '001',
        ]);
    }

    public function testIndex()
    {
        $this->actingAs($this->users->first());
        foreach ($this->users as $user){
            $CommentVote1 = CommentVote::factory()->create(['user_id' => $user->id, 'comment_id' => $this->Comment->id]);
        }
        $response = $this->getJson(route('articles.comments.vote.index', ['comment_id' =>  $this->Comment->id, 'article_id' => $this->Comment->article_id]));
        $response->assertOk();
        $response->assertJsonCount(count($this->users), 'data');
    }

    public function testStore()
    {
        $this->actingAs($this->users->first());
        $CommentVote = CommentVote::factory()->make();
        $response = $this->post(route('articles.comments.vote.store', ['comment_id' =>  $this->Comment->id, 'article_id' => $this->Comment->article_id]), $CommentVote->toArray());
        $response->assertCreated();
        $CommentVotes = CommentVote::query()
            ->where('id', $response['data']['id'])
            ->get();
        $this->assertCount(1, $CommentVotes);
    }

//    public function testShow()
//    {
//        $CommentVote = CommentVote::factory()->create(['user_id' => $this->users->first()->id, 'comment_id' => $this->Comment->id]);
//
//        $response = $this->getJson(route('comments.vote.show', $CommentVote));
//
//        $response->assertOk();
//    }
}
