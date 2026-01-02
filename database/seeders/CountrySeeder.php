<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/countries.json');

        $json = file_get_contents($path);
        if ($json === false) {
            throw new \RuntimeException("Cannot read {$path}");
        }

        $countries = json_decode($json, true);
        if (!is_array($countries)) {
            throw new \RuntimeException("Invalid countries.json");
        }

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'name' => $country,
            ]);
        }
    }
}
