<?php

namespace App\Http\Controllers;

use App\Models\CollectionType;
use App\Http\Requests\CollectionTypeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionTypeController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index() : JsonResponse{
        return response()->json(
            CollectionType::query()->orderBy('id','asc')->get()
        );
    }

    /**
     * @param CollectionType $collectionType
     * @return JsonResponse
     */
    public function show(CollectionType $collectionType) : JsonResponse
    {
        return response()->json($collectionType);
    }

    /**
     * @param CollectionTypeRequest $request
     * @return JsonResponse
     */
    public function store(CollectionTypeRequest $request) : JsonResponse{

        $collectionType = CollectionType::query()->create($request->validated());
       
        return response()->json($collectionType);
    }

    /**
     * @param CollectionType $collectionType
     * @param CollectionTypeRequest $request
     * @return JsonResponse
     */
    public function update(CollectionType $collectionType, CollectionTypeRequest $request) : JsonResponse{
        
        $collectionType->update($request->validated());
       
        return response()->json($collectionType);
    }

    /**
     * @param CollectionType $collectionType
     * @return JsonResponse
     */
    public function destroy(CollectionType $collectionType) : JsonResponse
    {
        $collectionType->delete();

        return response()->json(['ok']);
    }

}
