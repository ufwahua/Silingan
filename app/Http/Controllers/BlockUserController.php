<?php

namespace App\Http\Controllers;

use App\Models\BlockUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\BlockUserRequest;

class BlockUserController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
            $blockUser = BlockUser::with(['block_user'])->get();
            return response()->json(
                $blockUser
            );
        
    }

  
    public function show(Request $request) : JsonResponse
    {
        $blockUser = BlockUser::where('user_id',$request->route('block_user'))->with(['block_user'])->get();
        return response()->json($blockUser);
    }

  
    public function store(BlockUserRequest $request) : JsonResponse
    {
        $blockUser = BlockUser::query()->create($request->validated());

        return response()->json($blockUser);
    }

   
    public function update(BlockUser $blockUser, BlockUserRequest $request) : JsonResponse
    {
        $blockUser->update($request->validated());

        return response()->json($blockUser);
    }

    
    public function destroy(BlockUser $blockUser) : JsonResponse
    {
        $blockUser->delete();

        return response()->json(['ok']);
    }
}
