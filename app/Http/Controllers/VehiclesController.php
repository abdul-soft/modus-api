<?php

namespace App\Http\Controllers;

use App\Services\VehicleService;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{

    /**
     * @var VehicleService
     */
    protected $vehicleService;

    /**
     * Create a new controller instance.
     *
     * @param VehicleService $vehicleService
     */
    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * To Get Vehicles List
     *
     * @param Request $request
     * @param null $modelYear
     * @param null $manufacturer
     * @param null $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVehicles(Request $request, $modelYear = null, $manufacturer = null, $model = null)
    {
        return response()->json($this->vehicleService->getVehicles($modelYear, $manufacturer, $model, $request));
    }


    /**
     * Post Request to get Vehicles List
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postVehicles(Request $request)
    {
        return response()->json($this->vehicleService->getVehicles($request->get('modelYear'),
            $request->get('manufacturer'), $request->get('model'), $request));
    }
}
