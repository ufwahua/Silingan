<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChatRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChatRoomRequest;
use Illuminate\Database\Query\Builder;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            Chat::with(['chat_room'])->latest()->get()
        );
    }

    /**
     * @param Chat $chat
     * @return JsonResponse
     */
    public function show(Chat $chat): JsonResponse
    {

        return response()->json($chat);
    }


    public function store(Request $request): JsonResponse
    {
        if ($chat_room = DB::table('chat_rooms')
            ->where('name', $request['user_id'] . " " . Auth::id())
            ->orWhere('name', Auth::id() . " " . $request['user_id'])
            ->first()
        ) {
            $message = Chat::query()->create([
                "chat_room_id" => $chat_room->id,
                "user_id" => Auth::id(),
                "message" => $request['message'],
                "read" => $request['read'],
            ]);
        } else {
            $chat_room = ChatRoom::query()->create([
                "name" => $request['user_id'] . " " . Auth::id(),
            ]);
            $message =  Chat::query()->create([
                "chat_room_id" => $chat_room->id,
                "user_id" => Auth::id(),
                "message" => $request['message'],
                 "read" => $request['read'],
                 
            ]);
        }
        $r = request();
        broadcast(new NewChatMessage($message))->toOthers();
        // return response()->json(ChatRoom::with(['chats' => function ( $query){
        //     $query->orderBy('created_at','desc');
        // },'chats.user'])->withCount([
        //     'chats', 
        //     'chats as chat_read_count' => function ( $query) {
        //         $query->where('read', 0);
        //          $query->whereIn('user_id', [Auth::id()]);
        //     }
        // ])
        // ->where('id',$chat_room->id) 
        // ->get());
        return response()->json(ChatRoom::with(['chats' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'chats.user'])
            ->where('id', $chat_room->id)
            ->get());
    }
    /**
     * @param Chat        $chat
     * @param ChatRequest $request
     * @return JsonResponse
     */
    public function update(Chat $chat, ChatRequest $request): JsonResponse
    {
        $chat->update($request->validated());

        return response()->json($chat);
    }

    /**
     * @param Chat $chat
     * @return JsonResponse
     */
    public function destroy(Chat $chat): JsonResponse
    {


        $chat->delete();
        // $chats = ChatRoom::with(['chats' => function ( $query){
        //     $query->orderBy('created_at','desc');
        // },'chats.user'])->withCount([
        //     'chats', 
        //     'chats as chat_read_count' => function ( $query) {
        //         $query->where('read', 0);
        //          $query->whereNotIn('user_id', [Auth::id()]);
        //     }
        // ])
        // ->where('id',$chat['chat_room_id']) 
        // ->get();
        $chats = ChatRoom::with(['chats' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'chats.user'])
            ->where('id', $chat['chat_room_id'])
            ->get();
        return response()->json($chats);
        return response()->json($chats);
    }
}
