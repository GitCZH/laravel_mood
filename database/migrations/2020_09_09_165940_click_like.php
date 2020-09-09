<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClickLike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("user_likes", function (Blueprint $table){
            $table->increments('id');
            //点赞的内容类型，短文、长文
            $table->string('content_type')->notNull();
            //点赞的用户id
            $table->integer('click_uid')->notNull();
            //为user点赞的用户id
            $table->integer('for_uid')->notNull();
            //点赞的内容id
            $table->integer("content_id")->notNull();
            //点赞时间
            $table->integer("ctime")->notNull();
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
        Schema::dropIfExists("user_likes");
    }
}
