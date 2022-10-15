<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $article_id
 * @property boolean $value
 * @property string $created_at
 * @property string $updated_at
 * @property Article $article
 * @property User $user
 */
class ArticleVote extends Model
{
    const VOTE_UP = 1;
    const VOTE_DOWN = -1;

    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['article_id', 'user_id', 'value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
