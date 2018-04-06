<?php

namespace App;

use Mail;
use App\Answer;
use App\Follow;
use App\Message;
use App\Question;
use App\Mailer\UserMailer;
use Naux\Mail\SendCloudTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token','api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */ 
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 判断是否为本人
     * owns function.
     *
     * @param Model $model
     */
    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * follows function
     *
     * @param 
     * @return void
     */
    public function follows()
    {
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    /**
     * followThis function
     *
     * @param [type] $question
     * @return void
     */
    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }

     /**
     * followed function
     * 是否关注该问题
     *
     * @param [type] $question
     * @return bool
     */
    public function followed($question)
    {
        return !! $this->follows()->where('question_id',$question)->count();
    }


    /**
     * followers function
     * 关注者
     *
     * @return void
     */
    public function followers()
    {
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }

     /**
     * followers function
     * 关注该作者
     *
     * @return void
     */
    public function followersUser()
    {
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }


    /**
     * followThisUser function
     * 关注该作者
     * @param [type] $user
     * @return void
     */
    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }


    /**
     * votes function
     * 点赞答案关联
     *
     * @return void
     */
    public function votes()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();
    }


     /**
     * voteFor function
     * 点赞答案
     *
     * @return void
     */
    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    /**
     * hasVotedFor function
     * 是否点赞过答案
     *
     * @param [type] $answer 
     * @return boolean
     */
    public function hasVotedFor($answer)
    {
        return !! $this->votes()->where('answer_id',$answer)->count();
    }


    public function message()
    {
        return $this->hasMany(Message::class,'to_user_id');
    }


    public function answers()
    {
        return $this->hasMany(Answer::class);
    } 

    /**
     * 发送忘记密码邮件.
     *
     * @param [type] $token
     * @param [type] $email
     */
    public function sendPasswordResetNotification($token)
    {
        (new UserMailer())->passwordReset($this->email,$token);
    }
}
