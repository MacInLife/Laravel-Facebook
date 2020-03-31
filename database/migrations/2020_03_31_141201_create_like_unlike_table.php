<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeUnlikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_unlike', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('post_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_unlike');
    }
}
