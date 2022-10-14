<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\APIv1\AvatarUploadRequest;
use App\Http\Resources\APIv1\AvatarResource;
use App\Models\Avatar;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\AvatarService;

class AvatarController extends ApiController
{
    protected $avatarService;
    public function __construct(AvatarService $avatarService){
        $this->avatarService = $avatarService;
    }

    public function show(User $user){
        $avatar = $this->avatarService->getByUserId($user->id);
        return new AvatarResource($avatar);
    }

    public function store(AvatarUploadRequest $request)
    {
        $avatar = $this->avatarService->uploadToCloud($request->validated()['avatar'], auth()->id());
        return new AvatarResource($avatar);
    }


    public function destroy(Avatar $avatar)
    {
        $avatar = $this->avatarService->delete($avatar);
        return response()->noContent();
    }
}
