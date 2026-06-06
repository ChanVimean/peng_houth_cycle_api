<?php

namespace Database\Seeders;

use App\Models\Bike;
use App\Models\Station;
use Illuminate\Database\Seeder;

class BikeSeeder extends Seeder
{
    public function run(): void
    {
        $stations = Station::all()->keyBy('name');

        $bikeNumber = 1;

        $createBike = function (string $stationName, string $type = 'electric', ?int $batteryLevel = 100) use ($stations, &$bikeNumber) {
            Bike::create([
                'station_id' => $stations->get($stationName)?->id,
                'code' => sprintf('BIKE-%03d', $bikeNumber),
                'name' => sprintf('%s Bike %03d', ucfirst($type), $bikeNumber),
                'type' => $type,
                'status' => 'available',
                'battery_level' => $type === 'electric' ? $batteryLevel : null,
                'base_price' => $type === 'electric' ? 1.00 : 0.50,
                'base_minute' => 15,
                'extra_price' => $type === 'electric' ? 0.25 : 0.10,
                'extra_minute' => 5,
                'description' => $type === 'electric'
                    ? 'Electric bike for short city rides.'
                    : 'Normal pedal bike for short city rides.',
            ]);

            $bikeNumber++;
        };

        // 3 / 5 bikes: normal
        $createBike('Borey Main Gate', 'electric', 95);
        $createBike('Borey Main Gate', 'electric', 88);
        $createBike('Borey Main Gate', 'normal');

        // 1 / 5 bikes: low
        $createBike('Community Park', 'electric', 76);

        // 0 / 5 bikes: empty
        // Local Supermarket intentionally has no bikes.

        // 6 / 5 bikes: overloaded
        $createBike('Kids Park', 'electric', 100);
        $createBike('Kids Park', 'electric', 92);
        $createBike('Kids Park', 'electric', 84);
        $createBike('Kids Park', 'normal');
        $createBike('Kids Park', 'normal');
        $createBike('Kids Park', 'electric', 68);

        // Manual refilling status
        // Sports Park intentionally has no bikes.
    }
}
