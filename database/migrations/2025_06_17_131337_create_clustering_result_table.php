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
        Schema::create('clustering_result', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('evaluation_years');
            $table->decimal('final_score_total', 8, 4);
            $table->decimal('distance_c1', 8, 4)->nullable();
            $table->decimal('distance_c2', 8, 4)->nullable();
            $table->decimal('distance_c3', 8, 4)->nullable();
            $table->decimal('closest_distance', 8, 4)->nullable();
            $table->string('cluster')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clustering_result');
    }
};
