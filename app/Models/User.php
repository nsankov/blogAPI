<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property Avatar $avatar
 * @property CommentVote[] $commentVotes
 * @property ArticleVote[] $articleVotes
 * @property Article[] $articles
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function avatar()
    {
        return $this->hasOne('App\Models\Avatar');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentVotes()
    {
        return $this->hasMany('App\Models\CommentVote');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleVotes()
    {
        return $this->hasMany('App\Models\ArticleVote');
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
