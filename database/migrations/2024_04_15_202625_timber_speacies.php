<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timber_species', function (Blueprint $table) {
            $table->id();
            $table->string('speacies');
            $table->string('class');
            $table->integer('diameter');
            $table->float('length');
            $table->string('seller');
            $table->string('location');
            $table->string('price');
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timber_species');
    }
};
