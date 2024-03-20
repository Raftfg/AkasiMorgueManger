<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcrituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecritures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('libelle');
            $table->float('montant', 15, 2);
            $table->string('description')->nullable();
            $table->float('taxe', 4, 2)->nullable()->default(0);
            $table->dateTime('date');
            // $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('exercice_id');
            $table->unsignedBigInteger('devise_id');
            $table->unsignedBigInteger('journal_id');
            $table->unsignedBigInteger('ligne_id')->nullable();
            $table->unsignedBigInteger('compte_debit_id')->nullable();
            $table->unsignedBigInteger('compte_credit_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->uuid('uuid')->unique();

            // $table->foreign('document_id')->references('id')->on('documents')->restrictOnDelete();
            $table->foreign('exercice_id')->references('id')->on('exercices')->restrictOnDelete();
            $table->foreign('devise_id')->references('id')->on('devises')->restrictOnDelete();
            $table->foreign('journal_id')->references('id')->on('journaux')->restrictOnDelete();
            $table->foreign('ligne_id')->references('id')->on('lignes')->restrictOnDelete();
            $table->foreign('compte_debit_id')->references('id')->on('saccounts')->restrictOnDelete();
            $table->foreign('compte_credit_id')->references('id')->on('saccounts')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecritures');
    }
}
