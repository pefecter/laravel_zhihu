<?php

namespace App\Mailer;

use Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer 
{

    /**
     * sendTo function
     * 发送邮件
     *
     * @param [type] $template 模板名称
     * @param [type] $email  邮箱地址
     * @param array $data   邮件内容
     * @return void
     */
    protected function sendTo($template,$email,array $data)
    {

        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use($email) {
            $message->from('360312735@qq.com', 'Yu');
            $message->to($email);
        });
    }
}
