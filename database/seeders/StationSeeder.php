<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        // Borey Main Gate      3 / 5  => normal
        // Community Park       1 / 5  => low
        // Local Supermarket    0 / 5  => empty
        // Kids Park            6 / 5  => overloaded
        // Sports Park          0 / 5  => refilling
        $stations = [
            [
                'name' => 'Borey Main Gate',
                'address' => 'Borey Peng Huoth Main Gate',
                'latitude' => 11.5329000,
                'longitude' => 104.9567000,
                'status' => 'normal',
            ],
            [
                'name' => 'Community Park',
                'address' => 'Community Park Zone',
                'latitude' => 11.5341000,
                'longitude' => 104.9582000,
                'status' => 'low',
            ],
            [
                'name' => 'Local Supermarket',
                'address' => 'Supermarket Zone',
                'latitude' => 11.5318000,
                'longitude' => 104.9551000,
                'status' => 'empty',
            ],
            [
                'name' => 'Kids Park',
                'address' => 'Kids Park Area',
                'latitude' => 11.5307000,
                'longitude' => 104.9574000,
                'status' => 'overloaded',
            ],
            [
                'name' => 'Sports Park',
                'address' => 'Sports Park Zone',
                'latitude' => 11.5356000,
                'longitude' => 104.9546000,
                'status' => 'refilling',
            ],
        ];

        foreach ($stations as $station) {
            Station::create([
                ...$station,
                'capacity' => 5,
            ]);
        }
    }
}
