<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $comment_id
 * @property boolean $value
 * @property string $created_at
 * @property string $updated_at
 * @property Comment $comment
 * @property User $user
 */
class CommentVote extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['comment_id', 'user_id', 'value'];

    const VOTE_UP = 1;
    const VOTE_DOWN = -1;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->hasOne('App\Models\Comment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
