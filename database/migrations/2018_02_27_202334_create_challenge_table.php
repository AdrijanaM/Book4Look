<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numberOfBooks');
            $table->integer('idOfSender', 11);
            $table->integer('idOfReceiver', 11);
//            $table->timestamps();
        });

//        Schema::table('challenges', function (Blueprint $table){
//            $table->foreign('idOfSender')->references('id')->on('users');
//            $table->foreign('idOfReceiver')->references('id')->on('users');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenges');
    }
}
