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
        Schema::create('weatherdata', function (Blueprint $table) {
            $table->id();
            // city name, and lat long for weather api
            // city foreign key to id of city table
            $table->foreignId('city_id')->constrained('city');
            $table->string('lat');
            $table->string('long');
            // weather data
            $table->string('temperature');
            $table->string('pressure');
            $table->string('humidity');
            $table->string('min_temp');
            $table->string('max_temp');
            $table->timestamps();
            $table->foreign('city_id') // Define the foreign key
                    ->references('id')
                    ->on('cities')
                    ->onDelete('cascade'); // Optional: Define what happens on delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weatherdata');
    }
};
