<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\APIv1\CommentStoreRequest;
use App\Http\Requests\APIv1\CommentUpdateRequest;
use App\Http\Resources\APIv1\CommentCollection;
use App\Http\Resources\APIv1\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\CommentService;

class CommentController extends ApiController
{
  public function __construct(private CommentService $service){

  }
    public function index(Request $request, $articleId)
    {
        return new CommentCollection($this->service->list($articleId));
    }

    public function store(CommentStoreRequest $request, $articleId)
    {
        $comment = $this->service->save($request->validated());
        return (new CommentResource($comment))->response()->setStatusCode(201);
    }

    public function show(Request $request, $articleId, $commentId) {
        return new CommentResource($this->service->get($commentId));
    }

    public function destroy(Request $request, $articleId, $commentId)
    {
        $this->service->delete($commentId);
        return response()->noContent();
    }
}
