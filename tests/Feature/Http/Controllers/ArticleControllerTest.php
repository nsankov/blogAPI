<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\CreateArticle;
use App\Events\DeleteArticle;
use App\Events\UpdateArticle;
use App\Jobs\ProcessCheckProfanity;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;

/**
 * @see \App\Http\Controllers\ArticleController
 */
class ArticleControllerTest extends ApiTestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        $this->actingAs($this->users->first());
        $all = Article::all();
        $articles = Article::factory()->times(3)->create([
            'category_id' => $this->categories->first()->id,
            'user_id' => $this->users->first()->id,
        ]);

        $response = $this->getJson(route('articles.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $this->actingAs($this->users->first());
        $title = $this->faker->sentence(4);
        $description = $this->faker->sentence(20);
        $content = $this->faker->text;
        $user = $this->users->first();

        Queue::fake();
        Event::fake();

        $this->actingAs($user);
        $response = $this->post(route('articles.store'), [
            'title' => $title,
            'content' => $content,
            'description' => $description,
            'category_id' => $this->categories->first()->id
        ]);
        $response->assertCreated();
        $articles = Article::query()
            ->where('title', $title)
            ->where('content', $content)
            ->where('description', $description)
            ->where('category_id', $this->categories->first()->id)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $articles);
        $article = $articles->first();

        Queue::assertPushed(ProcessCheckProfanity::class, function ($job) use ($article) {
            return $job->article->is($article);
        });
        Event::assertDispatched(CreateArticle::class, function ($event) use ($article) {
            return $event->article->is($article);
        });
    }


    public function testShow()
    {
        $this->actingAs($this->users->first());
        $article = Article::factory()->create([
            'user_id' => $this->users->first()->id,
            'category_id' => $this->categories->first()->id
        ]);
        $response = $this->getJson(route('articles.show', $article));
        $response->assertOk();
        $response->assertJsonFragment(['title' => $article['title'], 'content' => $article['content']]);
    }

    public function testUpdate()
    {
        $this->actingAs($this->users->first());
        $title = $this->faker->word;
        $article = Article::factory()->create([
            'user_id' => $this->users->first()->id,
            'category_id' => $this->categories->first()->id
        ]);

        Queue::fake();
        Event::fake();

        $response = $this->put(route('articles.update', $article), [
            'title' => $title,
        ]);
        $response->assertSuccessful();

        Queue::assertPushed(ProcessCheckProfanity::class, function ($job) use ($article) {
            return $job->article->is($article);
        });
        Event::assertDispatched(UpdateArticle::class, function ($event) use ($article) {
            return $event->article->is($article);
        });
    }

    public function testDestroy()
    {
        $this->actingAs($this->users->first());

        $article = Article::factory()->create([
            'user_id' => $this->users->first()->id,
            'category_id' => $this->categories->first()->id
        ]);

        Event::fake();

        $response = $this->delete(route('articles.destroy', $article));

        $this->assertSoftDeleted($article);

        Event::assertDispatched(DeleteArticle::class, function ($event) use ($article) {
            return $event->article->is($article);
        });
    }

}
