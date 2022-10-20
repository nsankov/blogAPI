<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\ApiController;
use App\Models\Article;
use App\Models\User;
use App\Http\Resources\APIv1\ArticleResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\APIv1\RegisterUserRequest;

class UserController extends ApiController
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['data' => $user->makeHidden(['id', 'updated_at', 'created_at']),'access_token' => $token, 'token_type' => self::TOKEN_TYPE, ]);
    }
    public function articles()
    {
        $articles = Article::where('user_id', Auth::user()->id)
          ->with('votes')
          ->with('user')
          ->simplePaginate($this->pageSize);
        return ArticleResource::collection($articles);
    }
}
