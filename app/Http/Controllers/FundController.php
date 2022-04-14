<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Http\Requests\FundRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FundController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index() : JsonResponse{
        return response()->json(
            Fund::query()->orderBy('id','asc')->get()
        );
    }

    /**
     * @param Fund $fund
     * @return JsonResponse
     */
    public function show(Fund $fund) : JsonResponse
    {
        return response()->json($fund);
    }

    /**
     * @param FundRequest $request
     * @return JsonResponse
     */
    public function store(FundRequest $request) : JsonResponse{

        $fund = Fund::query()->create($request->validated());
       
        return response()->json($fund);
    }

    /**
     * @param Fund $fund
     * @param FundRequest $request
     * @return JsonResponse
     */
    public function update(Fund $fund, FundRequest $request) : JsonResponse{
        
        $fund->update($request->validated());
       
        return response()->json($fund);
    }

    /**
     * @param Fund $fund
     * @return JsonResponse
     */
    public function destroy(Fund $fund) : JsonResponse
    {
        $fund->delete();

        return response()->json(['ok']);
    }
}
