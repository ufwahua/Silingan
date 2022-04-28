<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Http\Requests\ExpenseRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index() : JsonResponse{
        return response()->json(
            Expense::with(['user','fund','expenseType'])->latest()->get()
        );
    }

    /**
     * @param Expense $expense
     * @return JsonResponse
     */
    public function show(Expense $expense) : JsonResponse
    {
        return response()->json($expense);
    }

    /**
     * @param ExpenseRequest $request
     * @return JsonResponse
     */
    public function store(ExpenseRequest $request) : JsonResponse{

        $expense = Expense::query()->create($request->validated());
       
        return response()->json($expense);
    }

    /**
     * @param Expense $expense
     * @param ExpenseRequest $request
     * @return JsonResponse
     */
    public function update(Expense $expense, ExpenseRequest $request) : JsonResponse{
        
        $expense->update($request->validated());
       
        return response()->json($expense);
    }

    /**
     * @param Expense $expense
     * @return JsonResponse
     */
    public function destroy(Expense $expense) : JsonResponse
    {
        $expense->delete();

        return response()->json(['ok']);
    }
}
