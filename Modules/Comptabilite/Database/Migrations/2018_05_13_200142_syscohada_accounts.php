<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SyscohadaAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saccounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('num')->unique();
            $table->string('libelle');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('saccount_class_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->uuid('uuid')->unique(); //nullable parce que la migration est impossible
            
            $table->foreign('saccount_class_id')->references('id')->on('saccount_classes')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });

        Schema::table('saccounts', function (Blueprint $table) {
            $table->foreign('parent_id')->references('num')->on('saccounts')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saccounts');
    }
}