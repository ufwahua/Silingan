<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PositionRequest;

class PositionController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Position::all()
        );
    }

  
    public function show(Position $position) : JsonResponse
    {
        return response()->json($position);
    }

  
    public function store(PositionRequest $request) : JsonResponse
    {
        $position = Position::query()->create($request->validated());

        return response()->json($position);
    }

   
    public function update(Position $position, PositionRequest $request) : JsonResponse
    {
        $position->update($request->validated());

        return response()->json($position);
    }

    
    public function destroy(Position $position) : JsonResponse
    {
        $position->delete();

        return response()->json(['ok']);
    }
}

