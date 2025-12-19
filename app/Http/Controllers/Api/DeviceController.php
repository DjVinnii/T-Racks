<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);
        $name = $request->query('name');
        $rackId = $request->query('rack_id');

        $query = Device::query();

        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($rackId) {
            $query->where('rack_id', $rackId);
        }

        $devices = $query->with('rack')->orderBy('created_at')->paginate($perPage);

        return DeviceResource::collection($devices)->response();
    }

    public function store(StoreDeviceRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $device = Device::create($validated);
        $device->rack()->associate($validated['rack_id'] ?? null);
        $device->save();

        $device->load('rack');

        return response()->json(new DeviceResource($device), 201);
    }

    public function show(Device $device): JsonResponse
    {
        $device->load('rack');

        return response()->json(new DeviceResource($device));
    }

    public function update(UpdateDeviceRequest $request, Device $device): JsonResponse
    {
        $validated = $request->validated();

        $device->update($validated);
        $device->rack()->associate($validated['rack_id'] ?? null);
        $device->save();

        return response()->json(new DeviceResource($device));
    }

    public function destroy(Device $device): JsonResponse
    {
        $device->delete();

        return response()->json(null, 204);
    }
}
