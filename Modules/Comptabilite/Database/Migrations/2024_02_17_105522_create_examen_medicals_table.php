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
        Schema::create('examen_medicals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('corps_id');
            $table->unsignedBigInteger('user_id');
            $table->date('date_examen');
            $table->string('resultat_examen');
            $table->string('medecin');
            $table->timestamps();
            $table->foreign('corps_id')->references('id')->on('corps')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_medicals');
    }
};
