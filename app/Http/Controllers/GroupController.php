<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\GroupRequest;

class GroupController extends Controller
{
   
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Group::all()
        );
    }

  
    public function show(Group $group) : JsonResponse
    {
        return response()->json($group);
    }

  
    public function store(GroupRequest $request) : JsonResponse
    {
        $group = Group::query()->create($request->validated());

        return response()->json($group);
    }

   
    public function update(Group $group, GroupRequest $request) : JsonResponse
    {
        $group->update($request->validated());

        return response()->json($group);
    }

    
    public function destroy(Group $group) : JsonResponse
    {
        $group->delete();

        return response()->json(['ok']);
    }
}
