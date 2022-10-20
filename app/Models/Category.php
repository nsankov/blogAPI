<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property Article[] $articles
 */
class Category extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['title', 'description'];


    public function articles() :HasMany
    {
        return $this->hasMany(Article::class);
    }
}
