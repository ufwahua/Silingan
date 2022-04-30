<?php

namespace App\Http\Controllers;

use App\Models\Candidate;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CandidateRequest;

class CandidateController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
            $candidate = Candidate::with([ 'position','election','user.lot.block'])->get();
            return response()->json(
                $candidate
            );
        
    }

  
    public function show(Request $request) : JsonResponse
    {
        $candidate = Candidate::where('election_id',$request->route('candidate'))->with([ 'position','election','user.lot.block'])->get();
            return response()->json(
                $candidate
            );
    }

  
    public function store(CandidateRequest $request) : JsonResponse
    {
        $candidate = Candidate::query()->create($request->validated());

        return response()->json($candidate);
    }

   
    public function update(Request $request) : JsonResponse
    {
        Candidate::query()->where('id', $request->route('candidate'))->update($request->validate([
            'position_id'   => ['required',Rule::exists('positions', 'id')],
            'user_id'       => ['required',Rule::exists('users', 'id')],
            'election_id'   => ['required'],
            
        ]));
        return response()->json(['ok']);
    }

    
    public function destroy(Candidate $candidate) : JsonResponse
    {
        $candidate->delete();

        return response()->json(['ok']);
    }

     public function vote(Request $request): JsonResponse
    {
        // DB::table('block_users')->where('user_id', $request->route('user'))->pluck('block_user_id')->toArray();
        $candidate = Candidate::where('id',$request->route('candidate'))->first();
        Candidate::query()->where('id', $request->route('candidate'))->update([
            'vote_count' => (int)$candidate->vote_count + (int)$request['vote_count'] ,
        ]);

        return response()->json($candidate);
    }
     public function deleteAllCandidate(Request $request) : JsonResponse
    {
        Candidate::query()->where('election_id',$request->route('candidate'))->delete();

        return response()->json(['ok']);
    }
}
