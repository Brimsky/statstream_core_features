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
        Schema::create('saved_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('liked_material')->nullable(); // Assuming this is optional
            $table->boolean('notify_status');
            $table->timestamps();

            // Assuming 'liked_material' refers to a 'timber' table id
            $table->foreign('liked_material')->references('id')->on('timber_species')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("saved_materials");
    }
};
