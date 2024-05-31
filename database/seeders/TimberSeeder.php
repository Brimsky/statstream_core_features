<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TimberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $speacies = ['Ozols', 'Apse', 'Bērzs', 'Alksnis', 'Egle', 'Priedes', 'Melnalksnis'];
        $classes = ['A', 'B', 'C', 'Brāķis', 'Tara'];
        $lengths = [4.9, 3.7, 3.1, 2.5, 2.9, 3.0, 3.3, 2.8];
        $sellers = ['Bono', 'Osukalns', 'Marko', 'Baltukoks', 'Pata'];
        $locations = ['Rīga', 'Daugavpils', 'Cesis', 'Valmiera', 'Drusti', 'Salacgrīva', 'Mērsrags', 'Jēkabpils', 'Gulbene'];
        $types = ['Finieris', 'Papīrmalka', 'Malka', 'Gūlsnis', 'Zāģbaļķi'];

        $sellerUrls = [
            'Bono' => 'https://www.bonotimber.com/pakalpojumi/apalkoka-tirdznieciba',
            'Osukalns' => 'https://www.osukalns.lv/lv/apalkoka-iepirksana/',
            'Marko' => 'https://marko.lv/ieperkam/ieperk-apalkoku/',
            'Baltukoks' => 'https://baltukoks.lv/apalkokus/',
            'Pata' => 'https://patatimber.lv/?gad_source=1&gclid=CjwKCAjwx-CyBhAqEiwAeOcTdbLZQkzvFrDl2S6PSDfFO_xoEIBnR0wzMAldLlB-HAYMykl7dvhmnBoCVz8QAvD_BwE'
        ];

        $data = [];

        foreach (range(10, 60) as $diameter) {
            for ($i = 0; $i < 300 / (60 - 10 + 1); $i++) {
                $seller = $faker->randomElement($sellers);
                $data[] = [
                    'speacies' => $faker->randomElement($speacies),
                    'class' => $faker->randomElement($classes),
                    'diameter' => $diameter,
                    'length' => $faker->randomElement($lengths),
                    'seller' => $seller,
                    'location' => $faker->randomElement($locations),
                    'price' => $faker->numberBetween(40, 120),
                    'type' => $faker->randomElement($types),
                    'date' => $faker->date(),
                    'url' => $sellerUrls[$seller], // Assign the pre-defined URL for each seller
                ];
            }
        }

        DB::table('timber_species')->insert($data);
    }
}
