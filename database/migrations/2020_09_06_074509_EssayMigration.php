<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EssayMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("essay", function (Blueprint $table){
            //创建字段
            //id uid content ctime mtime
            $table->increments('id');
            $table->integer('uid')->notNull();
            $table->string('content')->notNull();
            $table->integer('ctime')->notNull();
            $table->integer('mtime')->notNull();
            //评论内容的状态 0删除 1正常
            $table->tinyInteger('essay_state')->notNull();
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
        Schema::dropIfExists("essay");
    }
}
