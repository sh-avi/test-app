<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        // Logic to create a new comment for a blog post
        // Make sure to validate $request data

        $user = $request->user(); // Authenticated user
        $commentData = $request->all();
        $commentData['blog_post_id'] = $postId; // Assuming comment belongs to a blog post

        $comment = $user->comments()->create($commentData);

        return response()->json($comment, 201);
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing comment
        // Make sure to validate $request data

        $user = $request->user(); // Authenticated user
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user owns this comment
        if ($user->id !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment->update($request->all());

        return response()->json($comment, 200);
    }

    public function show($id)
    {
        $comment = Comment::find($id);

        return response()->json($comment, 200);
    }

    public function destroy(Request $request, $id)
    {
        // Logic to delete a comment
        $user = $request->user(); // Authenticated user
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user owns this comment
        if ($user->id !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
