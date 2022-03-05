<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChatRoomRequest;

class ChatRoomController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            ChatRoom::with(['chats.user'])->latest()->get()
        );
    }

    /**
     * @param ChatRoom $chatRoom
     * @return JsonResponse
     */
    public function show(Request $request) : JsonResponse
    {

        return response()->json(
            ChatRoom::query()->where('name', $request->route('chat_room'))->with(['chats.user'])->latest()->get()
        );
    }

    /**
     * @param ChatRoomRequest $request
     * @return JsonResponse
     */
    public function store(ChatRoomRequest $request) : JsonResponse
    {
        $chatRoom = ChatRoom::query()->create($request->validated());

        return response()->json($chatRoom);
    }

    /**
     * @param ChatRoom        $chatRoom
     * @param ChatRoomRequest $request
     * @return JsonResponse
     */
    public function update(ChatRoom $chatRoom, ChatRoomRequest $request) : JsonResponse
    {
        $chatRoom->update($request->validated());

        return response()->json($chatRoom);
    }

    /**
     * @param ChatRoom $chatRoom
     * @return JsonResponse
     */
    public function destroy(ChatRoom $chatRoom) : JsonResponse
    {
        $chatRoom->delete();

        return response()->json(['ok']);
    }
}
