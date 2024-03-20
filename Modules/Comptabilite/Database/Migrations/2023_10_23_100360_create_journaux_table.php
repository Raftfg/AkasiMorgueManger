<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournauxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journaux', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('libelle');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('compte_debit_id')->nullable();
            $table->unsignedBigInteger('compte_credit_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->uuid('uuid')->unique();

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
        Schema::dropIfExists('journaux');
    }
}
