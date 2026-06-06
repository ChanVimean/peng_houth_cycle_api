<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stations = Station::withCount([
            'bikes',
            'bikes as available_bikes_count' => function ($query) {
                $query->where('status', 'available');
            },
        ])->get()->map(function ($station) {
            return $this->stationResponse($station);
        });

        return response()->json([
            'data' => $stations,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Station $station)
    {
        $station->load('bikes');

        return response()->json([
            'data' => $this->stationResponse($station, true),
        ]);
    }

    private function stationResponse(Station $station, bool $withBikes = false): array
    {
        $bikeCount = $station->bikes_count ?? $station->bikes->count();
        $availableBikeCount = $station->available_bikes_count
            ?? $station->bikes->where('status', 'available')->count();
        $capacity = max($station->capacity, 1);

        $data = [
            'id' => $station->id,
            'name' => $station->name,
            'address' => $station->address,
            'latitude' => $station->latitude,
            'longitude' => $station->longitude,
            'capacity' => $station->capacity,
            'bikes_count' => $availableBikeCount,
            'status' => $this->stationStatus($station, $bikeCount),
            'remaining_capacity' => max($capacity - $bikeCount, 0),
            'over_capacity_count' => max($bikeCount - $capacity, 0),
        ];

        if ($withBikes) {
            $data['bikes'] = $station->bikes;
        }

        return $data;
    }

    private function stationStatus(Station $station, int $bikeCount): string
    {
        // unavailable => manual database status
        // refilling   => manual database status
        // 0 bikes     => empty
        // 1-30%       => low
        // over 100%   => overloaded
        // else        => normal

        if (in_array($station->status, ['unavailable', 'refilling'], true)) {
            return $station->status;
        }

        if ($bikeCount === 0) {
            return 'empty';
        }

        if ($bikeCount > $station->capacity) {
            return 'overloaded';
        }

        $usagePercent = ($bikeCount / max($station->capacity, 1)) * 100;

        if ($usagePercent <= 30) {
            return 'low';
        }

        return 'normal';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
