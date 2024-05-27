<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Int;
use Illuminate\Support\Facades\DB;


class TimberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('timber_species')->insert([
            'speacies' => Str::random(10),
            'class' => Str::random(10).'a'.'c'.'d',
            
        ]);
    }
}



            // $table->id();
            // $table->string('speacies');
            // $table->string('class');
            // $table->integer('diameter');
            // $table->float('length');
            // $table->string('seller');
            // $table->string('location');
            // $table->string('price');
            // $table->string('type');
            // $table->date('date');