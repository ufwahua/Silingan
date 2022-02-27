<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AnnouncementRequest;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Announcement::with(['user'])->latest()->get()
        );
    }

    /**
     * @param Announcement $announcement
     * @return JsonResponse
     */
    public function show(Request $request) : JsonResponse
    {
        $announcement = Announcement::where('id',$request->route('announcement'))->with(['user'])->get();
        return response()->json($announcement);
    }

    /**
     * @param AnnouncementRequest $request
     * @return JsonResponse
     */
    public function store(AnnouncementRequest $request) : JsonResponse
    {
        $announcement = Announcement::query()->create($request->validated());

        return response()->json($announcement);
    }

    /**
     * @param Announcement        $announcement
     * @param AnnouncementRequest $request
     * @return JsonResponse
     */
    public function update(Announcement $announcement, AnnouncementRequest $request) : JsonResponse
    {
        $announcement->update($request->validated());
        //validation
    //     Announcement::query()->where('id',$request->route('announcement'))->update($request->validate([
    //         'user_id' =>['required',  Rule::exists('users', 'id')],
    //         'title' => ['required', 'max:255'],
    //         'content' => ['required'],
    //     ]));
        //no validation
    //     Announcement::query()->where('id',$request->route('announcement'))->update([
    //         'user_id' =>$request['user_id'],
    //         'title' => $request['title'],
    //         'content' => $request['content'],
    //     ]);
            //get
    //    $announcement = Announcement::query()->where('id',$request->route('announcement'))->with(['user'])->get();
        return response()->json($announcement);
    }

    /**
     * @param Announcement $announcement
     * @return JsonResponse
     */
    public function destroy(Announcement $announcement) : JsonResponse
    {
        $announcement->delete();

        return response()->json(['ok']);
    }
}
