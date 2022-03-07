<?php

namespace App\Http\Controllers;

use App\Models\Candidate;


use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CandidateRequest;

class CandidateController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
            $candidate = Candidate::with(['user', 'position'])->get();
            return response()->json(
                $candidate
            );
        
    }

  
    public function show(Candidate $candidate) : JsonResponse
    {
        return response()->json($candidate);
    }

  
    public function store(CandidateRequest $request) : JsonResponse
    {
        $candidate = Candidate::query()->create($request->validated());

        return response()->json($candidate);
    }

   
    public function update(Candidate $candidate, CandidateRequest $request) : JsonResponse
    {
        $candidate->update($request->validated());

        return response()->json($candidate);
    }

    
    public function destroy(Candidate $candidate) : JsonResponse
    {
        $candidate->delete();

        return response()->json(['ok']);
    }
}
