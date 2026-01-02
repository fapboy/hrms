<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
$path = database_path('data/cities.json');

        $json = file_get_contents($path);

        if ($json === false) {
            throw new \RuntimeException("Cannot read file: {$path}");
        }

        $citiesByState = json_decode($json, true);

        if (!is_array($citiesByState)) {
            throw new \RuntimeException("Invalid JSON structure in cities.json");
        }

        $stateMap = DB::table('states')->pluck('id', 'name');

        foreach ($citiesByState as $stateName => $cities) {

            if (!isset($stateMap[$stateName])) {
                continue;
            }

            foreach ($cities as $city) {
                DB::table('cities')->insert([
                    'state_id' => $stateMap[$stateName],
                    'name' => $city,
                ]);
            }
        }
    }
}
