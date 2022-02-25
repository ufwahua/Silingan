<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlockRequest;


class BlockController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Block::query()->orderBy('number','asc')->get()
        );
    }

    /**
     * @param Block $block
     * @return JsonResponse
     */
    public function show(Block $block) : JsonResponse
    {
        return response()->json($block);
    }

    /**
     * @param BlockRequest $request
     * @return JsonResponse
     */
    public function store(BlockRequest $request) : JsonResponse
    {
        $block="";
        try{
            $block = DB::table('blocks')->latest('number')->first();
        $number = $block->number;
             for($j = 0;$j<$request['number'];$j++)
            {
                $block = Block::query()->create([
                    'number' => ++$number]);
            }
        }
        catch (\Throwable $th){
            $number = 1;
             for($j = 0;$j<$request['number'];$j++)
            {
                $block = Block::query()->create([
                    'number' =>$number++]);
            }
        }

       

        return response()->json($block);
    }

    /**
     * @param Block        $block
     * @param BlockRequest $request
     * @return JsonResponse
     */
    public function update(Block $block, BlockRequest $request) : JsonResponse
    {
        $request->validate([
        'number' => ['required','integer', 'max:255','gt:0','unique:blocks' ]
        ]);
        $block->update($request->validated());

        return response()->json($block);
    }

    /**
     * @param Block $block
     * @return JsonResponse
     */
    public function destroy(Block $block) : JsonResponse
    {
        $block->delete();
        Lot::query()->where('block_id',$block['id'])->delete();
        return response()->json(['ok']);
    }
}
