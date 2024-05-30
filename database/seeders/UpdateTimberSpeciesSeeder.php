<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UpdateTimberSpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $species = ['Ozols', 'Apse', 'Bērzs', 'Alksnis', 'Egle', 'Priedes', 'Melnalksnis'];
        $classes = ['A', 'B', 'C', 'Brāķis', 'Tara'];
        $lengths = [4.9, 3.7, 3.1, 2.5, 2.9, 3.0, 3.3, 2.8];
        $sellers = ['Bono', 'Osukalns', 'ABCTimber', 'Marko', 'Baltukoks', 'Pata'];
        $locations = ['Rīga', 'Daugavpils', 'Cesis', 'Valmiera', 'Drusti', 'Salacgrīva', 'Mērsrags', 'Jēkabpils', 'Gulbene'];
        $types = ['Finieris', 'Papīrmalka', 'Malka', 'Gūlsnis', 'Zāģbaļķi'];

        DB::table('timber_species')->where('price', '<', 100)->update([
            'price' => DB::raw('price + 10'),
        ]);

        // Add new records
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'speacies' => $faker->randomElement($species),
                'class' => $faker->randomElement($classes),
                'diameter' => $faker->numberBetween(10, 50),
                'length' => $faker->randomElement($lengths),
                'seller' => $faker->randomElement($sellers),
                'location' => $faker->randomElement($locations),
                'price' => $faker->numberBetween(40, 120),
                'type' => $faker->randomElement($types),
                'date' => $faker->date(),
            ];
        }

        DB::table('timber_species')->insert($data);
    }
}
