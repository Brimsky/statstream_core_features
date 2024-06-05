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
        Schema::create('user_listings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('seller_company_name');
            $table->string('speacies');
            $table->string('class');
            $table->string('sertificate');
            $table->integer('diameter');
            $table->float('length');
            $table->string('seller');
            $table->string('location');
            $table->string('price');
            $table->string('type');
            $table->string('seller_url');
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_listings');
    }
};
