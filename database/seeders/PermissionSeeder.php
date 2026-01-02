<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/permissions.json');

        $json = file_get_contents($path);
        if ($json === false) {
            throw new \RuntimeException("Cannot read {$path}");
        }

        $permissions = json_decode($json, true);
        if (!is_array($permissions)) {
            throw new \RuntimeException("Invalid permissions.json");
        }

        foreach ($permissions as $permission) {
            if (!isset($permission['key'])) {
                throw new \RuntimeException("Permission key is required");
            }

            DB::table('permissions')->updateOrInsert(
                ['key' => $permission['key']],
                [
                    'description' => $permission['description'] ?? null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }
    }
}
