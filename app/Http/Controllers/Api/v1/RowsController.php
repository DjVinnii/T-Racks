<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Row;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RowsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/rows",
     *     operationId="getRowsList",
     *     tags={"Rows"},
     *     summary="Get list of rows",
     *     description="Returns list of all rows",
     *     @OA\Response(
     *          response=200,
     *          description="Succesful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RowResource")
     *      )
     *     )
     */
    public function index(): JsonResponse
    {
        $rows = Row::all();

        return response()->json([
            'data' => $rows
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/rows",
     *     operationId="storeRow",
     *     tags={"Rows"},
     *     summary="Store new row",
     *     description="Returns row data",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreRowRequest")
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Row")
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
            'location_id' => 'required',
        ]);

        $row = Row::create($request->all());

        return response()->json($row, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Row $row
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/rows/{id}",
     *      operationId="getrowById",
     *      tags={"Rows"},
     *      summary="Get row information",
     *      description="Returns row data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Row id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Row")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/Error404")
     *      )
     * )
     */
    public function show(Row $row): JsonResponse
    {
        return response()->json($row);
    }

    /**
     * Update the specified resource.
     *
     * @param Request $request
     * @param Row $row
     * @return JsonResponse
     *
     * @OA\Put(
     *      path="/rows/{id}",
     *      operationId="updateRow",
     *      tags={"Rows"},
     *      summary="Update existing rows",
     *      description="Returns updated rows data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Row id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateRowRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Row")
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
    public function update(Request $request, Row $row): JsonResponse
    {
//        $request->validate([
//            'name' => 'required',
//        ]);

        $row->update($request->all());

        return response()->json($row, 201);
    }

}
