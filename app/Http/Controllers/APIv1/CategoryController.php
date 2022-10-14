<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\APIv1\CategoryStoreRequest;
use App\Http\Requests\APIv1\CategoryUpdateRequest;
use App\Http\Resources\APIv1\CategoryCollection;
use App\Http\Resources\APIv1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\Config\Resource\ClassExistenceResource;

class CategoryController extends ApiController
{

    public function index(Request $request)
    {
        $categories = Category::all();

        return new CategoryCollection($categories);
    }

    public function store(CategoryStoreRequest $request)
    {

        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    public function show(Request $request, Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        return response()->noContent();
    }

    public function top()
    {
        

        return new CategoryCollection($categories);
    }
}
