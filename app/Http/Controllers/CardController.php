<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CardRequest;

class CardController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Card::query()->where('availability',1)->orderBy('number','asc')->get()
        );
    }

  
    public function show(Card $card) : JsonResponse
    {
        return response()->json($card);
    }

  
    public function store(CardRequest $request) : JsonResponse
    {
        $card = Card::query()->create($request->validated());

        return response()->json($card);
    }

   
    public function update(Card $card, CardRequest $request) : JsonResponse
    {
        $card->update($request->validated());

        return response()->json($card);
    }

    
    public function destroy(Card $card) : JsonResponse
    {
        $card->delete();

        return response()->json(['ok']);
    }
}
