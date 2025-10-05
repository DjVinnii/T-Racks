<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRackRequest;
use App\Http\Requests\UpdateRackRequest;
use App\Http\Resources\RackResource;
use App\Models\Rack;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RackController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $name = $request->query('name');
        $locationId = $request->query('location_id');

        $query = Rack::query();

        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($locationId) {
            $query->where('location_id', $locationId);
        }

    $racks = $query->with('location')->orderBy('created_at')->paginate($perPage);

    return RackResource::collection($racks)->response();
    }

    public function store(StoreRackRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $rack = Rack::create($validated);
        $rack->location()->associate($validated['location_id'] ?? null);
        $rack->save();

        $rack->load('location');

        return response()->json(new RackResource($rack), 201);
    }

    public function show(Rack $rack): JsonResponse
    {
        $rack->load('location');

        return response()->json(new RackResource($rack));
    }

    public function update(UpdateRackRequest $request, Rack $rack): JsonResponse
    {
        $validated = $request->validated();

        $rack->update($validated);
        $rack->location()->associate($validated['location_id'] ?? null);
        $rack->save();

        return response()->json(new RackResource($rack));
    }

    public function destroy(Rack $rack): JsonResponse
    {
        $rack->delete();

        return response()->json(null, 204);
    }
}
