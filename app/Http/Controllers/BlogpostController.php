<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    // create post
    public function store(Request $request)
    {

        $user = $request->user(); 
        $post = $user->blogPosts()->create($request->all());

        return response()->json($post, 201);
    }

    // edit post
    public function update(Request $request, $id)
    {

        $user = $request->user(); 
        $post = BlogPost::findOrFail($id);

        // Check if the authenticated user owns this post
        if ($user->id !== $post->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $post->update($request->all());

        return response()->json($post, 200);
    }

    // view post
    public function show($id)
    {
        $post = BlogPost::find($id);

        if (!$post) {
            return response()->json(['error' => 'Blog post not found'], 404);
        }

        return response()->json($post, 200);
    }

    // delete post
    public function destroy(Request $request, $id)
    {
        $user = $request->user(); 
        $post = BlogPost::findOrFail($id);

        if ($user->id !== $post->user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $post->delete();

        return response()->json(['message' => 'Blog post deleted successfully'], 200);
    }
}
