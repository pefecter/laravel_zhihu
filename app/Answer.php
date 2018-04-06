<?php

namespace App;

use App\User;
use App\Question;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * 定义
     *
     * @var array
     */
    protected $fillable = ['user_id','body','question_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    public function question()
    {
        return $this->belongsTo(Question::class);
    } 


}
