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
        // rename weatherdata table column long to lon
        Schema::table('weatherdata', function (Blueprint $table) {
            $table->renameColumn('long', 'lon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // rename weatherdata table column long to lon
        Schema::table('weatherdata', function (Blueprint $table) {
            $table->renameColumn('lon', 'long');
        });
    }
};
