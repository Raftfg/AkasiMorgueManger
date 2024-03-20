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
        Schema::create('corps', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('nom_defunt');
            $table->string('prenom_defunt');
            $table->date('date_naissance');
            $table->date('date_deces');
            $table->string('lieu_deces');
            $table->string('etat_corps');
            $table->string('cause_décès');
            $table->unsignedBigInteger('morgue_id');
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('morgue_id')->references('id')->on('morgues')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corps');
    }
};
