<?php

namespace App\Services;

use \GuzzleHttp\Client;
use Illuminate\Http\Request;

class VehicleService
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * VehicleService constructor.
     *
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('NHTSA_URL'),
            'query'    => ['format' => 'json'],
        ]);;
    }

    /**
     * To Get Vehicles
     *
     * @param $modelYear
     * @param $manufacturer
     * @param $model
     * @param Request $request
     * @return array
     */
    public function getVehicles($modelYear, $manufacturer, $model, Request $request)
    {
        $withRating = $this->getWithRatingParam($request);

        $routeParams = 'modelyear/'.$modelYear.'/make/'.$manufacturer.'/model/'.$model;

        try {

            $vehicles = $this->requestNHTSA($routeParams);

        }catch (\Exception $e){
            return $this->emptyResponse();
        }

        return $this->setResponse($vehicles, $withRating);

    }


    /**
     * GET Request to NHTSA Api
     *
     * @param $routeParams
     * @return mixed
     */
    protected function requestNHTSA($routeParams)
    {
        $response = $this->client->request(
            'GET',
            $routeParams
        );

        return json_decode($response->getBody(), true);

    }


    /**
     * Empty Response for Vehicles
     *
     * @return array
     */
    protected function emptyResponse()
    {
        return [
            'Count'     =>  0,
            'Results'   =>  []
        ];
    }

    /**
     * To check if withRating is true
     *
     * @param Request $request
     * @return bool
     */
    protected function getWithRatingParam(Request $request)
    {
        return  $request->has('withRating') && $request->get('withRating') == 'true';
    }

    /**
     * @param $data
     * @param $withRating
     * @return array
     */
    protected function setResponse($data, $withRating)
    {
        if($withRating){
            return $this->withRatingResponse($data);
        }
        return $this->withOutRatingResponse($data);
    }

    /**
     * Vehicles Response
     *
     * @param $data
     * @return array
     */
    protected function withOutRatingResponse($data)
    {
        return  [
            'Count'     =>  $data['Count'],
            'Results'   =>  collect($data['Results'])->map(function($vehicle) {
                return [
                    'Description' => $vehicle['VehicleDescription'],
                    'VehicleId'   => $vehicle['VehicleId'],
                ];
            })
        ];
    }

    /**
     * Vehicle Response With Crash Ratings
     *
     * @param $data
     * @return array
     */
    protected function withRatingResponse($data)
    {
        return   [
            'Count'     =>  $data['Count'],
            'Results'   =>  collect($data['Results'])->map(function($vehicle) {
                return [
                    'CrashRating'   => $this->getCrashRating($vehicle['VehicleId']),
                    'Description'   => $vehicle['VehicleDescription'],
                    'VehicleId'     => $vehicle['VehicleId'],
                ];
            })
        ];
    }

    /**
     * Get Crash Rating For Vehicle
     *
     * @param $vehicleId
     * @return mixed
     */
    protected function getCrashRating($vehicleId)
    {
        $rating = $this->requestNHTSA('VehicleId/'.$vehicleId);

        return $rating['Results'][0]['OverallRating'];
    }

}