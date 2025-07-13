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
        Schema::create('final_score_totals', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('alternatif')->nullable();
            $table->string('evaluation_years')->nullable();
            $table->decimal('score_t1', 8, 4)->nullable();
            $table->decimal('score_t2', 8, 4)->nullable();
            $table->decimal('score_t3', 8, 4)->nullable();
            // $table->decimal('score_t4', 8, 4)->nullable();
            $table->decimal('final_score_total', 8, 4)->nullable();
            $table->string('information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_score_totals');
    }
};
