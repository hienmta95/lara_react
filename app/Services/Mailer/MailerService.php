<?php

namespace App\Services\Mailer;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class MailerService
{
    protected $from;

    public function __construct()
    {
        $this->from = [
            'name' => env('MAIL_FROM_NAME'),
            'address' => env('MAIL_FROM_ADDRESS')
        ];
    }

    public function handle(Mailable $mail)
    {
        if (empty($mail->from)) {
            $mail->from($this->from['address'], $this->from['name']);
        }
        Mail::queue($mail);
    }
}
