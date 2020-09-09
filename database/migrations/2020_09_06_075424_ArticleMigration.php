<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticleMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("article", function (Blueprint $table){
           $table->increments('id');
           $table->string('title')->notNull();
           //简介
           $table->string('desc')->notNull();
           $table->text('content')->notNull();
           $table->integer('ctime')->notNull();
           $table->integer('mtime')->notNull();
           $table->integer('uid')->notNull();
           $table->tinyInteger('state')->notNull();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('article');
    }
}
