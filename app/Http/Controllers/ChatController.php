<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChatRequest;

class ChatController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Chat::with(['chat_room'])->latest()->get()
        );
    }

    /**
     * @param Chat $chat
     * @return JsonResponse
     */
    public function show(Chat $chat) : JsonResponse
    {
        return response()->json($chat);
    }

    /**
     * @param ChatRequest $request
     * @return JsonResponse
     */
    public function store(ChatRequest $request) : JsonResponse
    {
        $chat = Chat::query()->create($request->validated());

        return response()->json($chat);
    }

    /**
     * @param Chat        $chat
     * @param ChatRequest $request
     * @return JsonResponse
     */
    public function update(Chat $chat, ChatRequest $request) : JsonResponse
    {
        $chat->update($request->validated());

        return response()->json($chat);
    }

    /**
     * @param Chat $chat
     * @return JsonResponse
     */
    public function destroy(Chat $chat) : JsonResponse
    {
        $chat->delete();

        return response()->json(['ok']);
    }
}
