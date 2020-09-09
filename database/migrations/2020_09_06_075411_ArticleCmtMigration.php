<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticleCmtMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("article_cmt", function (Blueprint $table){
            $table->increments('id');
            $table->integer('article_id')->notNull();
            $table->integer('cmt_uid')->notNull();
            $table->integer('pub_uid')->notNull();
            $table->integer('cmt_id')->notNull();
            $table->string('cmt_content')->notNull();
            $table->integer('ctime')->notNull();
            $table->integer('mtime')->notNull();
            //评论内容的状态 0删除 1正常
            $table->tinyInteger('cmt_state')->notNull();
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
        Schema::dropIfExists('article_cmt');
    }
}
