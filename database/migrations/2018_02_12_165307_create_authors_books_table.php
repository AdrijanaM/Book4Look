<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors_books', function (Blueprint $table) {
            $table->increments('idauthors_books');
            $table->integer('FK_authors')->unsigned()->nullable();
            $table->integer('FK_books')->unsigned()->nullable();
        });

        Schema::table('authors_books', function (Blueprint $table){
            $table->foreign('FK_authors')->references('id')->on('authors');
            $table->foreign('FK_books')->references('idbook')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors_books');
    }
}
