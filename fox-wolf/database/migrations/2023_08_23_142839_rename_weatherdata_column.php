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
        // rename city_name to location_name
        Schema::table('weatherdata', function (Blueprint $table) {
            $table->renameColumn('city_name', 'location_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // rename reversed
        Schema::table('weather_data', function (Blueprint $table) {
            $table->renameColumn('location_name', 'city_name');
        });
    }
};
