<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\NotificationRequest;

class NotificationController extends Controller
{
     /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse{
        return response()->json(
            Notification::latest()->get()
        );
    }

    /**
     * @param Notification $notification
     * @return JsonResponse
     */
    public function show(Notification $notification) : JsonResponse
    {
        return response()->json($notification);
    }

    /**
     * @param NotificationRequest $request
     * @return JsonResponse
     */
    public function store(NotificationRequest $request) : JsonResponse
    {
        $notification = Notification::query()->create($request->validated());

        return response()->json($notification);
    }

    /**
     * @param Notification        $notif
     * @param NotificationRequest $request
     * @return JsonResponse
     */
    public function update(Request $request) : JsonResponse
    {
        $notification = Notification::query()->where("id",$request->route('notification'))->update([
            'viewed' => 1,
         ]);

        return response()->json($notification);
    }
    public function notificationChat(Request $request) : JsonResponse
    {
        $chats = ChatRoom::with(['chats' => function ( $query){
            
            $query->orderBy('created_at','desc');
        },'chats.user'])->withCount([
        'chats', 
        'chats as chat_read_count' => function ( $query) {
            $query->where('read', 0);
        }
        ])
        ->where('id',$chat_room->id) 
        ->get();

        return response()->json($chats);
    }
}
