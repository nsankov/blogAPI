<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $article_id
 * @property integer $parent_id
 * @property integer $user_id
 * @property string $content
 * @property integer $number
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Comment $comment
 * @property Article $article
 * @property CommentVote[] $commentVotes
 */
class Comment extends Model
{
    use SoftDeletes;
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['article_id', 'user_id', 'content'];
    const PATH_SEPARATOR = '.' ;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Comment', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentVotes()
    {
        return $this->hasMany('App\Models\CommentVote');
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Throwable
     */
    public static function createComment($data){

        try {
            \DB::beginTransaction();
            //ToDo moveToServiceClass
            $data['parent_id'] = $data['parent_id'] ??  NULL;
            $siblings = \DB::table('comments')
                ->select(\DB::raw('max(number) as max_number'))
                ->where('article_id', $data['article_id'])
                ->where('parent_id', $data['parent_id'])
                ->groupBy('parent_id')
                ->get()
                ->first();
            $parent = \DB::table('comments')->find($data['parent_id']);
            $parentPath = $parent ? $parent->path : false;
            $number = $siblings ? $siblings->max_number + 1 : 1;
            $newPath = $parentPath ? $parentPath . self::PATH_SEPARATOR . sprintf('%03d', $number) : sprintf('%03d', $number);

            $insertId = \DB::table('comments')->insertGetId($data + ['number' => $number, 'path' => $newPath, 'created_at' =>  now()]);
            \DB::commit();
            $result = Comment::find($insertId);
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            \DB::rollback();
            throw $e;
        }
        return $result;

    }
}
