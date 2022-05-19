<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\CollectionType;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InvoiceRequest;

class InvoiceController extends Controller
{
   public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Invoice::with(['user','lot.block','collection_type'])->latest()->get()
        );
    }

    public function show(Request $request) : JsonResponse
    {
       
       $invoice = Invoice::where('block_lot_id',$request->route('invoice'))->with(['user','lot.block','collection_type'])->latest()->first();
    
        return response()->json($invoice);
    }
    public function getInvoicesBlockLot(Request $request) :JsonResponse{
      
        $invoice = Invoice::where('block_lot_id',$request->route('invoice'))->with(['user','lot.block','collection_type'])->latest()->get();
        return response()->json($invoice);
    }
    public function store(InvoiceRequest $request) : JsonResponse
    {
        $invoice = Invoice::query()->create($request->validated());

        return response()->json($invoice);
    }
    public function billToAll(Request $request) : JsonResponse
    {
        $lots = DB::table('lots')->where('active',1)->pluck('id')->toArray();
        $request->validate([
            'user_id_from'              => ['required', Rule::exists('users', 'id')],
            'collection_type_id'        => ['required', Rule::exists('collection_types','id')],
            'due_date'                  => ['required'],
                
        ]);
        foreach($lots as $lot){     
            $last_invoice = Invoice::where('block_lot_id', $lot)->latest()->first();
            $collection = CollectionType::where('id',$request['collection_type_id'])->first();
            if($last_invoice){
                
                Invoice::query()->create([
                    'user_id_from'              => $request['user_id_from'],
                    'collection_type_id'        => $request['collection_type_id'],
                    'block_lot_id'              => $lot,
                    'due_date'                  => $request['due_date'],
                    'running_balance'           => $last_invoice->running_balance + $collection->amount,
                    'over_due'                  => $last_invoice->running_balance,
                ]);
            }else{
                Invoice::query()->create([
                    'user_id_from'              => $request['user_id_from'],
                    'collection_type_id'        => $request['collection_type_id'],
                    'block_lot_id'              => $lot,
                    'due_date'                  => $request['due_date'],
                    'running_balance'           => $collection->amount,
    
                ]);
            }
            
        }

        return response()->json($last_invoice);
    }

    public function billSpecificBlockLot(Request $request) : JsonResponse
    {
         $request->validate([
            'user_id_from'              => ['required', Rule::exists('users', 'id')],
            'collection_type_id'        => ['required', Rule::exists('collection_types','id')],
            'block_lot_id'              => ['required', Rule::exists('lots','id')],
            'due_date'                  => ['required'],
                
        ]);
        $last_invoice = Invoice::where('block_lot_id', $request['block_lot_id'])->latest()->first();
        if($last_invoice){
            $collection = CollectionType::where('id',$request['collection_type_id'])->first();
            Invoice::query()->create([
                'user_id_from'              => $request['user_id_from'],
                'collection_type_id'        => $request['collection_type_id'],
                'block_lot_id'              => $request['block_lot_id'],
                'due_date'                  => $request['due_date'],
                'running_balance'           => $last_invoice->running_balance + $collection->amount,
                'over_due'                  => $last_invoice->running_balance,
            ]);
        }else{
            Invoice::query()->create([
                'user_id_from'              => $request['user_id_ from'],
                'collection_type_id'        => $request['collection_type_id'],
                'block_lot_id'              => $request['block_lot_id'],
                'due_date'                  => $request['due_date'],
            ]);
        }

       return response()->json($last_invoice);
    }

    public function update(Invoice $invoice, InvoiceRequest $request) : JsonResponse
    {
        $invoice->update($request->validated());

        return response()->json($invoice);
    }
    
    public function destroy(Invoice $invoice) : JsonResponse
    {
        $invoice->delete();

        return response()->json(['ok']);
    }
}
