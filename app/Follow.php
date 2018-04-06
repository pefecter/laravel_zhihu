<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'user_question';
    /**
     * 定义
     *
     * @var array
     */
    protected $fillable = ['user_id','question_id'];
}
