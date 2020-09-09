<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EssayCmtMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("essay_cmt", function (Blueprint $table){
            $table->increments('id');
            $table->integer('essay_id')->notNull();
            //评论用户id
            $table->integer('cmt_uid')->notNull();
            //原文发布用户id
            $table->integer('pub_uid')->notNull();
            //评论父id
            $table->integer("cmt_id")->notNull();
            $table->string("cmt_content")->notNull();
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
        Schema::dropIfExists('essay_cmt');
    }
}
