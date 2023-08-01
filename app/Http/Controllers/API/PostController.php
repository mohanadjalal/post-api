<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\ProductResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return $this->sendResponse(PostResource::collection($posts), 'post list');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post  = Post::create(['title' => $request->title, 'body' => $request->body, 'user_id' => auth()->user()->id]);
        return $this->sendResponse(new PostResource($post), 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->sendResponse(new PostResource($post), ' success!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return $this->sendError("you are not authorized to do this action ", ['error' => 'not authorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'string|max:255',
            'body' => 'string'
        ]);

        $post->update($validated);
        return $this->sendResponse(new PostResource($post), 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return $this->sendError("you are not authorized to do this action ", ['error' => 'not authorized'], 403);
        }
        $post->delete();
        return $this->sendResponse(new PostResource($post), ' success!');
    }
}
