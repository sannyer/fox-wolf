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
        // rename table weatherdata to weather_data
        Schema::rename('weatherdata', 'weather_data');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // rename reversed
        Schema::rename('weather_data', 'weatherdata');
    }
};
