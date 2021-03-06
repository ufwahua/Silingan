<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Requests\LotRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class LotController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Lot::with(['block','user'])->orderBy('number','asc')->get()
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
    */
    public function show(Request $request) : JsonResponse
    {
        $block_id = Block::where('number' , $request->route('lot'))->first()->id;
            return response()->json(  
                DB::table('lots')->where('block_id' , $block_id)->orderBy('number','asc')->get()
        );
    }

    /**
     * @param LotRequest $request
     * @return JsonResponse
     */
    public function store(LotRequest $request) : JsonResponse
    {
           $request->validate([
                    'number' => ['required','integer', 'max:255','gt:0',Rule::unique('lots')->where(function ($query) use ($request) {
                        return $query->where('block_id', $request->block_id);
                    })->ignore($request->route('lot'))],
                    'active' => ['required'], 
                ]);
        $lots = Lot::where('block_id',$request['block_id'])->get();

        $found = false;
        foreach($lots as $lot){
            if($lot['number'] == $request['number']){
                $found = true;
            }
        }
        if($found){
             return response()->json(["error"=>"The number has already been taken."],401);
        }else{
             $lot = Lot::query()->create($request->validated());

            return response()->json($lot);
        }
        // $lot="";
        // try{    
        //     $lot = DB::table('lots')->where('block_id',$request['block_id'])->orderBy('number','desc')->first();
        //     $number = $lot->number;
        //      for($j = 0;$j<$request['number'];$j++)
        //     {
        //         $lot = Lot::query()->create([
        //             'block_id' => $request['block_id'],
        //             'number' => ++$number]);
        //     }

        //      $return=[
        //         'lot' => $lot,
        //         'return' => $number
        //     ];
        // }
        // catch (\Throwable $th){
        //     $number = 1;
        //      for($j = 0;$j<$request['number'];$j++)
        //     {
        //         $lot = Lot::query()->create([
        //             'block_id' => $request['block_id'],
        //             'number' =>$number++]);
        //     }
        //     $return=[
        //         'lot' => $lot,
        //         'return' => "catch"
        //     ];
        // }

       

       
    }

    /**
     * @param Lot        $lot
     * @param LotRequest $request
     * @return JsonResponse
     */

      public function update(Request $request ) : JsonResponse
    {
       
      
            Lot::query()->where('id',$request->route('lot'))->update( $request->validate([
                    'number' => ['required','integer', 'max:255','gt:0',Rule::unique('lots')->where(function ($query) use ($request) {
                        return $query->where('block_id', $request->block_id);
                    })->ignore($request->route('lot'))],
                    'active' => ['required'],
                    'has_voted' => ['sometimes'],
                ]));
           
            return response()->json(['ok']);
      
      
        
    }
      public function vote(Request $request ) : JsonResponse
    {
       
            Lot::query()->where('id',$request->route('lot'))->update( $request->validate([
                    'has_voted' => ['sometimes'],
                ]));
           
            return response()->json(['ok']);
        
    }

    

    /**
     * @param Lot $lot
     * @return JsonResponse
     */
    public function destroy(Lot $lot) : JsonResponse
    {
        $lot->delete();
        // Lot::query()->where('block_id',$request['block_id'])->where('number',$request['number'])->delete();
        return response()->json(['ok']);
    }
}
