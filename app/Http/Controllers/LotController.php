<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\LotRequest;

class LotController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Lot::with(['block'])->orderBy('block_id','asc')->get()
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
    */
    public function show(Request $request) : JsonResponse
    {
            return response()->json(  
                DB::table('lots')->where('block_id' , $request->route('lot'))->orderBy('block_id','asc')->orderBy('number','asc')->get()
        );
    }

    /**
     * @param LotRequest $request
     * @return JsonResponse
     */
    public function store(LotRequest $request) : JsonResponse
    {
        $lot="";
        try{    
            $lot = DB::table('lots')->where('block_id',$request['block_id'])->orderBy('number','desc')->first();
            $number = $lot->number;
             for($j = 0;$j<$request['number'];$j++)
            {
                $lot = Lot::query()->create([
                    'block_id' => $request['block_id'],
                    'number' => ++$number]);
            }

             $return=[
                'lot' => $lot,
                'return' => $number
            ];
        }
        catch (\Throwable $th){
            $number = 1;
             for($j = 0;$j<$request['number'];$j++)
            {
                $lot = Lot::query()->create([
                    'block_id' => $request['block_id'],
                    'number' =>$number++]);
            }
            $return=[
                'lot' => $lot,
                'return' => "catch"
            ];
        }

       

        return response()->json($return);
    }

    /**
     * @param Lot        $lot
     * @param LotRequest $request
     * @return JsonResponse
     */

      public function update(Request $request ) : JsonResponse
    {
        $found = false;
        $lots =  Lot::query()->where('block_id',$request['block_id'])->get();
        $lots = json_decode($lots, true);
        foreach ($lots as $lt) // find lot number duplicate
        {
            if($lt['number'] === (int)$request['number']){
                $found = true;
                break;
            }
        }
       if(!$found){
            Lot::query()->where('id',$request->route('lot'))->update( $request->validate([
            'number' => ['required','integer', 'max:255','gt:0']
            ]));
            $lot = Lot::findOrFail($request->route('lot'));
            return response()->json($lot);
       }
        return response()->json("The lot number has already been taken. ",404);
     
      
      
        
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
