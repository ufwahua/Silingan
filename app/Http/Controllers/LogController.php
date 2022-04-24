<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\LogRequest;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Log::with(['card','user_login','user_logout','lot.block'])->get()
        );
    }
    public function filterFromTo(Request $request) : JsonResponse
    {
   
        return response()->json(
            Log::whereDate('created_at','>=', date('Y-m-d',strtotime($request['from']. '+ 1 days')))
                ->whereDate('created_at','<=', date('Y-m-d',strtotime($request['to']. '+ 1 days')))
                ->whereDate('updated_at','>=', date('Y-m-d',strtotime($request['from']. '+ 1 days')))
                ->whereDate('updated_at','<=', date('Y-m-d',strtotime($request['to']. '+ 1 days')))
                ->with(['card','user_login','user_logout','lot.block'])->get()          
        );
    }
    public function show(Log $log) : JsonResponse
    {
        return response()->json($log);
    }

  
    public function store(Request $request) : JsonResponse
    {
         $request = request();
         if($request['log_type'] == 'visitor'){
            $request->validate([
                'user_login_id' => ['sometimes',Rule::exists('users', 'id')],
                'card_id' => ['required',Rule::exists('cards', 'id')],
                'block_lot_id' => ['required',Rule::exists('lots', 'id')],
                'log_type' => ['required'],
                'purpose_visit' => ['required'],
                'name' => ['required'],  
               
            ]);
                $log = Log::query()->create([
                'name'                   => $request['name'],
                'user_login_id'                 => $request['user_login_id'],
                'card_id'              => $request['card_id'],
                'block_lot_id'            => $request['block_lot_id'],
                'log_type'             => $request['log_type'],
                'purpose_visit'                => $request['purpose_visit'],
               
                
            ]);   
         }else{
              $request->validate([
                'user_login_id' => ['sometimes',Rule::exists('users', 'id')],
                'card_id' => ['required',Rule::exists('cards', 'id')],
                'block_lot_id' => ['required',Rule::exists('lots', 'id')],
                'log_type' => ['required'],
                'purpose_visit' => ['required'],
                'plate_number' => ['required'],  
                'vehicle_type' => ['required'],  
                'vehicle_tag' => ['required'],  
               
            ]);
                $log = Log::query()->create([
                'plate_number'                   => $request['plate_number'],
                'vehicle_type'                   => $request['vehicle_type'],
                'vehicle_tag'                   => $request['vehicle_tag'],
                'user_login_id'                 => $request['user_login_id'],
                'card_id'              => $request['card_id'],
                'block_lot_id'            => $request['block_lot_id'],
                'log_type'             => $request['log_type'],
                'purpose_visit'                => $request['purpose_visit'],
               
                
            ]);   
         }
   

        Card::query()->where('id',$request['card_id'])->update([
            'availability' => 0,
        ]);

        return response()->json($log);
    }

   
    public function update(Request $request) : JsonResponse
    {
        $request = request();
         if($request['log_type'] == 'visitor'){
            $request->validate([
               
                'card_id' => ['required',Rule::exists('cards', 'id')],
                'block_lot_id' => ['required',Rule::exists('lots', 'id')],
                'log_type' => ['required'],
                'purpose_visit' => ['required'],
                'name' => ['required'],  
                
            ]);
                $log = Log::query()->where('id',$request->route('log'))->update([
                'name'                   => $request['name'],
                'user_logout_id'                 => $request['user_logout_id'],
                'user_login_id'                 => $request['user_login_id'],
                'card_id'              => $request['card_id'],
                'block_lot_id'            => $request['block_lot_id'],
                'log_type'             => $request['log_type'],
                'purpose_visit'                => $request['purpose_visit'],
               
                
            ]);   
         }
         else{
              $request->validate([
               
                'card_id' => ['required',Rule::exists('cards', 'id')],
                'block_lot_id' => ['required',Rule::exists('lots', 'id')],
                'log_type' => ['required'],
                'purpose_visit' => ['required'],
                'plate_number' => ['required'],  
                'vehicle_type' => ['required'],  
                'vehicle_tag' => ['required'],  
               
            ]);
                $log = Log::query()->where('id',$request->route('log'))->update([
                'user_logout_id'                 => $request['user_logout_id'],
                'user_login_id'                 => $request['user_login_id'],
                'card_id'              => $request['card_id'],
                'block_lot_id'            => $request['block_lot_id'],
                'log_type'             => $request['log_type'],
                'purpose_visit'                => $request['purpose_visit'],
                'plate_number'                   => $request['plate_number'],
                 'vehicle_type'                   => $request['vehicle_type'],
                'vehicle_tag'                   => $request['vehicle_tag'],
                
            ]);   
         }
       
        Card::query()->where('id',$request['card_id'])->update([
            'availability' => 1,
        ]);
        return response()->json($log);
    }


    public function destroy(Log $log) : JsonResponse
    {
        $log->delete();
       
        return response()->json(['ok']);
    }
}
