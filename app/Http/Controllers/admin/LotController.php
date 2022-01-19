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
            Lot::query()->orderBy('block_id','asc')->get()
        );
    }

    /**
     * @param Lot $lot
     * @return JsonResponse
     */
    public function show(Lot $lot) : JsonResponse
    {
        return response()->json(
            Lot::query()->where('block_id',$lot['id'])->orderBy('block_id','asc')->get()
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
    public function update(Request $request , $id) : JsonResponse
    {
        $found = false;
        $lots =  Lot::query()->where('block_id',$request['id'])->get();
        foreach ($lots as $lot)
        {
            if($lot->lot_number === $request['lot_number']){
                $found = true;
            }
        }
       if(!$found){
            Lot::where('id', $id)
                ->update(['block_id' => $request->input('block_id'),
                         'lot_number'=>$request->input('lot_number')]);
        return response()->json($lots);
       }
      
       return response()->json("Lot number is exist");
        
    }

    /**
     * @param Lot $lot
     * @return JsonResponse
     */
    public function destroy(Lot $lot) : JsonResponse
    {
        $lot->delete();

        return response()->json(['ok']);
    }
}
