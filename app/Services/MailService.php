<?php

namespace App\Services;

use Mail;
use Naux\Mail\SendCloudTemplate;
use App\Models\User;

class MailService{

    public function sendTo($template, $email, array $data)
    {
        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use ($email) {
            $message->from('564774252@qq.com', 'Bilibili');
            $message->to($email);
        });
    }

    /**
     * @param User $user
     */
    public function verify(User $user)
    {
        $data = [
            'url'  => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name
        ];

        $this->sendTo('bilibili_verify_template', $user->email, $data);
    }

    /**
     * @param $email
     * @param $token
     */
    public function passwordReset($email, $token)
    {
        $data = ['url' => url('password/reset', $token)];

        $this->sendTo('bilibili_password_reset', $email, $data);
    }

}