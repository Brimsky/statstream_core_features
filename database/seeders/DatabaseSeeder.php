<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TimberSeeder::class,
            UserSeeder::class,
            UpdateTimberSpeciesSeeder::class, // Include the new seeder here
        ]);
    }
}
