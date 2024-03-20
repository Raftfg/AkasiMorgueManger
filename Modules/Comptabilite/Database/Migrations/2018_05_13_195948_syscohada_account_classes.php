<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SyscohadaAccountClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saccount_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('num')->unique();
            $table->string('libelle');
            $table->timestamps();
            $table->softDeletes();

            $table->uuid('uuid')->unique(); //nullable parce que la migration est impossible
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saccount_classes');
    }
}