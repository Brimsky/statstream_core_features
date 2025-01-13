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
        Schema::create('timber_prices', function (Blueprint $table) {
            $table->id();
            $table->string('date', 20);          // YYYY-MM-DD format
            $table->string('seller', 100);       // Limit seller name length
            $table->string('species', 50);       // Limit species name length
            $table->string('type', 50);          // Limit type length
            $table->string('class', 50);         // Limit class length
            $table->float('length');             // Numeric, no length limit needed
            $table->string('diameter', 20);      // Limit diameter format
            $table->string('location', 100);     // Limit location length
            $table->float('price');              // Numeric, no length limit needed
            $table->timestamps();

            // Create separate indexes for better performance
            $table->index('date');
            $table->index('seller');
            $table->index('species');
            $table->index('location');
            
            // Create a composite index for commonly queried fields
            $table->index(['species', 'date'], 'timber_species_date_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timber_prices');
    }
};
