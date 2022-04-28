<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Http\Requests\ExpenseTypeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index() : JsonResponse{
        return response()->json(
            ExpenseType::query()->orderBy('id','asc')->get()
        );
    }

    /**
     * @param ExpenseType $expensetype
     * @return JsonResponse
     */
    public function show(ExpenseType $expensetype) : JsonResponse
    {
        return response()->json($expensetype);
    }

    /**
     * @param ExpenseTypeRequest $request
     * @return JsonResponse
     */
    public function store(ExpenseTypeRequest $request) : JsonResponse{

        $expensetype = ExpenseType::query()->create($request->validated());
       
        return response()->json($expensetype);
    }

    /**
     * @param ExpenseType $expensetype
     * @param ExpenseTypeRequest $request
     * @return JsonResponse
     */
    public function update(ExpenseType $expensetype, ExpenseTypeRequest $request) : JsonResponse{
        
        $expensetype->update($request->validated());
       
        return response()->json($expensetype);
    }

    /**
     * @param ExpenseType $expensetype
     * @return JsonResponse
     */
    public function destroy(ExpenseType $expensetype) : JsonResponse
    {
        $expensetype->delete();

        return response()->json(['ok']);
    }
}
