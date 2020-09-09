<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClickLikeStat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("user_likes_stat", function (Blueprint $table){
            $table->increments('id');
            //点赞的内容类型，短文、长文
            $table->string('content_type')->notNull();
            //点赞的内容id
            $table->integer("content_id")->notNull();
            //点赞总数
            $table->integer("count")->notNull();
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
        Schema::dropIfExists("click_likes_stat");
    }
}
