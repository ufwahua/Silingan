<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
     /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $posts = Post::with(['user','group','comment','comment.user','comment.reply.user'])->withCount(['comment','reply'])->latest()->get();        
        return response()->json(
            $posts
        );
        
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post) : JsonResponse
    {
        return response()->json($post);
    }

    /**
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request) : JsonResponse
    {
        $post = Post::query()->create($request->validated());

        return response()->json($post);
    }

    /**
     * @param Post        $post
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function update(Post $post, PostRequest $request) : JsonResponse
    {
        $post->update($request->validated());

        return response()->json($post);
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post) : JsonResponse
    {
        $post->delete();

        return response()->json(['ok']);
    }
}
