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
        $positions =  Position::all();
        $req = [];
        foreach ($positions as $position){
            if(strtoupper($position->name) === "PRESIDENT"){
                array_push($req,$position);
                break;
            }
        };
        foreach ($positions as $position){
            if(strtoupper($position->name) === "VICE-PRESIDENT"){
                array_push($req,$position);
                break;
            }
        };
        foreach ($positions as $position){
            if(strtoupper($position->name) === "SECRETARY"){
                array_push($req,$position);
                break;
            }
        };
        foreach ($positions as $position){
            if(strtoupper($position->name) === "TREASURER"){
                array_push($req,$position);
                break;
            }
        };
        foreach ($positions as $position){
            if(strtoupper($position->name) === "AUDITOR"){
                array_push($req,$position);
                break;
            }
        };
        foreach ($positions as $position){
            if(strtoupper($position->name) === "AUDITOR" || strtoupper($position->name) === "TREASURER" ||strtoupper($position->name) === "SECRETARY" ||strtoupper($position->name) === "VICE-PRESIDENT" ||strtoupper($position->name) === "PRESIDENT"){
                
            }
            else{
                array_push($req,$position);
            }
        };
       
        return response()->json(
           $req
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

