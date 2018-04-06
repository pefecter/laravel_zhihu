<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            $table->integer('user_id')->unsigned();
            $table->integer('comment_count')->default(0); //评论总数
            $table->integer('followers_count')->default(1); //关注总数
            $table->integer('answers_count')->default(0); //回答总数
            $table->string('close_comment',8)->default('F'); //是否可以评论
            $table->string('is_hidden',8)->default('F'); //是否隐藏
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
