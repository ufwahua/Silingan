<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\ChatRoom;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

   
    public function notificationChat(NotificationRequest $request) : JsonResponse
    {
        $notification = Notification::query()->create($request->validated());

        return response()->json($notification);
    }
    public function notificationComment(NotificationRequest $request) : JsonResponse
    {
        $notification = Notification::query()->create($request->validated());

        return response()->json($notification);
    }
    public function notificationAnnouncement(Request $request) : JsonResponse
    {
        $request->validate([
            'from_user_id'   => ['required', Rule::exists('users', 'id')], 
            'message'   => ['required', 'max:255'],    
            'message'   => ['required'],    
            "announcement_id" => ['required']
        ]);
        $users = User::whereNotIn('id',[Auth::id()])->get();
        foreach($users as $user){
            $notification = Notification::query()->create([
                'from_user_id'           => $request['from_user_id'],
                'to_user_id'             => $user['id'],
                'message'                => $request['message'],
                'announcement_id'        => $request['announcement_id'],
            ]);
        }
        return response()->json($notification);
    }
     public function notificationElection(Request $request) : JsonResponse
    {
        $request->validate([
            'from_user_id'   => ['required', Rule::exists('users', 'id')], 
            'message'   => ['required', 'max:255'],    
        ]);
        $users = User::whereNotIn('id',[Auth::id()])->whereNotIn('role',['security officer'])->get();
        foreach($users as $user){
            $notification = Notification::query()->create([
                'from_user_id'           => $request['from_user_id'],
                'to_user_id'             => $user['id'],
                'election_id'             => $request['election_id'],
                'message'                => $request['message'],
            ]);
        }
        return response()->json($notification);
    }
     public function notificationSecurityLog(Request $request) : JsonResponse
    {
        $request->validate([
            'from_user_id'   => ['required', Rule::exists('users', 'id')], 
            'message'   => ['required', 'max:255'],    
            'block_lot_id'   => ['required', 'max:255'],    
        ]);
        $users = User::whereIn('block_lot_id',[$request['block_lot_id']])->get();
        foreach($users as $user){
            $notification = Notification::query()->create([
                'from_user_id'           => $request['from_user_id'],
                'to_user_id'             => $user['id'],
                'message'                => $request['message'],
            ]);
        }
        return response()->json($notification);
    }
   

    /**
     * @param Notification        $notif
     * @param NotificationRequest $request
     * @return JsonResponse
     */
    public function update(Request $request) : JsonResponse
    {
        $notification_chat = DB::table('notifications')->where('to_user_id', $request->route('notification'))->pluck('chat_room_id')->toArray();
        if($notification_chat){
             Chat::query()->whereIn("chat_room_id",$notification_chat)->update([
            'read' => 1,
         ]);
        }
        Notification::query()->where("to_user_id",$request->route('notification'))->update([
            'viewed' => 1,
         ]);

        return response()->json(['ok']);
    }
   
}
