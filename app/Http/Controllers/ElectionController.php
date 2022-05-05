<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ElectionRequest;

class ElectionController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Election::latest()->first()
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
    public function update(Request $request, ) : JsonResponse
    {
        $election = Election::query()->where('id', $request->route('election'))->update($request->validate([
            'result' => ['required'],
        ]));
        return response()->json($election);
    }
    public function updateVoters(Request $request, ) : JsonResponse
    {
        $user = User::query()->where('role', 'officer')->where('role', 'resident')->update([
            'has_voted' => 0,
        ]);
        return response()->json($user);
    }
    public function destroy(Election $election) : JsonResponse
    {
        $election->delete();

        return response()->json(['ok']);
    }
}
