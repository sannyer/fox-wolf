<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('weatherdata', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('city_name');
            $table->foreignId('city_id'); // Foreign key reference to cities table
            $table->string('temperature');
            $table->integer('pressure');
            $table->integer('humidity');
            $table->string('lat');
            $table->string('long');
            $table->float('min_temp');
            $table->float('max_temp');
            $table->foreign('city_id') // Define the foreign key constraint
                  ->references('id')
                  ->on('city')
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
