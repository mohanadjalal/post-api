<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CommentsResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends  BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $comments = Comment::with(['user'])->where('post_id' , $post->id)->orderBy('created_at' , "desc")->get() ; 
        return $this->sendResponse(CommentsResource::collection($comments), 'comments list');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => "required|numeric",
            "text" => "required|string",
        ]);
        $comment = Comment::create(['text' => $request->text, 'user_id' => auth()->user()->id, 'post_id' => $request->post_id,]);

        return $this->sendResponse(new CommentsResource($comment), 'comment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return $this->sendResponse(new CommentsResource($comment), 'comment ');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        if (auth()->user()->id !== $comment->user_id) {
            return $this->sendError("you are not authorized to do this action ", ['error' => 'not authorized'], 403);
        }
        $validated = $request->validate([
            "text" => "required|string",
        ]);

        $comment->update($validated);
        return $this->sendResponse(new CommentsResource($comment), 'comment ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if (auth()->user()->id !== $comment->user_id) {
            return $this->sendError("you are not authorized to do this action ", ['error' => 'not authorized'], 403);
        }
        $comment->delete();
        return $this->sendResponse(new CommentsResource($comment), 'comment ');;
    }
}
