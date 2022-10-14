<?php


namespace Tests\Feature\Http\Controllers;


use App\Models\Category;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ApiTestCase extends TestCase
{
    protected Collection $users;
    protected Collection $categories;
    protected function setUp(): void
    {
        parent::setUp();

        $categories = Category::factory(3)->create();

        $users = User::factory(1)->create()->each(function ($user) use ($categories)  {
            Article::factory(1)->create([
                'user_id' => $user->id,
                'category_id' => $categories->first()->id,
            ]);
        });

        $this->categories = $categories;
        $this->users = $users;
    }
}
