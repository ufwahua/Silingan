<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Lot;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\LotRequest;

class LotController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Lot::query()->orderBy('block_id','asc')->orderBy('lot_number','asc')->get()
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
    */
    public function show(Request $request) : JsonResponse
    {
            return response()->json(  
                DB::table('lots')->where('block_id' , $request->route('lot'))->orderBy('block_id','asc')->orderBy('lot_number','asc')->get()
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
            $lot = DB::table('lots')->where('block_id',$request['block_id'])->orderBy('lot_number','desc')->first();
            $lot_number = $lot->lot_number;
             for($j = 0;$j<$request['lot_number'];$j++)
            {
                $lot = Lot::query()->create([
                    'block_id' => $request['block_id'],
                    'lot_number' => ++$lot_number]);
            }

             $return=[
                'lot' => $lot,
                'return' => $lot_number
            ];
        }
        catch (\Throwable $th){
            $lot_number = 1;
             for($j = 0;$j<$request['lot_number'];$j++)
            {
                $lot = Lot::query()->create([
                    'block_id' => $request['block_id'],
                    'lot_number' =>$lot_number++]);
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
            if($lt['lot_number'] === (int)$request['lot_number']){
                $found = true;
                break;
            }
        }
       if(!$found){
            Lot::query()->where('id',$request->route('lot'))->update( $request->validate([
            'lot_number' => ['required','integer', 'max:255','gt:0']
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
        // Lot::query()->where('block_id',$request['block_id'])->where('lot_number',$request['lot_number'])->delete();
        return response()->json(['ok']);
    }
}
