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
        Schema::create('mouvement_corps', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('corps_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('date_heure_depart');
            $table->string('Lieu_Départ');
            $table->dateTime('date_heure_arrivee');
            $table->string('lieu_arrivee');
            $table->string('responsable_mouvement');
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
        Schema::dropIfExists('mouvement_corps');
    }
};
