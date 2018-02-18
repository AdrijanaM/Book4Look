<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_quotes', function (Blueprint $table) {
            $table->increments('idusers_quotes');
            $table->integer('FK_users')->unsigned()->nullable();
            $table->integer('FK_quotes')->unsigned()->nullable();
        });

        Schema::table('users_quotes', function (Blueprint $table){
           $table->foreign('FK_users')->references('id')->on('users');
           $table->foreign('FK_quotes')->references('id')->on('quotes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_quotes');
    }
}
