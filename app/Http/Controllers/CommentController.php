<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Comment::with(['post','user','reply'])->latest()->get()
        );
    }

    /**
     * @param Comment $comment
     * @return JsonResponse
     */
    public function show(Comment $comment) : JsonResponse
    {
        return response()->json($comment);
    }

    /**
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function store(CommentRequest $request) : JsonResponse
    {
        $comment = Comment::query()->create($request->validated());

        return response()->json($comment);
    }

    /**
     * @param Comment        $comment
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function update(Comment $comment, CommentRequest $request) : JsonResponse
    {
        $comment->update($request->validated());

        return response()->json($comment);
    }

    /**
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Request $request) : JsonResponse
    {
       
        
    
        $reply = DB::table('replies')->where('comment_id', $request->route('comment'))->pluck('id')->toArray();
        Reply::whereIn('comment_id', $reply)->delete();
        Comment::where('post_id',$request->route('comment'))->delete();

        return response()->json(['ok']);
    }
}
