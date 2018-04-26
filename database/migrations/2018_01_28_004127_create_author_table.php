<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->integer('id', 11);
            $table->string('fullName',50);
            $table->string('idAuthor',45);
            $table->string('gender',45);
            $table->string('worksCount');
            $table->text('about');
            $table->integer('userId');
            $table->string('image');
            $table->string('homeTown');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
