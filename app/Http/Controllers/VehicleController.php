<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\VehicleRequest;

class VehicleController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        return response()->json(
            Vehicle::with(['user'])->latest()->get()
        );
    }

   
    public function show(Request $request) : JsonResponse
    {
        $vehicle = Vehicle::where('user_id',$request->route('vehicle'))->with(['user'])->get();
        return response()->json($vehicle);
    }

    /**
     * @param VehicleRequest $request
     * @return JsonResponse
     */
    public function store(VehicleRequest $request) : JsonResponse
    {
        $vehicle = Vehicle::query()->create($request->validated());

        return response()->json($vehicle);
    }

    /**
     * @param Vehicle        $vehicle
     * @param VehicleRequest $request
     * @return JsonResponse
     */
    public function update(Vehicle $vehicle, VehicleRequest $request) : JsonResponse
    {
        $vehicle->update($request->validated());

        return response()->json($vehicle);
    }

    /**
     * @param Vehicle $vehicle
     * @return JsonResponse
     */
    public function destroy(Vehicle $vehicle) : JsonResponse
    {
        $vehicle->delete();

        return response()->json(['ok']);
    }
}
