<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ElectionRequest;

class ElectionController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Election::all()
        );
    }
    public function show(Election $election) : JsonResponse
    {
        return response()->json($election);
    }
    public function store(ElectionRequest $request) : JsonResponse
    {
        $election = Election::query()->create($request->validated());

        return response()->json($election);
    }
    public function update(Election $election, ElectionRequest $request) : JsonResponse
    {
        $election->update($request->validated());

        return response()->json($election);
    }
    public function destroy(Election $election) : JsonResponse
    {
        $election->delete();

        return response()->json(['ok']);
    }
}
