<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Station;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function byStation(Station $station)
    {
        $bikes = $station->bikes()
            ->orderBy('id')
            ->get()
            ->map(function ($bike) {
                return $this->bikeResponse($bike);
            });

        return response()->json([
            'station' => [
                'id' => $station->id,
                'name' => $station->name,
                'status' => $station->status,
            ],
            'data' => $bikes,
        ], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bikes = Bike::orderBy('id')
            ->get()
            ->map(function ($bike) {
                return $this->bikeResponse($bike);
            });

        return response()->json([
            'data' => $bikes,
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
    public function show(Bike $bike)
    {
        return response()->json([
            'data' => $this->bikeResponse($bike),
        ], 200);
    }

    private function bikeResponse(Bike $bike): array
    {
        return [
            'id' => $bike->id,
            'station_id' => $bike->station_id,
            'code' => $bike->code,
            'name' => $bike->name,
            'type' => $bike->type,
            'status' => $bike->status,
            'battery_level' => $bike->battery_level,
            'base_price' => $bike->base_price,
            'base_minute' => $bike->base_minute,
            'extra_price' => $bike->extra_price,
            'extra_minute' => $bike->extra_minute,
            'description' => $bike->description,
        ];
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
