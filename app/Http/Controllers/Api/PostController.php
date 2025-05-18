<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends BaseController
{
    public function index()
    {
        $posts = Post::with('user')->paginate(10);
        return new PostCollection($posts);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $request->user()->posts()->create($request->validated());
        return $this->success(new PostResource($post), 'Post created successfully', 201);
    }

    public function show(Post $post): JsonResponse
    {
        $post->load('user');
        return $this->success(new PostResource($post), 'Post retrieved successfully');
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $post->update($request->validated());
        return $this->success(new PostResource($post), 'Post updated successfully');
    }


    public function destroy(Post $post): JsonResponse
    {
        $post->delete();
        return $this->success([], 'Post deleted successfully', 204);
    }
}
