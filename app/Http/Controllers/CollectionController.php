<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Http\Requests\CollectionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index() : JsonResponse{
        return response()->json(
            Collection::with(['collectionType','user','lot'])->latest()->get()
        );
    }

    /**
     * @param Collection $collection
     * @return JsonResponse
     */
    public function show(Collection $collection) : JsonResponse
    {
        return response()->json($collection);
    }

    /**
     * @param CollectionRequest $request
     * @return JsonResponse
     */
    public function store(CollectionRequest $request) : JsonResponse{

        $collection = Collection::query()->create($request->validated());
       
        return response()->json($collection);
    }

    /**
     * @param Collection $collection
     * @param CollectionRequest $request
     * @return JsonResponse
     */
    public function update(Collection $collection, CollectionRequest $request) : JsonResponse{
        
        $collection->update($request->validated());
       
        return response()->json($collection);
    }

    /**
     * @param Collection $collection
     * @return JsonResponse
     */
    public function destroy(Collection $collection) : JsonResponse
    {
        $collection->delete();

        return response()->json(['ok']);
    }
}
