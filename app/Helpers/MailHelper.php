<?php

namespace App\Helpers;

class MailHelper
{
    public static function sendMail($subject, $to, $title, $content, $template = '/mail_templates/template'){
        $array = [
            'title' => $title,
            'content'=> $content,
        ];
        \Illuminate\Support\Facades\Mail::send($template, $array, function ($message) use ($to, $subject) {
            $message->from(env('MAIL_USERNAME'), 'REVERSE');
            $message->subject($subject);
            $message->to($to);
        });
    }
}
