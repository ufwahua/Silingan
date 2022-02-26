<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ReplyRequest;

class ReplyController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Reply::with(['comment','user'])->latest()->get()
        );
    }

    /**
     * @param Reply $reply
     * @return JsonResponse
     */
    public function show(Reply $reply) : JsonResponse
    {
        return response()->json($reply);
    }

    /**
     * @param ReplyRequest $request
     * @return JsonResponse
     */
    public function store(ReplyRequest $request) : JsonResponse
    {
        $reply = Reply::query()->create($request->validated());

        return response()->json($reply);
    }

    /**
     * @param Reply        $reply
     * @param ReplyRequest $request
     * @return JsonResponse
     */
    public function update(Reply $reply, ReplyRequest $request) : JsonResponse
    {
        $reply->update($request->validated());

        return response()->json($reply);
    }

    /**
     * @param Reply $reply
     * @return JsonResponse
     */
    public function destroy(Reply $reply) : JsonResponse
    {
        $reply->delete();

        return response()->json(['ok']);
    }
}
