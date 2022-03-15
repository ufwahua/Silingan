<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Requests\LogRequest;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Log::with(['card','user'])->get()
        );
    }

    public function show(Log $log) : JsonResponse
    {
        return response()->json($log);
    }

  
    public function store(LogRequest $request) : JsonResponse
    {
        if($log = Log::query()->create($request->validated())){
            Card::query()->where('id',$request['card_id'])->update([
                'availability' => 0,
            ]);
        };

        return response()->json($log);
    }

   
    public function update(Log $log, LogRequest $request) : JsonResponse
    {
        $log->update($request->validated());
        return response()->json($log);
    }


    public function destroy(Log $log) : JsonResponse
    {
       
        if( $log->delete()){
            Card::query()->where('id',$log['card_id'])->update([
                'availability' => 1,
            ]);
        };
        return response()->json(['ok']);
    }
}
