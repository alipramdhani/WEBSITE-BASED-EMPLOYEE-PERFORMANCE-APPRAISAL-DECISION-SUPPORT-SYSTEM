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
        Schema::create('centroid_first', function (Blueprint $table) {
            $table->id();
            $table->string('evaluation_years');
            $table->string('selected');
            $table->string('centroid');
            $table->decimal('final_score_total', 8, 4);
            $table->enum('status', ['Awal', 'Akhir'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centroid_first');
    }
};
