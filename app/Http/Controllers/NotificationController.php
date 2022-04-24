<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NotificationRequest;

class NotificationController extends Controller
{
     /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse{
        return response()->json(
            Notification::with(['from_user','to_user'])->latest()->get()
        );
    }

    /**
     * @param Notification $notification
     * @return JsonResponse
     */
    public function show(Request $request) : JsonResponse
    {
        $notification = Notification::with(['from_user','to_user'])->where('to_user_id', Auth::id())->latest()->get();
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
        $notification = DB::table('notifications')->where('to_user_id', $request->route('notification'))->pluck('chat_room_id')->toArray();
        if($notification){
             Chat::query()->whereIn("chat_room_id",$notification)->update([
            'read' => 1,
         ]);
        }
        Notification::query()->where("to_user_id",$request->route('notification'))->update([
            'viewed' => 1,
         ]);

        return response()->json($notification);
    }
   
}
