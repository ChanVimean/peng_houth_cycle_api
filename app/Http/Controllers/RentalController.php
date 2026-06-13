<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rentals = $request->user()->rentals()
            ->latest('started_at')
            ->get();

        return response()->json([
            'data' => $rentals,
        ], 200);
    }

    /**
     * Display a listing of all rentals (admin only).
     */
    public function allRentals()
    {
        $rentals = Rental::latest('started_at')->get();

        return response()->json([
            'data' => $rentals,
        ], 200);
    }

    /**
     * Start a new rental (rent a bike).
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'bike_id' => ['required', 'integer', 'exists:bikes,id'],
            ]);

            $user = $request->user();

            if ($user->rentals()->where('status', 'active')->exists()) {
                return response()->json([
                    'message' => 'You already have an active rental.',
                ], 422);
            }

            $bike = Bike::findOrFail($validated['bike_id']);

            if ($bike->status !== 'available') {
                return response()->json([
                    'message' => 'This bike is not available.',
                ], 422);
            }

            $rental = Rental::create([
                'user_id' => $user->id,
                'bike_id' => $bike->id,
                'pickup_station_id' => $bike->station_id,
                'started_at' => now(),
                'status' => 'active',
                'base_price' => $bike->base_price,
                'base_minute' => $bike->base_minute,
                'extra_price' => $bike->extra_price,
                'extra_minute' => $bike->extra_minute,
            ]);

            $bike->update([
                'status' => 'in_use',
                'station_id' => null,
            ]);

            return response()->json([
                'message' => 'Rental started',
                'data' => $rental,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    /**
     * Return the bike and complete the rental.
     */
    public function returnBike(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'return_station_id' => ['required', 'integer', 'exists:stations,id'],
        ]);

        if ($rental->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        if ($rental->status !== 'active') {
            return response()->json([
                'message' => 'This rental is not active.',
            ], 422);
        }

        $endedAt = now();
        $durationMinute = max((int) ceil($rental->started_at->diffInSeconds($endedAt) / 60), 1);

        $totalPrice = (float) $rental->base_price;

        if ($durationMinute > $rental->base_minute) {
            $extraMinutes = $durationMinute - $rental->base_minute;
            $extraUnits = (int) ceil($extraMinutes / $rental->extra_minute);
            $totalPrice += $extraUnits * (float) $rental->extra_price;
        }

        $rental->update([
            'return_station_id' => $validated['return_station_id'],
            'ended_at' => $endedAt,
            'duration_minute' => $durationMinute,
            'total_price' => $totalPrice,
            'status' => 'completed',
        ]);

        $rental->bike->update([
            'status' => 'available',
            'station_id' => $validated['return_station_id'],
        ]);

        return response()->json([
            'message' => 'Rental completed',
            'data' => $rental,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
