<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $filename
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Avatar extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['filename'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
