<?php

namespace App\Notifications;

use Mail;
use App\Mailer\UserMailer;
use Illuminate\Bus\Queueable;
use Naux\Mail\SendCloudTemplate;
use App\Channels\SendcloudChannel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',SendcloudChannel::class];
    }


    /**
     * toSendcloud function
     * 关注作者后发送邮件通知
     * @param [type] $notifiable
     * @return void
     */
    public function toSendcloud($notifiable)
    {
       (new UserMailer())->followNotifyEmail($notifiable->email);
    }

    /**
     * 站内信息
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
       return [
           'name' => Auth::guard('api')->user()->name,
       ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
