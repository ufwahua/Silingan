<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
            ChatRoom::with(['chats'])->latest()->get()
        );
    }

    /**
     * @param ChatRoom $chatRoom
     * @return JsonResponse
     */
    public function show(Request $request) : JsonResponse
    {

        return response()->json(
            ChatRoom::with(['chats' => function ($query){
                $query->orderBy('created_at','desc');
            },'chats.user'])
            ->where('name',$request->route('chat_room')." ".Auth::id())
            ->orWhere('name',Auth::id()." ".$request->route('chat_room'))
            ->get()
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
