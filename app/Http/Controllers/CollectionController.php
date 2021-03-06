<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CollectionRequest;

class CollectionController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index() : JsonResponse{
        return response()->json(
            Collection::with(['collectionType','user','lot.block','fund'])->latest()->get()
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
    public function getCollectionBlockLot(Request $request) : JsonResponse
    {
        $collection = Collection::where('block_lot_id',$request->route('collection'))->with(['lot.block','collectionType','user'])->latest()->get();
        return response()->json($collection);
    }
    public function getAllCollection(Request $request) : JsonResponse
    {
        $collection = Collection::where('collection_type_id',1)->with(['lot.block','collectionType','user'])->latest()->get();
        return response()->json($collection);
    }
    /**
     * @param CollectionRequest $request
     * @return JsonResponse
     */
    public function store(CollectionRequest $request) : JsonResponse{
        $invoices = Invoice::where('block_lot_id',$request['block_lot_id'])->where('payment',false)->where('collection_type_id',$request['collection_type_id'])->latest()->get();
        foreach($invoices as $invoice){
            if($invoice->running_balance > $request['amount']){
                Invoice::query()->where('id',$invoice->id)->update([
                    'running_balance'           => $invoice->running_balance - $request['amount'], 
                ]);
            }else{
                 Invoice::query()->where('id',$invoice->id)->update([
                    'running_balance'   => 0, 
                    'payment'           => true, 
                ]);
        }       
        }
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
