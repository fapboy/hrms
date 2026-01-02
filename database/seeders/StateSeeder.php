<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/states.json');

        $json = file_get_contents($path);

        if ($json === false) {
            throw new \RuntimeException("Cannot read file: {$path}");
        }

        $states = json_decode($json, true);
        $malaysiaId = DB::table('countries')->where('name', 'Malaysia')->value('id');

        if (!is_array($states)) {
            throw new \RuntimeException("Invalid JSON structure in states.json");
        }
        if(!$malaysiaId){
            throw new \RuntimeException("Malaysia not found in countries table");
        }

        foreach ($states as $state) {
            DB::table('states')->insert([
                'name' => $state,
                'country_id' => $malaysiaId,
            ]);
        }
    }
}
