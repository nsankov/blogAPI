<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $title
 * @property string $body
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 * @property string $deleted_at
 * @property Comment[] $comments
 * @property PostVote[] $postVotes
 * @property Category $category
 * @property User $user
 */
class Post extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['category_id', 'title', 'body'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postVotes()
    {
        return $this->hasMany('App\Models\PostVote');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
