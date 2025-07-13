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
        Schema::create('evaluation_employee_data', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('alternatif')->nullable();
            $table->string('email');
            $table->string('departement');
            $table->string('employeementStatus');
            $table->year('evaluation_years');
            $table->string('evaluation_stage'); // nilai: T1, T2, T3, T4
            // $table->decimal('total_score', 8, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_employee_data');
    }
};
