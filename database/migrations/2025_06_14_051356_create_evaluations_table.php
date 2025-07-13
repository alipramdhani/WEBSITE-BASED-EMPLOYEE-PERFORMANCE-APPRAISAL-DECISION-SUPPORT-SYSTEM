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
        foreach (['t1', 't2', 't3'] as $tahap) {
            Schema::create("evaluations_$tahap", function (Blueprint $table) {
                $table->id();
                $table->string('alternatif')->nullable();
                $table->string('evaluation_years');
                for ($i = 1; $i <= 15; $i++) {
                    $table->float("C$i")->nullable();
                }
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['t1', 't2', 't3', 't4'] as $tahap) {
            Schema::dropIfExists("evaluations_$tahap");
        }
    }
};
