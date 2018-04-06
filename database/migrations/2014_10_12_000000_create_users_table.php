<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar');  //头像
            $table->string('confirmation_token');  //邮箱验证
            $table->smallInteger('is_active')->default(0);  //是否激活
            $table->integer('question_count')->default(0);  //问题总数
            $table->integer('answers_count')->default(0);  //回答总数
            $table->integer('comments_count')->default(0);  //评论总数
            $table->integer('favorites_count')->default(0);  //收藏总数
            $table->integer('likes_count')->default(0);  //点赞总数
            $table->integer('followers_count')->default(0);  //关注总数
            $table->integer('followings_count')->default(0);  //被关注总数
            $table->string('settings')->nullabel();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
