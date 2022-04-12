<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;

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

   
    public function show(Request $request) : JsonResponse
    {   
         
        $block_user_ids = DB::table('block_users')->where('user_id', $request->route('post'))->pluck('block_user_id')->toArray();
        $post_with_block_users = Post::whereNotIn('user_id', $block_user_ids)->where('group_id',1)->with(['user','group','comment.user','comment.reply.user'])->withCount(['comment','reply'])->latest()->get();

        return response()->json(
            $post_with_block_users
        );
    }

    public function getMarketPlace(Request $request) : JsonResponse
    {   
       
        $block_user_ids = DB::table('block_users')->where('user_id', $request->route('post'))->pluck('block_user_id')->toArray();
        $post_with_block_users = Post::whereNotIn('user_id', $block_user_ids)->where('group_id',2)->with(['user','group','comment','comment.user','comment.reply.user'])->withCount(['comment','reply'])->orderBy('updated_at','desc')->get();

        return response()->json(
            $post_with_block_users
        );
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
