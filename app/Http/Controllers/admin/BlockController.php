<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Block;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\BlockRequest;


class BlockController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Block::query()->orderBy('block_number','asc')->get()
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
            $block = DB::table('blocks')->latest('block_number')->first();
        $block_number = $block->block_number;
             for($j = 0;$j<$request['block_number'];$j++)
            {
                $block = Block::query()->create([
                    'block_number' => ++$block_number]);
            }
        }
        catch (\Throwable $th){
            $block_number = 1;
             for($j = 0;$j<$request['block_number'];$j++)
            {
                $block = Block::query()->create([
                    'block_number' =>$block_number++]);
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
        'block_number' => ['required','integer', 'max:255','gt:0','unique:blocks' ]
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

        return response()->json(['ok']);
    }
}
