<?php

namespace App\Mailer;

use Mail;
use App\User;
use Naux\Mail\SendCloudTemplate;
use Illuminate\Support\Facades\Auth;

class UserMailer extends Mailer
{
    /**
     * followNotifyEmail function
     * 发送关注邮件
     * @param [type] $email
     * @return void
     */
    public function followNotifyEmail($email)
    {

        $data = [
            'url' =>'http://dev.zhihu',
            'name' => Auth::guard('api')->user()->name,
        ];
       
        $this->sendTo('test_template_followed',$email,$data);
    }

    /**
     * passwordReset function
     * 发送重置密码邮件
     * @param [type] $token
     * @param [type] $email
     * @return void
     */
    public function passwordReset($email,$token)
    {

        $data = [
            'url' => url('password/reset', $token),
        ];
       
        $this->sendTo('test_template_password_rest',$email,$data);
    }

    /**
     * welcome function
     * 注册发送邮件
     * @param User $user
     * @return void
     */
    public function welcome(User $user)
    {

        $data = [
            'url' => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name,
        ];
       
        $this->sendTo('test_template_active',$user->email,$data);
    }
}
