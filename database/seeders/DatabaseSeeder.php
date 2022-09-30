<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Avatar;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentVote;
use App\Models\Post;
use App\Models\PostVote;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $readUsers = User::factory(10)->create();

        Avatar::factory(5)->create();

        $categories = Category::all();
        if ($categories->count() < 10){
            $categories = Category::factory(10)->create();
        }

        User::factory(5)->create()->each(function ($user) use ($readUsers, $categories)  {
            Post::factory(rand(1, 10))->create([
                'user_id' => $user->id,
                'category_id' => $categories->random(1)->first()->id,
            ])->each(function ($post) use ($user, $readUsers) {
                PostVote::factory(rand(1, 10))->create([
                    'post_id' => $post->id,
                    'user_id' => $readUsers->random(1)->first()->id,
                ]);
                $commentsTree = function (?int $deep = 1, ?string $path = null, ?int $parentId = null) use (&$commentsTree, $post, $readUsers) {
                    if ($deep < 1) return true;
                    for ($number = 1; $number < rand(2, 10); $number++) {
                        $newPath = $path ? $path . '.' . sprintf('%03d', $number) : sprintf('%03d', $number);
                        $data = ['post_id' => $post->id, 'user_id' => $readUsers->random(1)->first()->id, 'number' => $number, 'path' => $newPath];
                        $data['parent_id'] = $parentId;
                        $comments = Comment::factory(1)->create($data)->each(function ($comment) use ($readUsers) {
                            CommentVote::factory(rand(1, 5))->create([
                                'comment_id' => $comment->id,
                                'user_id' => $readUsers->random(1)->first()->id,
                            ]);
                        });
                    }
                    $commented = $comments->random(1)->first();
                    return $commentsTree($deep - 1, $commented->path, $commented->id);
                };
                $commentsTree(3);
            });
        });
    }
}
