<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/locations",
     *     operationId="getLocationsList",
     *     tags={"Locations"},
     *     summary="Get list of locations",
     *     description="Returns list of all locations",
     *     @OA\Response(
     *          response=200,
     *          description="Succesful operation",
     *          @OA\JsonContent(ref="#/components/schemas/LocationResource")
     *      )
     *     )
     */
    public function index(): JsonResponse
    {
        $locations = Location::all();

        return response()->json([
            'data' => $locations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/locations",
     *     operationId="storeLocation",
     *     tags={"Locations"},
     *     summary="Store new location",
     *     description="Returns location data",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreLocationRequest")
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Location")
     *       ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(ref="#/components/schemas/Error422")
     *      ),
     * )
     */

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $location = Location::create($request->all());

        return response()->json($location, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/locations/{id}",
     *      operationId="getLocationById",
     *      tags={"Locations"},
     *      summary="Get location information",
     *      description="Returns location data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Location id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Location")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/Error404")
     *      )
     * )
     */
    public function show(Location $location): JsonResponse
    {
        return response()->json($location);
    }

    /**
     * Update the specified resource.
     *
     * @param Request $request
     * @param Location $location
     * @return JsonResponse
     *
     * @OA\Put(
     *      path="/locations/{id}",
     *      operationId="updateLocation",
     *      tags={"Locations"},
     *      summary="Update existing location",
     *      description="Returns updated location data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Location id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateLocationRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Location")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/Error404")
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(ref="#/components/schemas/Error422")
     *      ),
     * )
     */
    public function update(Request $request, Location $location): JsonResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $location->update($request->all());

        return response()->json($location, 201);
    }

}
