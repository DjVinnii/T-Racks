<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Rack;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/racks",
     *     operationId="getRacksList",
     *     tags={"Racks"},
     *     summary="Get list of racks",
     *     description="Returns list of all racks",
     *     @OA\Response(
     *          response=200,
     *          description="Succesful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RackResource")
     *      )
     *     )
     */
    public function index(): JsonResponse
    {
        $rack = Rack::all();

        return response()->json([
            'data' => $rack
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/racks",
     *     operationId="storeRack",
     *     tags={"Racks"},
     *     summary="Store new rack",
     *     description="Returns rack data",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreRackRequest")
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Rack")
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
            'name'        => 'required',
            'height'      => 'required',
            'row_id'      => 'required',
        ]);

        $rack = Rack::create($request->all());

        return response()->json($rack, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Rack $rack
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/racks/{id}",
     *      operationId="getRackById",
     *      tags={"Racks"},
     *      summary="Get rack information",
     *      description="Returns rack data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Rack id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Rack")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/Error404")
     *      )
     * )
     */
    public function show(Rack $rack): JsonResponse
    {
        return response()->json($rack);
    }

    /**
     * Update the specified resource.
     *
     * @param Request $request
     * @param Rack $rack
     * @return JsonResponse
     *
     * @OA\Put(
     *      path="/racks/{id}",
     *      operationId="updateRack",
     *      tags={"Racks"},
     *      summary="Update existing rack",
     *      description="Returns updated rack data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Rack id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateRackRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Rack")
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
    public function update(Request $request, Rack $rack): JsonResponse
    {
//        $request->validate([
//            'name' => 'required',
//        ]);

        $rack->update($request->all());

        return response()->json($rack, 201);
    }

}
