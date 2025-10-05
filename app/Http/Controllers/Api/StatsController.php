<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Rack;

class StatsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
    // totals
    $locationCount = Location::query()->count();
    $rackCount = Rack::query()->count();

        // timeseries for the last 30 days (created_at)
        $days = 30;
        $start = now()->subDays($days - 1)->startOfDay();

        $locationSeries = Location::query()
            ->selectRaw("date(created_at) as day, count(*) as count")
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('count', 'day')
            ->toArray();

        $rackSeries = Rack::query()
            ->selectRaw("date(created_at) as day, count(*) as count")
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('count', 'day')
            ->toArray();

        $labels = [];
        $locationCounts = [];
        $rackCounts = [];

        for ($i = 0; $i < $days; $i++) {
            $day = $start->copy()->addDays($i)->toDateString();
            $labels[] = $day;
            $locationCounts[] = isset($locationSeries[$day]) ? (int) $locationSeries[$day] : 0;
            $rackCounts[] = isset($rackSeries[$day]) ? (int) $rackSeries[$day] : 0;
        }

        return response()->json([
            'totals' => [
                'locations' => $locationCount,
                'racks' => $rackCount,
            ],
            'series' => [
                'labels' => $labels,
                'locations' => $locationCounts,
                'racks' => $rackCounts,
            ],
        ]);
    }
}
