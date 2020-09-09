<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'uid', 'nickname', 'avatar', 'ctime', 'born', 'sex', 'age', 'user_state'
        Schema::create("user_info", function (Blueprint $table){
            $table->increments('id');
            $table->integer("uid")->notNull();
            $table->integer("age")->notNull();
            $table->integer("ctime")->notNull();
            $table->tinyInteger("user_state")->notNull();
            $table->string('nickname')->notNull();
            $table->string('avatar')->notNull();
            $table->integer('born');
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
        Schema::dropIfExists("user_info");
    }
}
