<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContactDetail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\EmergencyContactDetailRequest;
use Illuminate\Validation\Rule;

class EmergencyContactDetailController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            EmergencyContactDetail::with(['user'])->latest()->get()
        );
    }

    /**
     * @param EmergencyContactDetail $EmergencyContactDetail
     * @return JsonResponse
     */
    public function show(Request $request) : JsonResponse
    {
        $EmergencyContactDetail = EmergencyContactDetail::where('id',$request->route('EmergencyContactDetail'))->with(['user'])->get();
        return response()->json($EmergencyContactDetail);
    }

    /**
     * @param EmergencyContactDetailRequest $request
     * @return JsonResponse
     */
    public function store(EmergencyContactDetailRequest $request) : JsonResponse
    {
        $EmergencyContactDetail = EmergencyContactDetail::query()->create($request->validated());

        return response()->json($EmergencyContactDetail);
    }

    /**
     * @param EmergencyContactDetail        $EmergencyContactDetail
     * @param EmergencyContactDetailRequest $request
     * @return JsonResponse
     */
    public function update(EmergencyContactDetail $EmergencyContactDetail, EmergencyContactDetailRequest $request) : JsonResponse
    {
        $EmergencyContactDetail->update($request->validated());
        //validation
    //     EmergencyContactDetail::query()->where('id',$request->route('EmergencyContactDetail'))->update($request->validate([
    //         'user_id' =>['required',  Rule::exists('users', 'id')],
    //         'title' => ['required', 'max:255'],
    //         'content' => ['required'],
    //     ]));
        //no validation
    //     EmergencyContactDetail::query()->where('id',$request->route('EmergencyContactDetail'))->update([
    //         'user_id' =>$request['user_id'],
    //         'title' => $request['title'],
    //         'content' => $request['content'],
    //     ]);
            //get
    //    $EmergencyContactDetail = EmergencyContactDetail::query()->where('id',$request->route('EmergencyContactDetail'))->with(['user'])->get();
        return response()->json($EmergencyContactDetail);
    }

    /**
     * @param EmergencyContactDetail $EmergencyContactDetail
     * @return JsonResponse
     */
    public function destroy(EmergencyContactDetail $EmergencyContactDetail) : JsonResponse
    {
        $EmergencyContactDetail->delete();

        return response()->json(['ok']);
    }
}
