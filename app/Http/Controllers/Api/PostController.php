<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

/**
 *  A class to deal with user posts
 */
class PostController extends BaseController
{
    /**
     *  Index function to list users posts in a set of 10
     */

    public function index()
    {
        $posts = Post::with('user')->paginate(10);
        return new PostCollection($posts);
    }

    /**
     *  A function to save the user post.
     *
     * @param Object, App\Http\Request
     * @return Object, App\Http\Resources\PostResource
     */

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $request->user()->posts()->create($request->validated());
        return $this->success(new PostResource($post), 'Post created successfully', 201);
    }

    /**
     *  A function to get the user post.
     *
     * @param Object, App\Models\Post
     * @return Object, App\Http\Resources\PostResource
     */
    public function show(Post $post): JsonResponse
    {
        $post->load('user');
        return $this->success(new PostResource($post), 'Post retrieved successfully');
    }

    /**
     *  A function to update the user post.
     *
     * @param Object, App\Http\Request
     * @param Object, App\Models\Post
     * @return Object, App\Http\Resources\PostResource
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $post->update($request->validated());
        return $this->success(new PostResource($post), 'Post updated successfully');
    }

    /**
     *  A function to delete the user post.
     *
     * @param Object, App\Models\Post
     * @return String success/failure
     */
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();
        return $this->success([], 'Post deleted successfully', 204);
    }
}
