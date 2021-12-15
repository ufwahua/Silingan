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
            Lot::query()->where('block_id',$lot['id'])->get()
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
    public function update(Lot $lot, LotRequest $request) : JsonResponse
    {
        $request->validate([
        'lot_number' => ['required','integer', 'max:255','gt:0','unique:blocks' ]
        ]);
        $lot->update($request->validated());

        return response()->json($lot);
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
