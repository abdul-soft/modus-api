<?php
/**
 * @SWG\Swagger(
 *   schemes={"https"},
 *   @SWG\Info(
 *     title="Modus Vehicles Api",
 *     description="In modus vehicle api you can check vehicles by the year, manufacturer and model. api has two endponts to get a list of vehicles.",
 *     version="0.1"
 *   )
 * )
 * @SWG\Definition(
 *     definition="VehiclesResponse",
 *     @SWG\Property(
 *         property="Count",
 *         type="integer",
 *         description="number of records of vehicles",
 *     ),
 *     @SWG\Property(
 *         property="Results",
 *         type="array",
 *         description="List of Vehicles",
 *         @SWG\Items(
 *                  @SWG\Property(
 *                      property="Description",
 *                      type="string",
 *                  ),
 *                  @SWG\Property(
 *                      property="VehicleId",
 *                      type="integer",
 *                  )
 *         )
 *     )
 * )
 **/
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
     *
     * @SWG\Get(
     *     path="/vehicles/{modelYear}/{manufacturer}/{model}",
     *     tags={"vehicles"},
     *     operationId="vehicles",
     *     summary="Get List of Vehicles by Get Request",
     *     description="Get a list of vehicles by model year, manufacturer and model",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="modelYear",
     *         in="path",
     *         description="Model Year of a vehicle",
     *         type="string",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="manufacturer",
     *         in="path",
     *         description="Manufacturer of a vehicle",
     *         type="string",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="model",
     *         in="path",
     *         description="Model of a vehicle",
     *         type="string",
     *         required=true
     *     ),
     *     @SWG\Parameter(
     *         name="withRating",
     *         in="query",
     *         description="to get rating of vehicle set this param to true",
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *         @SWG\Schema(ref="#/definitions/VehiclesResponse")
     *     )
     * )
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
     *
     * @SWG\POST(
     *     path="/vehicles",
     *     tags={"vehicles"},
     *     operationId="showVehicles",
     *     summary="Get List of Vehicles by post Request",
     *     description="Get a list of vehicles by model year, manufacturer and model",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="modelYear",
     *                  description="Model Year of a vehicle",
     *                  type="string",
     *              ),
     *              @SWG\Property(
     *                  property="manufacturer",
     *                  description="Manufacturer of a vehicle",
     *                  type="string",
     *              ),
     *              @SWG\Property(
     *                  property="model",
     *                  description="Model of a vehicle",
     *                  type="string",
     *              )
     *          )
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *         @SWG\Schema(ref="#/definitions/VehiclesResponse")
     *     )
     * )
     */
    public function postVehicles(Request $request)
    {
        return response()->json($this->vehicleService->getVehicles($request->get('modelYear'),
            $request->get('manufacturer'), $request->get('model'), $request));
    }
}
